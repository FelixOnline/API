<?php
	/*
		Felix Online API
			Author: Jonathan Kim
			Date: 24/05/11
			Version: 0.1
	*/

    // bootstrap Felix environment
    require_once("../inc/common.inc.php");
    require_once("inc/api.php");
    require_once("inc/Rest.php");
    require_once("glue.php");
    require_once("controllers/baseController.php");
    require_once("controllers/indexController.php");
    require_once("controllers/articleController.php");
	//require_once("inc/config.inc.php");
	//require_once("inc/functions.php");
	//require_once("inc/const.php");
    //require_once("inc/XmlWriter.php"); // removed because it wasn't working

    /*
     * Routes
     */
    $urls = array(
        '/' => 'indexController',
        '/articles' => 'articleController',
        '/articles/(?P<id>[a-zA-Z0-9]+)' => 'articleController'
    );

    try { // try mapping request to urls
        glue::stick($urls);
    } catch (Exception $e) { // if it fails then send a 404 response
        RestUtils::sendResponse(404);
    }

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
