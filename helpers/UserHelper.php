<?php

class UserHelper extends BaseHelper {
    public function getOutput() {
        $output = parent::getOutput();
        unset($output['visits']);
        unset($output['ip']);
        unset($output['timestamp']);
        unset($output['role']);

        // images
        $output['image'] = null;
        if($this->this->getImage()) {
            $image = new ImageHelper($this->this->getImage());
            $output['image'] = $image->getOutput();
        }

        return $output;
    }
}
