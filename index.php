<?php
	/*
		Felix Online API
			Author: Jonathan Kim
			Date: 24/05/11
			Version: 0.1
	*/

    // bootstrap Felix environment
    require_once("../inc/common.inc.php");
	//require_once("inc/config.inc.php");
	//require_once("inc/functions.php");
	//require_once("inc/const.php");
    require_once("inc/Rest.php");
    require_once("glue.php");
    //require_once("inc/XmlWriter.php"); // removed because it wasn't working

    $urls = array(
        '/' => 'indexController',
        '/article' => 'articleController',
        '/article/([a-zA-Z0-9]+)' => 'articleController'
    );

    class indexController {
        function GET() {
            echo 'Hello';
        }
    }

    class articleController {
        function GET($matches) {
            echo 'article';
            var_dump($matches); 
        }
    }

    glue::stick($urls);

    /*
    $data = RestUtils::processRequest();

    if(!$data->getRequestVars()) { // if there are aren't any request vars then show frontpage
        require_once('frontpage.php');
        die();
    } else {
        // check api key
        if(!isset($_GET['key']) || !check_key($_GET['key'])) {
            RestUtils::sendResponse(401);
        } else {
            // check that there is a 'what'
            if(!isset($_GET['what'])){
                RestUtils::sendResponse(404);
            } else {
                log_api_request($_GET);
                if(file_exists(getcwd().'/'.$_GET['what'].'.php')) {
                    require_once($_GET['what'].'.php');
                } else {
                    RestUtils::sendResponse(501);
                }
            }
        }
    }
     */
?>
