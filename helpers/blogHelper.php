<?php

class BlogHelper extends BaseHelper {
    public function getOutput() {
        $output = parent::getOutput();

        // get posts
        $output['posts'] = array();
        foreach($this->this->getPosts(1) as $key => $post) {
            $output['posts'][$key] = $post->getOutput();
        }
        return $output;
    }
}
