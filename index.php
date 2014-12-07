<?php
	/*
		Felix Online API
			Author: Jonathan Kim
			Date: 24/05/11
			Version: 0.1
	*/

    // define current working directory
    if(!defined('API_DIRECTORY')) define('API_DIRECTORY', dirname(__FILE__));

    // bootstrap Felix environment
    require_once(API_DIRECTORY.'/../bootstrap.php');
	require_once(BASE_DIRECTORY.'/inc/exceptions.inc.php');
    require_once("inc/api.php");
    require_once("inc/rest.php");
    require_once("inc/config.inc.php");

    if(!defined('API_DOCS_URL')) define('API_DOCS_URL', API_URL.'docs/');

    /*
     * Include Controllers
     */
    require_once(API_DIRECTORY.'/controllers/baseController.php');
    foreach (glob(API_DIRECTORY.'/controllers/*.php') as $filename) {
        require_once($filename);
    }

    /*
     * Include Helpers
     */
    require_once(API_DIRECTORY.'/helpers/baseHelper.php');
    foreach (glob(API_DIRECTORY.'/helpers/*.php') as $filename) {
        require_once($filename);
    }

    //require_once("inc/XmlWriter.php"); // removed because it wasn't working
    
    $currentuser = new CurrentUser();

    /*
     * Routes
     */
    $urls = array(
        '/' => 'indexController',
        '/articles' => 'articleController',
        '/articles/(?P<id>[0-9]+)' => 'articleController',
        '/articles/(?P<cat>[a-zA-Z]+)' => 'articleController'
    );

    if(defined('API_RELATIVE_PATH')) { // if a relative path is defined
        try { // try mapping request to urls
            glue::stick($urls, API_RELATIVE_PATH);
        } catch (Exception $e) { // if it fails then send a 404 response
            echo $e;
            RestUtils::sendResponse(404);
        }
    } else {
        try { // try mapping request to urls
            glue::stick($urls);
        } catch (Exception $e) { // if it fails then send a 404 response
            echo $e;
            RestUtils::sendResponse(404);
        }
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
