<?php

class BaseHelper {
    /*
     * Get class output to be used in api
     */
    public function getOutput($that) {
        return $that->getFields();
    }
}
