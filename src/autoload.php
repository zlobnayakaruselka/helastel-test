<?php

function class_autoload($class_name): bool
{
    $filePath = ROOT
        . str_replace('\\', '/', str_replace('App\\', '', $class_name))
        . '.php';

    if (!file_exists($filePath))
        return false;

    require_once $filePath;

    return true;
}

spl_autoload_register('class_autoload');
