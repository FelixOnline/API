<?php

class BlogPostHelper extends BaseHelper {
    public function getOutput() {
        $output = parent::getOutput();

        $output['meta'] = unserialize($output['meta']);
        
        $author = new User($output['author']);
        $output['author'] = $author->getOutput();
        return $output;
    }
}
