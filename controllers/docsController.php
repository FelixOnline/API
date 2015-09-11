<?php
namespace FelixOnline\API;

/*
 * Documentation Controller
 */
class docsController {
    function GET() {
        require_once(API_DIRECTORY.'/docs/markdown.php');
        require_once(API_DIRECTORY.'/docs/docs.php');
    }
}
