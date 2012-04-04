<?php
/*
 * Index Controller
 */
class indexController {
    function GET() {
        require_once(API_DIRECTORY.'/documentation/frontpage.php');
    }
}
