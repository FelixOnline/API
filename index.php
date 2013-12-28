<?php
/**
 * Felix API
 */

require_once __DIR__ . '/vendor/autoload.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$config = require __DIR__ . '/inc/config.inc.php';

// Felix Core setup
$db = new \ezSQL_mysqli();
$db->quick_connect(
    $config['db_user'],
    $config['db_pass'],
    $config['db_name'],
    array_key_exists('db_host', $config) ? $config['db_host'] : 'localhost',
    array_key_exists('db_port', $config) ? $config['db_port'] : 3306,
    'utf8'
);

$safesql = new \SafeSQL_MySQLi($db->dbh);
$core = new \FelixOnline\Core\App($config, $db, $safesql);

$app = new \SlimController\Slim(array(
    'controller.class_prefix'    => '\\API\\Controller',
    'controller.method_suffix'   => 'Action',
));

$app->view(new \JsonApiView());
$app->add(new \JsonApiMiddleware());

$app->addRoutes(array(
    '/v1/article/:id' => 'Article:index',
));


// Old API
$app->notFound(function () use ($app) {
    require __DIR__ . '/old.php';
});

$app->run();
