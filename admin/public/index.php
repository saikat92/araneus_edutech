<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define('APP_ROOT', dirname(__DIR__));



require APP_ROOT . '/config/app.php';
require APP_ROOT . '/config/database.php';
require APP_ROOT . '/app/Core/Router.php'; 

spl_autoload_register(function (string $class): void {
    $path = APP_ROOT . '/' . str_replace(['app\\', '\\'], ['app/', '/'], $class) . '.php';
    if (file_exists($path)) require $path;
});

session_name(SESSION_NAME);
session_start();

use app\Core\Router;

$router = new Router();
require APP_ROOT . '/config/routes.php';

$uri    = $_SERVER['REQUEST_URI'];
$base   = parse_url(APP_URL, PHP_URL_PATH);
$uri    = substr($uri, strlen($base)) ?: '/';
$uri    = strtok($uri, '?');
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($uri, $method);
