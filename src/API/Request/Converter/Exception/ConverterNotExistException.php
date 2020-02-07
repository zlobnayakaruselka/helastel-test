<?php

namespace App\API\Request\Converter\Exception;

class ConverterNotExistException extends \RuntimeException
{
    public function __construct(string $controller, string $action)
    {
        $message = "Converter for controller '$controller' and action '$action' not exist";

        parent::__construct($message);
    }
}
