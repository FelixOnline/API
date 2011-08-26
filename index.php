<?php
	/*
		Felix Online API
			Author: Jonathan Kim
			Date: 24/05/11
			Version: 0.1
	*/

	require_once("inc/config.inc.php");
	require_once("inc/functions.php");
	require_once("inc/const.php");
    require_once("inc/Rest.php");

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
                // find out what it is requesting
                if(file_exists(getcwd().'/'.$_GET['what'].'.php')) {
                    require_once($_GET['what'].'.php');
                } else {
                    RestUtils::sendResponse(501);
                }
            }
        }
    }

?>