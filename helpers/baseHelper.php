<?php
namespace FelixOnline\API;

class BaseHelper {
    protected $this;

    function __construct($that) {
        $this->this = $that;
    }

    /*
     * Get class output to be used in api
     */
    public function getOutput() {
        $fields = $this->this->getFields();

        $final_fields = array();

        foreach($fields as $key => $object) {
            try {
                $final_fields[$key] = $object->getValue();
            } catch(\FelixOnline\Exceptions\ModelNotFoundException $e) {
                $final_fields[$key] = null; // Foreign key does not exist
            }
        }

        return $final_fields;
    }
}
