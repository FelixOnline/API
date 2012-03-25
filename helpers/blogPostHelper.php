<?php

class BlogPostHelper extends BaseHelper {
    public function getOutput($that) {
        $output = parent::getOutput($that);

        $output['meta'] = unserialize($output['meta']);
        
        $author = new User($output['author']);
        $author->import('UserHelper');
        $output['author'] = $author->getOutput();
        return $output;
    }
}
