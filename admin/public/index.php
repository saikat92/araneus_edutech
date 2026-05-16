<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('APP_ROOT', dirname(__DIR__));

require APP_ROOT . '/config/app.php';
require APP_ROOT . '/config/database.php';
require APP_ROOT . '/App/Core/Router.php';   // ← Fix 1: 'App' not 'app'

spl_autoload_register(function (string $class): void {
    // Fix 2: map App\ → App/ (capital A matches the actual folder name)
    $path = APP_ROOT . '/' . str_replace(['App\\', '\\'], ['App/', '/'], $class) . '.php';
    if (file_exists($path)) {
        require $path;
    }
});

session_name(SESSION_NAME);
session_start();

use App\Core\Router;   // ← Fix 3: 'App' not 'app'

$router = new Router();
require APP_ROOT . '/config/routes.php';

$uri    = $_SERVER['REQUEST_URI'];
$base   = parse_url(APP_URL, PHP_URL_PATH);
$uri    = substr($uri, strlen($base)) ?: '/';
$uri    = strtok($uri, '?');
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($uri, $method);