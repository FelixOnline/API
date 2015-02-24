<?php
namespace FelixOnline\API;

/*
 * Frontpage Controller
 */
class frontpageController extends BaseController {
    function GET($matches) {
        global $db;
        if(array_key_exists('sec', $matches)) { // if specific section - by section name
            try {
                $sec = new \FelixOnline\Core\FrontpageManager();
                $sec = $sec->getSection($matches['sec']);
            } catch (Exceptions\InternalException $e) {
                throw new Exceptions\NotFoundException(
                    $e->getMessage(),
                    Exceptions\UniversalException::EXCEPTION_NOTFOUND,
                    $e
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
                $sec = \FelixOnline\Core\BaseManager::build('\FelixOnline\Core\Frontpage', 'frontpage');
                $sec = $sec->values();
            } catch (Exceptions\InternalException $e) {
                throw new Exceptions\NotFoundException(
                    $e->getMessage(),
                    Exceptions\UniversalException::EXCEPTION_NOTFOUND,
                    $e
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
