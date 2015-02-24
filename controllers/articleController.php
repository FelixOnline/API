<?php
namespace FelixOnline\API;

/*
 * Article Controller
 */
class articleController extends BaseController {
    function GET($matches) {
        global $db;
        if(array_key_exists('id', $matches)) { // if specific article
            $article = new ArticleHelper(new \FelixOnline\Core\Article($matches['id']));
            $output = $article->getOutput();

            API::output(
                $output
            );
        } else if(array_key_exists('cat', $matches)) { // category articles
            try {
                $category = (new \FelixOnline\Core\CategoryManager())
                    ->filter('cat = "%s"', array($matches['cat']))
                    ->one();
            } catch (Exceptions\InternalException $e) {
                throw new Exceptions\NotFoundException(
                    $e->getMessage(),
                    Exceptions\UniversalException::EXCEPTION_NOTFOUND,
                    $e
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
