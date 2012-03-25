<?php

class ArticleHelper extends BaseHelper {
    public function getOutput() {
        $output = parent::getOutput();
        unset($output['author']);
        $output['authors'] = array();
        foreach($this->this->getAuthors() as $key => $author) {
            $output['authors'][$key] = $author->getOutput();
        }

        $output['approvedby'] = $this->this->getApprovedBy()->getOutput();

        $output['image'] = '';
        if($this->this->getImage()) {
            $output['image'] = $this->this->getImage()->getOutput();
        }
        return $output;
    }
}
