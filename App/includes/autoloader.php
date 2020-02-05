<?php

function myAutoLoader($className)
{
    $pathClass = './classes/'.str_replace('\\', '/', $className).'.php';

    if (file_exists($pathClass)) {
        require $pathClass;
    }
}
