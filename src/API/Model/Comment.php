<?php
namespace API\Model;

class Comment extends \FelixOnline\Core\Comment
{
    use \API\Output\JSON;
    use \API\Output\Hidden;

    protected $hidden = array(
        'ip',
        'active',
        'pending',
        'spam',
    );

    protected $types = array(
        'id' => 'int',
        'article' => 'int',
        'timestamp' => 'int',
        'reply' => 'int',
        'likes' => 'int',
        'dislikes' => 'int',
    );

    /**
     * Hydrate model
     */
    public function hydrate()
    {
        $this->setUrl($this->getURL());
    }
}
