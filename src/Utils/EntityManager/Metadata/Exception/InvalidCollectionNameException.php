<?php

namespace App\Utils\EntityManager\Metadata\Exception;

use App\Library\Collection\Collection;

class InvalidCollectionNameException extends \InvalidArgumentException
{
    public function __construct(string $invalidCollectionName)
    {
        $neededCollectionName = Collection::class;
        $message = "Collection must be an subclass of $neededCollectionName in entity $invalidCollectionName";
        parent::__construct($message);
    }
}
