<?php
namespace API\Controller;

class Article extends \SlimController\SlimController
{
    public function indexAction($id)
    {
        $article = new \API\Model\Article($id);

        $this->app->render(200, $article->toJSON());
    }
}
