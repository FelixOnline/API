<?php
namespace FelixOnline\API;

class IssueHelper extends BaseHelper {
    protected $this;

    function __construct($that) {
        $this->this = $that;
    }

    /*
     * Get output for the list of issues view
     */
    public function getOutput() {
        $output = parent::getOutput();

        unset($output['inactive']);

        $output['publication'] = (new PublicationHelper($this->this->getPublication()))->getOutput();
        $output['url'] = $this->this->getUrl();
        $output['download-url'] = $this->this->getDownloadUrl();

        return $output;
    }

    /*
     * Get output for the specific issue view
     */
    public function getExtendedOutput() {
        $initial = $this->getOutput();
        $extended = array();

        $file = $this->this->getPrimaryFile();

        $extended['thumbnail-url'] = $file->getThumbnailURL();
        $extended['thumbnail'] = $file->getThumbnail();
        $extended['file-url'] = $file->getFilename();
        $extended['file'] = $file->getOnlyFilename();

        return array_merge($initial, $extended);
    }
}
