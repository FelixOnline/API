<?php
namespace API\Model;

class Comment extends \FelixOnline\Core\Comment
{
    protected $hidden = array(
        'ip',
        'active',
        'pending',
        'spam',
    );

    public function toJSON()
    {
        $output = array();
        foreach ($this->fields as $field => $value) {
            if (!in_array($field, $this->hidden)) {
                $output[$field] = $value;
            }
        }

        return $output;
    }
}
