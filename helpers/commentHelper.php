<?php
namespace FelixOnline\API;

class CommentHelper extends BaseHelper {
    public function getOutput() {
        $output = parent::getOutput();

        unset($output['article']);
        unset($output['external']);
        unset($output['ip']);
        unset($output['email']);
        unset($output['useragent']);
        unset($output['referer']);
        unset($output['active']);
        unset($output['pending']);
        unset($output['spam']);

        // user
        if($output['user']) {
            $object = new UserHelper($this->this->getUser());
            $output['name'] = $object->getOutput()['name'];
            unset($output['user']);
        }

        // reply
        if($output['reply']) {
            $object = new CommentHelper($this->this->getReply());
            $output['reply'] = $object->getOutput();
        }

        return $output;
    }
}
