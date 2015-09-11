<?php
namespace FelixOnline\API;

use \FelixOnline\Exceptions;

/*
 * Frontpage Controller
 */
class frontpageController extends BaseController {
    function GET($matches) {
        if(array_key_exists('sec', $matches)) { // if specific section - by section name
            try {
                $sec = new \FelixOnline\Core\FrontpageManager();
                $sec = $sec->getSection($matches['sec']);
            } catch (\Exception $e) {
                throw new \NotFoundException(
                    $e->getMessage(),
                    $matches,
                    'API-FrontpageController'
                );
            }

            if(!$sec) {
                throw new \NotFoundException(
                    "No articles found",
                    $matches,
                    'API-FrontpageController'
                );
            }

            foreach($sec as $object) {
                $article = new FrontpageHelper($object);
                $output[] = $article->getOutput();
            }

            API::output(
                $output
            );
        } else {
            try {
                $sec = new \FelixOnline\Core\FrontpageManager();
                $sec = $sec->getAll();
            } catch (\Exception $e) {
                throw new \NotFoundException(
                    $e->getMessage(),
                    array(),
                    'API-FrontpageController'
                );
            }

            foreach($sec as $object) {
                $article = new FrontpageHelper($object);
                $output[] = $article->getOutput();
            }

            API::output(
                $output
            );
        }
    }
}
?>
