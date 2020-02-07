<?php

namespace App\Utils\EntityManager\Metadata\Exception;

class InvalidEntityInstanceException extends \InvalidArgumentException
{
    public function __construct(string $propertyClass, string $entityClass)
    {
        $message = "Expected $propertyClass, $entityClass given";
        parent::__construct($message);
    }
}
