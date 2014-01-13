<?php
namespace API\Model;

class Article extends \FelixOnline\Core\Article
{
    use \API\Output\JSON;
    use \API\Output\Hidden;

    protected $hidden = array(
        'text2',
        'img2',
        'img2lr',
        'text1',
        'img1',
        'author',
        'approvedby',
    );

    protected $types = array(
        'id' => 'int',
        'category' => 'int',
        'date' => 'int',
        'published' => 'int',
        'hidden' => 'boolean',
        'searchable' => 'boolean',
        'hits' => 'int',
        'image' => 'int',
        'comment_num' => 'int',
    );

    /**
     * Hydrate model
     */
    protected function hydrate()
    {
        $this->setUrl($this->getURL());

        $authors = array();
        foreach ($this->getAuthors() as $author) {
            $authors[] = $author->getUser();
        }
        $this->setAuthors($authors);

        $this->setContent(strip_tags($this->getContent()));
        $this->setContentHtml($this->getContent());
        $this->setImage($this->fields['img1']);

        $this->setCommentNum($this->getNumComments());

        $comments = array();
        foreach ($this->getComments() as $comment) {
            $c = new \API\Model\Comment($comment->getId());
            $comments[] = $c->toJSON();
        }
        $this->setComments($comments);
    }
}
