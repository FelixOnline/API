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
    );

    public function toJSON()
    {
        $output = array();
        foreach ($this->fields as $field => $value) {
            if (!in_array($field, $this->hidden)) {
                $output[$field] = $value;
            }
        }

        $output['content'] = strip_tags($this->getContent());
        $output['content_html'] = $this->getContent();
        $output['image'] = $this->fields['img1'];

        return $output;
    }
}
