<?php
/*
 * Blog Controller
 */
class blogController extends BaseController {
    function GET($matches) {
        if(array_key_exists('name', $matches)) { // if specific article
            $blog = new Blog($matches['name']);
            $output = $blog->getOutput();

            RestUtils::sendResponse(
                200, 
                json_encode($output), 
                'application/json'
            );
        } else {
            echo 'All blogs';
        }
    }
}

?>
