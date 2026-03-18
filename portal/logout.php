<?php
session_start();
require_once '../controller/Auth.php';

$auth = new Auth();
$auth->logout(); // destroys session

// Redirect to login page
header("Location: ../pages/login.php");
exit();
?>