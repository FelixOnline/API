<?php
namespace FelixOnline\API;

class UserHelper extends BaseHelper {
    public function getOutput() {
        $output = parent::getOutput();
        unset($output['visits']);
        unset($output['ip']);
        unset($output['timestamp']);
        unset($output['role']);

        if(!$this->this->getShowLdap()) {
            unset($output['info']);
        }

        if(!$this->this->getShowEmail()) {
            unset($output['email']);
        }

        unset($output['show_email']);
        unset($output['show_ldap']);

        // images
        $output['image'] = null;
        if($this->this->getImage()) {
            $image = new ImageHelper($this->this->getImage());
            $output['image'] = $image->getOutput();
        }

        return $output;
    }
}
