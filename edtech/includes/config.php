<?php
session_start();
require_once 'db_connection.php';

define('SITE_NAME', 'Araneus Edutech LLP');
define('SITE_URL', 'http://localhost/araneus.in/araneus');

// Error reporting (turn off in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>