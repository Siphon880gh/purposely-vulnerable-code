<?php 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

define('admin', 'John');
// echo $_GET["user-role"]; // `?user-role=admin` url would render "admin"
eval("echo " . $_GET["user-role"] . ";"); // `?user-role=admin` url would render "John" // Recall that eval is for php scripts
?>