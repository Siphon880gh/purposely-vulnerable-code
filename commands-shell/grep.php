<?php 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (isset($_GET['search'])) {
    $input = $_GET['search'];

    $command = "grep -e {$input} -r ./catalogue/*";

    echo "<pre>";
    echo "Running exec: $command\n\n";

    $output = shell_exec($command);
    echo $output;

    echo "</pre>";
} else {
    echo "Usage: ?search=searchterm";
}

?>