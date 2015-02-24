<?php
namespace FelixOnline\API;

/*
 * Documentation Controller
 */
class docsController {
    function GET() {
        global $currentuser;
        require_once(API_DIRECTORY.'/docs/markdown.php');
        require_once(API_DIRECTORY.'/docs/docs.php');
    }
}
