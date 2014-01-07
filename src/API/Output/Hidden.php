<?php
namespace API\Output;

/**
 * Hidden trait
 */
trait Hidden {
    public function getFields()
    {
        $output = array();

        if (isset($this->hidden)) {
            foreach ($this->fields as $field => $value) {
                if (!in_array($field, $this->hidden)) {
                    $output[$field] = $value;
                }
            }
        } else {
            $output = $this->fields;
        }

        return $output;
    }
}
