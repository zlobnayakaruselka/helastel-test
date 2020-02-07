<?php

namespace App\Utils\Database\Exception;

use Throwable;

class InvalidDbConfigException extends \RuntimeException
{
    public function __construct(string $parameterName)
    {
        parent::__construct("Database connection config $parameterName is invalid");
    }
}
