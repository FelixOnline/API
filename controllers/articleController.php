<?php
namespace FelixOnline\API;

/*
 * Article Controller
 */
class articleController extends BaseController {
    function GET($matches) {
        global $db;
        if(array_key_exists('id', $matches)) { // if specific article
            try {
                $art = new \FelixOnline\Core\Article($matches['id']);
                $article = new ArticleHelper($art);
            } catch (\Exception $e) {
                throw new \NotFoundException(
                    $e->getMessage(),
                    $matches,
                    'API-ArticleController'
                );
            }

            if($art->getCategory()->getSecret() || !$art->getPublished()) {
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
                    'This category cannot be found.',
                    $matches,
                    'API-ArticleController'
                );
            }

            $output = array();

            try {
                $manager = (new \FelixOnline\Core\ArticleManager())
                    ->filter('published < NOW()')
                    ->order('published', 'DESC')
                    ->filter('category = %i', array($category->getId()))
                    ->limit(0, 10);
            } catch (\Exception $e) {
                throw new \NotFoundException(
                    'No articles found.',
                    $matches,
                    'API-ArticleController'
                );
            }

            foreach($manager->values() as $object) {
                $article = new ArticleHelper($object);
                $output[] = $article->getOutput();
            }

            API::output(
                $output
            );
        } else {
            $output = array();

            try {
                $manager = (new \FelixOnline\Core\ArticleManager())
                    ->filter('published < NOW()')
                    ->order('published', 'DESC')
                    ->limit(0, 10);
            } catch (\Exception $e) {
                throw new \NotFoundException(
                    'No articles found.',
                    $matches,
                    'API-ArticleController'
                );
            }

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
