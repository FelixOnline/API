<?php
/*
 * Blog Controller
 */
class blogController extends BaseController {
    function GET($matches) {
        if(array_key_exists('name', $matches)) { // if specific article
            $blog = new Blog($matches['name']);
            $output = array(
                'name' => $blog->getName()
            );

            foreach($blog->getPosts(1) as $key => $post) {
                $output['posts'][$key] = array(
                    'content' => $post->getContent(),
                    'timestamp' => $post->getTimestamp(),
                    'type' => $post->getType(),
                    'meta' => $post->getMeta()
                );
                // TODO
                $output['posts'][$key]['author'] = array(
                    'name' => $post->getAuthor()->getName(),
                    'uname' => $post->getAuthor()->getUser(),
                    'url' => $post->getAuthor()->getURL() 
                );
            }

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
