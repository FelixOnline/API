<?php
namespace FelixOnline\API;

/*
 * Category Controller
 */
class categoryController extends BaseController {
    function GET($matches) {
        global $db;
        if(array_key_exists('id', $matches)) { // if specific section - by id
            $category = new CategoryHelper(new \FelixOnline\Core\Category($matches['id']));
            $output = $category->getOutput();

            API::output(
                $output
            );
        } else if(array_key_exists('cat', $matches)) { // if specific section - by cat name
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

            $category = new CategoryHelper($category);
            $output = $category->getOutput();

            API::output(
                $output
            );
        } else {
            $output = array();

            $cats = (new \FelixOnline\Core\CategoryManager())
                ->filter('hidden = 0')
                ->filter('id > 0')
                ->order('order', 'ASC')
                ->values();

            foreach($cats as $object) {
                $category = new CategoryHelper($object);
                $output[] = $category->getOutput();
            }

            API::output(
                $output
            );
        }
    }
}
?>
