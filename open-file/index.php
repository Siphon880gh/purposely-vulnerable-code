<?php
     ini_set('display_errors', 1);
     ini_set('display_startup_errors', 1);
     error_reporting(E_ALL);


    $filepath = $_GET['filepath'] ?? "";
    $contents = file_get_contents($filepath);
    echo $contents;

?>