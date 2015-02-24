<?php
namespace FelixOnline\API;

class IssueHelper {
    protected $this;

    function __construct($that) {
        $this->this = $that;
    }

    /*
     * Get output for the list of issues view
     */
    public function getOutput() {
        return $this->this->getOutput();
    }


    /*
     * Get output for the specific issue view
     */
    public function getExtendedOutput() {
        $initial = $this->this->getOutput();
        $extended = array();

        $extended['thumbnail-url'] = $this->this->getThumbnailURL();
        $extended['thumbnail'] = $this->this->getThumbnail();
        $extended['file-url'] = $this->this->getFile();
        $extended['file'] = $this->this->getFileName();

        return array_merge($initial, $extended);
    }
}
