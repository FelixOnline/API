<?php
namespace FelixOnline\API;

class ImageHelper extends BaseHelper {
    public function getOutput() {
        $output = parent::getOutput();

        unset($output['uri']);
        $output['url'] = $this->this->getURL();
        $output['name'] = $this->this->getName();

        unset($output['user']);

        unset($output['v_offset']);
        unset($output['h_offset']);

        return $output;
    }
}
