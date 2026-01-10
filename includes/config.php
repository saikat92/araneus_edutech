<?php


// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'araneus_db');

// Site configuration
define('SITE_NAME', 'Araneus Edutech LLP');
define('SITE_URL', 'http://localhost/araneus_edutech/');
define('SITE_EMAIL', 'araneusedutech@gmail.com');
define('SITE_PHONE', '+91-9874291460');
define('SITE_ADDRESS', '116/56/E/N, East Chandmari, Barrackpore, Kolkata - 700122');
define('SITE_LLPIN', 'AAP-3776');


// Database connection
require_once 'includes/database.php';
$database = new Database();
$conn = $database->getConnection();
?>