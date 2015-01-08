<?php
    // define current working directory
    if(!defined('API_DIRECTORY')) define('API_DIRECTORY', realpath(dirname(__FILE__).'/..'));

    // bootstrap Felix environment
    require_once(API_DIRECTORY.'/../bootstrap.php');
    require_once(API_DIRECTORY."/inc/api.php");
    require_once(API_DIRECTORY."/inc/rest.php");
    require_once(API_DIRECTORY."/inc/config.inc.php");

    if(!defined('API_DOCS_URL')) define('API_DOCS_URL', API_URL.'docs/');

    require_once(API_DIRECTORY.'/docs/markdown.php');
    require_once(API_DIRECTORY.'/docs/docs.php');
