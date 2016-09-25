<?php
namespace FelixOnline\API;

/*
 * Comment Controller
 */
class commentController extends BaseController {
    function GET($matches) {
        $paginatorWrapper = new \FelixOnline\API\PaginatorWrapper('id');

        if(array_key_exists('id', $matches)) { // if specific comment
            try {
                $Comment = new \FelixOnline\Core\Comment($matches['id']);
                if(!$Comment->isAccessible() || $Comment->isRejected() || !$Comment->isEmailValid()) {
                    throw new \FelixOnline\Exceptions\InternalException('This comment cannot be found as either the comment or its parent is moderated out or has an invalid email');
                }
            } catch (\Exception $e) {
                throw new \NotFoundException(
                    'This comment cannot be found.',
                    $matches,
                    'API-CommentController'
                );
            }

            if(!$Comment->getArticle()->getPublished()) {
                throw new \NotFoundException(
                    'This comment cannot be found.',
                    $matches,
                    'API-CommentController'
                );
            }

            $Comment = new CommentHelper($Comment);
            $output = $Comment->getOutput();

            API::output(
                $output
            );
        } else if(array_key_exists('replies', $matches)) { // if specific comment
            try {
                $Comment = new \FelixOnline\Core\Comment($matches['replies']);

                if(!$Comment->isAccessible() || $Comment->isRejected() || !$Comment->isEmailValid()) {
                    throw new \FelixOnline\Exceptions\InternalException('This comment cannot be found as either the comment or its parent is moderated out or has an invalid email');
                }
            } catch (\Exception $e) {
                throw new \NotFoundException(
                    'This comment cannot be found.',
                    $matches,
                    'API-CommentController'
                );
            }

            if(!$Comment->getArticle()->getPublished()) {
                throw new \Exception('Article does not exist');
            }

            $output = array();

            try {
                $manager = $Comment->getValidatedReplyManager();

                $values = $paginatorWrapper->setManager($manager)->values();
            } catch (\Exception $e) {
                throw new \NotFoundException(
                    'No comments found.',
                    $matches,
                    'API-CommentController'
                );
            }

            foreach($values as $object) {
                $Comment = new CommentHelper($object);
                $output[] = $Comment->getOutput();
            }

            API::output(
                $output,
                $paginatorWrapper->since(), 
                $paginatorWrapper->max()
            );
        } else if(array_key_exists('article', $matches)) { // article comments
            try {
                $article = new \FelixOnline\Core\Article($matches['article']);
            } catch (\Exception $e) {
                throw new \NotFoundException(
                    'This article cannot be found.',
                    $matches,
                    'API-CommentController'
                );
            }

            $output = array();

            try {
                $manager = \FelixOnline\Core\BaseManager::build('\FelixOnline\Core\Comment', 'comment');
                $manager->filter('article = %i', array($article->getId()))
                        ->filter('active = 1')
                        ->filter('reply IS NULL')
                        ->order('timestamp', 'DESC');

                $validation = \FelixOnline\Core\BaseManager::build('FelixOnline\Core\EmailValidation', 'email_validation')
                    ->filter("confirmed = 1");

                $manager->join($validation, null, 'email', 'email');

                $values = $paginatorWrapper->setManager($manager)->values();
            } catch (\Exception $e) {
                throw new \NotFoundException(
                    'No comments found.',
                    $matches,
                    'API-CommentController'
                );
            }

            foreach($values as $object) {
                $Comment = new CommentHelper($object);
                $output[] = $Comment->getOutput();
            }

            API::output(
                $output,
                $paginatorWrapper->since(), 
                $paginatorWrapper->max()
            );
        } else {
            throw new \NotFoundException(
                'Not implemented.',
                $matches,
                'API-CommentController'
            );
        }
    }
}
?>
