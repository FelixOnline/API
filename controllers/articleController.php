<?php
namespace FelixOnline\API;

/*
 * Article Controller
 */
class articleController extends BaseController {
    function GET($matches) {
        global $db;
        if(array_key_exists('id', $matches)) { // if specific article
            $art = new \FelixOnline\Core\Article($matches['id']);
            $article = new ArticleHelper($art);

            if($art->getCategory()->getSecret()) {
                throw new \Exception('No model in database');
            }

            $output = $article->getOutput();

            API::output(
                $output
            );
        } else if(array_key_exists('cat', $matches)) { // category articles
            try {
                $category = (new \FelixOnline\Core\CategoryManager())
                    ->filter('cat = "%s"', array($matches['cat']))
                    ->filter('secret = 0') // API for now does not support authentication
                    ->one();
            } catch (\Exception $e) {
                throw new \NotFoundException(
                    $e->getMessage(),
                    $matches,
                    'API-ArticleController'
                );
            }

            $output = array();

            $manager = (new \FelixOnline\Core\ArticleManager())
                ->filter('published < NOW()')
                ->order('published', 'DESC')
                ->filter('category = %i', array($category->getId()))
                ->limit(0, 10);

            foreach($manager->values() as $object) {
                $article = new ArticleHelper($object);
                $output[] = $article->getOutput();
            }

            API::output(
                $output
            );
        } else {
            $output = array();

            $manager = (new \FelixOnline\Core\ArticleManager())
                ->filter('published < NOW()')
                ->order('published', 'DESC')
                ->limit(0, 10);

            foreach($manager->values() as $object) {
                $article = new ArticleHelper($object);
                $output[] = $article->getOutput();
            }

            API::output(
                $output
            );
        }
    }
}
?>
