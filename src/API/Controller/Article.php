<?php
namespace API\Controller;

class Article extends \SlimController\SlimController
{
    public function indexAction()
    {
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

    public function articleAction($id)
    {
        $article = new \API\Model\Article($id);
        $this->app->render(200, $article->toJSON());
    }
}
