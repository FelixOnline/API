<?php
namespace FelixOnline\API;

/*
 * Index Controller
 */
class indexController {
    function GET() {
        require_once(API_DIRECTORY.'/docs/frontpage.php');
    }
}
