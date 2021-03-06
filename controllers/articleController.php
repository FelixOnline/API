<?php
namespace FelixOnline\API;

/*
 * Article Controller
 */
class articleController extends BaseController {
    function GET($matches) {
        $paginatorWrapper = new \FelixOnline\API\PaginatorWrapper('id', 'article_publication');

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

            if(!$art->getPublished()) {
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
                    ->enablePublishedFilter()
                    ->filter('category = %i', array($category->getId()));

                $values = $paginatorWrapper->setManager($manager)->values();
            } catch (\Exception $e) {
                throw new \NotFoundException(
                    'No articles found.',
                    $matches,
                    'API-ArticleController'
                );
            }

            foreach($values as $object) {
                $article = new ArticleHelper($object);
                $output[] = $article->getOutput();
            }

            API::output(
                $output,
                $paginatorWrapper->since(),
                $paginatorWrapper->max()
            );
        } else if(array_key_exists('user', $matches)) { // category articles
            try {
                $userManager = \FelixOnline\Core\BaseManager::build('FelixOnline\Core\ArticleAuthor', 'article_author');
                $userManager->filter('author = "%s"', array($matches['user']));

                $manager = (new \FelixOnline\Core\ArticleManager())
                    ->enablePublishedFilter();

                $manager->join($userManager, null, null, 'article');

                $values = $paginatorWrapper->setManager($manager)->values();
            } catch (\Exception $e) {
                throw new \NotFoundException(
                    'No articles found.',
                    $matches,
                    'API-ArticleController'
                );
            }

            foreach($values as $object) {
                $article = new ArticleHelper($object);
                $output[] = $article->getOutput();
            }

            API::output(
                $output,
                $paginatorWrapper->since(),
                $paginatorWrapper->max()
            );
        } else {
            $output = array();

            try {
                $manager = (new \FelixOnline\Core\ArticleManager())
                    ->enablePublishedFilter();

                $values = $paginatorWrapper->setManager($manager)->values();
            } catch (\Exception $e) {
                throw new \NotFoundException(
                    'No articles found.',
                    $matches,
                    'API-ArticleController'
                );
            }

            foreach($values as $object) {
                $article = new ArticleHelper($object);
                $output[] = $article->getOutput();
            }

            API::output(
                $output,
                $paginatorWrapper->since(),
                $paginatorWrapper->max()
            );
        }
    }
}
?>
