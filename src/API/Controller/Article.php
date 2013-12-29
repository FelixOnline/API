<?php
namespace API\Controller;

class Article extends \SlimController\SlimController
{
    public function indexAction()
    {
        // Creating new article
        if ($this->app->request->isPost()) {
            // Authentication
            \API\Authentication::authenticateForRole(
                \API\Authentication::getUser(),
                \API\Authentication::WEB_EDITOR
            );

            // Create new article
            $params = $this->app->request->params();
            $required = array(
                'title',
                'authors',
                'category',
                'content',
                'teaser',
            );

            foreach($required as $r) {
                if (!array_key_exists($r, $params)) {
                    throw new \Exception('Required parameter "'.$r.'" is not defined');
                }
            }

            // Content
            $content = $params['content'];
            unset($params['content']);

            // Authors
            $authors = array();
            foreach($params['authors'] as $author) {
                $authors[] = new \FelixOnline\Core\User($author);
            }
            unset($params['authors']);

            $article = new \FelixOnline\Core\Article();
            $article->setFields($params);
            $article->setContent($content);
            $id = $article->save();

            // Assign authors
            $article->addAuthors($authors);

            $this->app->render(200, array(
                'id' => $id
            ));
        } else {
            $articleManager = new \API\Model\ArticleManager();

            $articles = $articleManager->filter(
                array(
                    'published IS NOT NULL',
                    'published < NOW()',
                ),
                20,
                array('published', 'DESC')
            );

            $output = [];

            foreach ($articles as $article) {
                $output[] = $article->toJSON();
            }

            $this->app->render(200, $output);
        }
    }

    public function articleAction($id)
    {
        $article = new \API\Model\Article($id);

        // Patching exisiting article
        if ($this->app->request->isPatch()) {
            // Authentication
            \API\Authentication::authenticateForRole(
                \API\Authentication::getUser(),
                \API\Authentication::WEB_EDITOR
            );

            // Hack to get slim to parse form data from patch
            $env = $this->app->environment();
            $env['slim.method_override.original_method'] = 'POST';

            $vars = $this->app->request()->post();

            foreach ($vars as $param => $value) {
                if ($param == 'content') {
                    $article->setContent($value);
                } else if ($param == 'authors') {
                    $authors = array();
                    foreach($params['authors'] as $author) {
                        $authors[] = new \FelixOnline\Core\User($author);
                    }
                    $article->addAuthors($authors);
                } else {
                    $article->setField($param, $value);
                }
            }

            $article->save();
            unset($env['slim.method_override.original_method']);
        }

        $this->app->render(200, $article->toJSON());
    }
}
