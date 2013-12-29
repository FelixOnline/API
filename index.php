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

$app->view(new \JSONView());

$app->addRoutes(array(
    '/' => 'Frontpage:index',
    '/v1/articles/' => 'Article:index',
    '/v1/articles/:id' => 'Article:article',
));

// Old API
$app->notFound(function () use ($app) {
    if ($app->request->params('what')) {
        require __DIR__ . '/old.php';
    } else {
        $app->render(404, array(
            'error' => TRUE,
            'msg' => 'Invalid route',
        ));
    }
});

$app->run();
