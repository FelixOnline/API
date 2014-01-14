<?php
namespace API\Output;

/**
 * JSON trait
 */
trait JSON {
    public function toJSON()
    {
        $this->hydrate();

        $output = $this->getFields();

        if (isset($this->types)) {
            foreach($this->types as $key => $type) {
                settype($output[$key], $type);
            }
        }

        return $output;
    }
}
