<?php
namespace API\Model;

class Article extends \FelixOnline\Core\Article
{
    protected $hidden = array(
        'text2',
        'img2',
        'img2lr',
        'text1',
        'img1',
        'author',
        'approvedby',
    );

    public function toJSON()
    {
        $output = array();
        foreach ($this->fields as $field => $value) {
            if (!in_array($field, $this->hidden)) {
                $output[$field] = $value;
            }
        }

        $output['authors'] = array();
        $authors = $this->getAuthors();

        foreach ($authors as $author) {
            $output['authors'][] = $author->getUser();
        }

        $output['content'] = strip_tags($this->getContent());
        $output['content_html'] = $this->getContent();
        $output['image'] = $this->fields['img1'];

        $output['comment_num'] = $this->getNumComments();

        $comments = $this->getComments();

        $output['comments'] = array();
        foreach ($comments as $comment) {
            $c = new \API\Model\Comment($comment->getId());
            $output['comments'][] = $c->toJSON();
        }

        return $output;
    }
}
