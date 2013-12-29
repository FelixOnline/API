<?php
    /*
     * Create a config.inc.php with the information below to run on a local dev machine
     */

    $config = array(
        'db_name' => 'DB_TABLE',
        'db_user' => 'DB_USER',
        'db_pass' => 'DB_PASS',
        'base_url' => 'http://felixonline.co.uk/',
    );

    $cid = mysql_connect('localhost', $config['db_user'], $config['db_pass']);
    $dbok = mysql_select_db($config['db_name'], $cid);

    /* Forces charset to be utf8 */
    mysql_set_charset('utf8',$cid);

    /* turn off error reporting */
    error_reporting(0);
    /* to turn on error reporting uncomment line: */
    //error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

    /*
     * Change these urls to your local versions, e.g http://localhost/felix
     */
    define('STANDARD_URL','http://felixonline.co.uk/');
    define('BASE_URL','http://felixonline.co.uk/');
    define('ADMIN_URL','http://felixonline.co.uk/engine/');
    define('API_URL','http://api.felixonline.co.uk/');
    define('LOCAL',false);
    define('ADMIN_EMAIL','jk708@imperial.ac.uk');

    define('PRODUCTION_FLAG', true); // if set to true css and js will be minified etc..
    define('AUTHENTICATION', true); // if set to false then authentication will be turned off across the site. ONLY TURN OFF ON LOCAL SERVER
    define('AUTHENTICATION_PATH','https://dougal.union.ic.ac.uk/media/felix/'); // change authentication path to local file for local dev (default is https://dougal.union.ic.ac.uk/media/felix/)

    return $config;
