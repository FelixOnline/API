<?php

class UserHelper extends BaseHelper {
    public function getOutput($that) {
        $output = parent::getOutput($that);
        unset($output['visits']);
        unset($output['ip']);
        unset($output['timestamp']);
        return $output;
    }
}
