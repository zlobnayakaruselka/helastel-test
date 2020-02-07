<?php

namespace App\API\Request\Exception;

class MethodNotSupportedException extends \RuntimeException
{
    public function __construct(string $method)
    {
        $message = "Method $method not supported in this API";
        parent::__construct($message);
    }
}
