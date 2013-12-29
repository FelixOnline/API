<?php
namespace API\Controller;

class Article extends \SlimController\SlimController
{
    public function indexAction()
    {
        if ($this->app->request->isPost()) {
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
            $article->setAuthors($authors);

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
        $this->app->render(200, $article->toJSON());
    }
}
