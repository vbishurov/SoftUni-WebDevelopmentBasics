<?php
require_once "Views/templates/header.php";
session_start();
if (isset($_SESSION['id'])) : ?>
    <ul id="menu">
        <li><a href="/users/profile">Profile</a></li>
        <li><a href="/products/all">View products</a></li>
        <li><a href="/shoppingcart/view">View cart</a></li>
        <li><a href="/users/logout">Logout</a></li>
        <?php if (in_array(array('name' => 'editor'), $_SESSION['roles'])) : ?>
            <li><a href="/admin/editor">Administration</a></li>
            <?php
        endif; ?>
        <?php if (in_array(array('name' => 'administrator'), $_SESSION['roles'])) : ?>
            <li><a href="/admin/admin">Administration</a></li>
            <?php
        endif; ?>
    </ul>
    <?php
endif;
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

require_once "Views/templates/footer.php";