<?php

// Requires Function composer's autoload
if (file_exists('function/vendor/autoload.php')) {
    require('function/vendor/autoload.php');
}

$stdin = file_get_contents("php://stdin");
$data = json_decode($stdin);
file_put_contents("solution_{$data->sid}.php", $data->body);
$output = shell_exec("php solution_{$data->sid}.php");
echo $output;