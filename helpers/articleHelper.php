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
        unset($output['approvedby']);
        //$output['approvedby'] = $this->this->getApprovedBy()->getOutput();

        // content
        unset($output['text1']);

        $converter = new \Sioen\Converter();

        $text = preg_replace('/<p[^>]*><\\/p[^>]*>/i', '', $converter->toHTML($this->this->getContent()));
        $text = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $text); // Some <p>^B</p> tags can get through some times

        // More text tidying
        $text = strip_tags($text, '<p><a><div><b><i><br><blockquote><object><param><embed><li><ul><ol><strong><img><h1><h2><h3><h4><h5><h6><em><iframe><strike>'); // Gets rid of html tags except <p><a><div>
        $text = preg_replace('/(<br(| |\/|( \/))>)/i', '', $text); // strip br tag
        $text = preg_replace('#<div[^>]*(?:/>|>(?:\s|&nbsp;)*</div>)#im', '', $text); // Removes empty html div tags
        $text = preg_replace('#<span*(?:/>|>(?:\s|&nbsp;)[^>]*</span>)#im', '', $text); // Removes empty html span tags
        $text = preg_replace('#<p[^>]*(?:/>|>(?:\s|&nbsp;)*</p>)#im', '', $text); // Removes empty html p tags
        $output['content'] = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $text); // Remove style attributes

        $output['raw_content'] = $this->this->getContent();

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

        return $output;
    }
}
