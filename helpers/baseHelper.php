<?php

class BaseHelper {
    protected $this;

    function __construct($that) {
        $this->this = $that;
    }

    /*
     * Get class output to be used in api
     */
    public function getOutput() {
        return $this->this->getFields();
    }
}
