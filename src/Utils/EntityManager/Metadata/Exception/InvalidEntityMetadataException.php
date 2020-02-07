<?php

namespace App\Utils\EntityManager\Metadata\Exception;

class InvalidEntityMetadataException extends \InvalidArgumentException
{
    public function __construct(string $parameter, string $entityName = null)
    {
        $message = "$parameter is not defined in " . $entityName ?? 'entity';
        parent::__construct($message);
    }
}
