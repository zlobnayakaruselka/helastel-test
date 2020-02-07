<?php

namespace App\Utils\EntityManager\Metadata\Exception;

class UnsupportedEntityFieldAttributeException extends \InvalidArgumentException
{
    public function __construct(string $attribute)
    {
        $message = "Unsupported attribute '$attribute'";
        parent::__construct($message);
    }
}
