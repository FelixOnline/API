<?php
namespace FelixOnline\API;

use \FelixOnline\Exceptions;

/*
 * Category Controller
 */
class categoryController extends BaseController {
    function GET($matches) {
        global $db;
        if(array_key_exists('id', $matches)) { // if specific section - by id
            try {
                $category = new CategoryHelper(new \FelixOnline\Core\Category($matches['id']));
            } catch (\Exception $e) {
                throw new \NotFoundException(
                    $e->getMessage(),
                    $matches,
                    'API-CategoryController'
                );
            }

            $output = $category->getOutput();

            API::output(
                $output
            );
        } else if(array_key_exists('cat', $matches)) { // if specific section - by cat name
            try {
                $category = (new \FelixOnline\Core\CategoryManager())
                    ->filter('cat = "%s"', array($matches['cat']))
                    ->filter('secret = 0')
                    ->one();
            } catch (\Exception $e) {
                throw new \NotFoundException(
                    $e->getMessage(),
                    $matches,
                    'API-CategoryController'
                );
            }

            $category = new CategoryHelper($category);
            $output = $category->getOutput();

            API::output(
                $output
            );
        } else {
            $output = array();

            try {
                $cats = (new \FelixOnline\Core\CategoryManager())
                    ->filter('hidden = 0')
                    ->filter('id > 0')
                    ->filter('secret = 0')
                    ->order('order', 'ASC')
                    ->values();
            } catch (\Exception $e) {
                throw new \NotFoundException(
                    'No categories found.',
                    $matches,
                    'API-CategoryController'
                );
            }

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
