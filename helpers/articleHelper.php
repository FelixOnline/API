<?php
namespace FelixOnline\API;

class ArticleHelper extends BaseHelper {
    public function getOutput() {
        $output = parent::getOutput();

        // authors
        unset($output['author']);
        $output['authors'] = array();
        foreach($this->this->getAuthors() as $key => $author) {
            $author = new UserHelper($author);
            $output['authors'][$key] = $author->getOutput();
        }

        // approved by
        unset($output['reviewedby']);

        // content
        unset($output['text1']);

        try {
            $output['content'] = \Utility::tidyText($this->this->getContent());
            $output['raw_content'] = $this->this->getContent();
        } catch(\Exception $e) {
            $output['content'] = "Couldn't load this article's content.";
            $output['raw_content'] = "Couldn't load this article's content.";
        }

        // image
        unset($output['img1']);
        $output['image'] = null;
        if($this->this->getImage()) {
            $image = new ImageHelper($this->this->getImage());
            $output['image'] = $image->getOutput();
        }

        // category
        $category = new CategoryHelper($this->this->getCategory());
        $output['category'] = $category->getOutput();

        // url
        $output['url'] = $this->this->getURL();

        // number of comments
        $output['comment_count'] = $this->this->getNumComments();

        // comments
        $output['comments'] = null;
        foreach($this->this->getComments() as $key => $object) {
            $object = new CommentHelper($object);
            $output['comments'][$key] = $object->getOutput();
        }

        unset($output['comment_status']);
        unset($output['searchable']);
        unset($output['blog']);

        return $output;
    }
}
