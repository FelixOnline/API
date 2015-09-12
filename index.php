<?php
    use \FelixOnline\API;

    // define current working directory
    if(!defined('API_DIRECTORY')) define('API_DIRECTORY', dirname(__FILE__));

    // bootstrap Felix environment
    require_once(API_DIRECTORY.'/../bootstrap.php');
    require_once("inc/api.php");
    require_once("inc/rest.php");
    require_once("inc/config.inc.php");

    use FelixOnline\Core;

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
    
    $currentuser = new FelixOnline\Core\CurrentUser();

    /*
     * Routes
     */
    $urls = array(
        '/' => 'FelixOnline\API\indexController',
        '/version' => 'FelixOnline\API\versionController',
        '/articles' => 'FelixOnline\API\articleController',
        '/articles/(?P<id>[0-9]+)' => 'FelixOnline\API\articleController',
        '/articles/(?P<cat>[a-zA-Z]+)' => 'FelixOnline\API\articleController',
        '/sections' => 'FelixOnline\API\categoryController',
        '/sections/(?P<id>[0-9]+)' => 'FelixOnline\API\categoryController',
        '/sections/(?P<cat>[a-zA-Z]+)' => 'FelixOnline\API\categoryController',
        '/frontpage' => 'FelixOnline\API\frontpageController',
        '/frontpage/(?P<sec>[a-zA-Z0-9]+)' => 'FelixOnline\API\frontpageController',
        '/archive' => 'FelixOnline\API\archiveController',
        '/archive/(?P<pub>[0-9]+)' => 'FelixOnline\API\archiveController',
        '/archive/(?P<pub>[0-9]+)/(?P<issue>[0-9]+)' => 'FelixOnline\API\archiveController',
        '/archive/year/(?P<year>[0-9]+)' => 'FelixOnline\API\archiveController',
        '/archive/(?P<pub>[0-9]+)/year/(?P<year>[0-9]+)' => 'FelixOnline\API\archiveController',
        '/archive/(?P<latest>[0-9]+)/latest' => 'FelixOnline\API\archiveController',
        '/archive/issue/(?P<id>[0-9]+)' => 'FelixOnline\API\archiveController',
    );

    if(defined('API_RELATIVE_PATH')) { // if a relative path is defined
        try { // try mapping request to urls
            glue::stick($urls, API_RELATIVE_PATH);
        } catch (GlueMethodException $e) { // if it fails then send a 404 response
            \FelixOnline\API\API::error(501, 'The '.strtoupper($e->getMethod()).' method is not valid for this endpoint.', $e);
        } catch (GlueURLException $e) { // if it fails then send a 404 response
            \FelixOnline\API\API::error(404, 'This endpoint does not exist', $e);
        } catch (NotFoundException $e) { // if it fails then send a 404 response
            \FelixOnline\API\API::error(404, $e->getMessage(), $e);
        } catch(\Exception $e) {
            \FelixOnline\API\API::error(500, $e->getMessage(), $e, true);
        }
    } else {
        try { // try mapping request to urls
            glue::stick($urls);
        } catch (GlueMethodException $e) { // if it fails then send a 404 response
            \FelixOnline\API\API::error(501, 'The '.strtoupper($e->getMethod()).' method is not valid for this endpoint.', $e);
        } catch (GlueURLException $e) { // if it fails then send a 404 response
            \FelixOnline\API\API::error(404, 'This endpoint does not exist', $e);
        } catch (NotFoundException $e) { // if it fails then send a 404 response
            \FelixOnline\API\API::error(404, $e->getMessage(), $e);
        } catch(\Exception $e) {
            \FelixOnline\API\API::error(500, $e->getMessage(), $e, true);
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
