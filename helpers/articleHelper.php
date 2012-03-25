<?php

class ArticleHelper extends BaseHelper {
    public function getOutput() {
        $output = parent::getOutput();

        // authors
        unset($output['author']);
        $output['authors'] = array();
        foreach($this->this->getAuthors() as $key => $author) {
            $output['authors'][$key] = $author->getOutput();
        }

        // approved by
        $output['approvedby'] = $this->this->getApprovedBy()->getOutput();

        // content
        unset($output['text1']);
        unset($output['text2']);
        $output['content'] = $this->this->getContent();

        // image
        unset($output['img1']);
        unset($output['img2']);
        unset($output['img2lr']);
        $output['image'] = '';
        if($this->this->getImage()) {
            $output['image'] = $this->this->getImage()->getOutput();
        }

        // category
        $output['category'] = $this->this->getCategory()->getOutput();
        return $output;
    }
}
