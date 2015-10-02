<?php
session_start();
require_once 'Autoloader.php';

\ShoppingCart\Autoloader::init();

$uri = preg_replace('/\?[\w=]+/', "", $_SERVER['REQUEST_URI']);

$requestParams = explode("/", $uri);
array_shift($requestParams);

$controller = array_shift($requestParams);
$action = array_shift($requestParams);

\ShoppingCart\Core\Database::setInstance(
    \ShoppingCart\Config\DatabaseConfig::DB_INSTANCE_NAME,
    \ShoppingCart\Config\DatabaseConfig::DB_DRIVER,
    \ShoppingCart\Config\DatabaseConfig::DB_USER,
    \ShoppingCart\Config\DatabaseConfig::DB_PASSWORD,
    \ShoppingCart\Config\DatabaseConfig::DB_NAME,
    \ShoppingCart\Config\DatabaseConfig::DB_HOST
);

$app = new \ShoppingCart\Application($controller, $action, $requestParams);
$app->start();



