<?php

class UserHelper extends BaseHelper {
    public function getOutput() {
        $output = parent::getOutput();
        unset($output['visits']);
        unset($output['ip']);
        unset($output['timestamp']);
        unset($output['role']);

        return $output;
    }
}
