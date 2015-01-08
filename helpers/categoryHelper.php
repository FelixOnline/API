<?php
namespace FelixOnline\API;

class CategoryHelper extends BaseHelper {
    public function getOutput() {
        $output = parent::getOutput();
        unset($output['uri']); 
        unset($output['colourclass']); 
        unset($output['active']); 
        unset($output['hidden']);
        unset($output['description']);
        
        $i = 1;
        for($i; $i <=4; $i++) {
            unset($output['top_slider_'.$i]); 
            unset($output['top_sidebar_'.$i]); 
        }

        $output['editors'] = array();

        if($this->this->getEditors()) {
            foreach($this->this->getEditors() as $key => $editors) {
                $editors = new UserHelper($editors);
                $output['editors'][$key] = $editors->getOutput();
            }
        }

        return $output;
    }
}
