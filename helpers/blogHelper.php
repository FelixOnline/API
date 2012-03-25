<?php

class BlogHelper extends BaseHelper {
    public function getOutput($that) {
        $output = parent::getOutput($that);

        // get posts
        $output['posts'] = array();
        foreach($that->getPosts(1) as $key => $post) {
            $post->import('BlogPostHelper');
            $output['posts'][$key] = $post->getOutput();
        }
        return $output;
    }
}
