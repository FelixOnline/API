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
        unset($output['user']);

        // reply
        if($output['reply']) {
            $output['reply'] = $output['reply']->getId();
        }

        // number of replies
        $output['numReplies'] = $this->this->getNumValidatedReplies();

        return $output;
    }
}
