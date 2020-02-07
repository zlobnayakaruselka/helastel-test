<?php

define('ROOT', dirname(__FILE__).'/../src/');

require '../src/autoload.php';


$envFilePath = ROOT . '/../.env';

if (!file_exists($envFilePath)) {
    throw new RuntimeException('.env file not found');
}

$envFile = fopen($envFilePath, 'r');

while ($envParam = fgets($envFile)) {
    if (!empty(trim($envParam))) {
        putenv(trim($envParam));
    }
}


$sl = \App\Utils\ServiceLocator::getInstance();

$api = $sl->getApiFactory()->createApi();

$api->run();
