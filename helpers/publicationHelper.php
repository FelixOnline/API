<?php
namespace FelixOnline\API;

class PublicationHelper extends BaseHelper {
    public function getOutput() {
        $output = parent::getOutput();

        unset($output['inactive']);

        return $output;
    }
}
