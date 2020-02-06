<?php

require './vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '../.env');
$dotenv->load();

function myAutoLoader($className)
{
    $pathClass = './classes/'.str_replace('\\', '/', $className).'.php';

    if (file_exists($pathClass)) {
        require $pathClass;
    }
}
