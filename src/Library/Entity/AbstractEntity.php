<?php

namespace App\Library\Entity;

use App\Utils\EntityManager\Metadata\EntityMetadata;

abstract class AbstractEntity
{
    abstract public static function loadEntityMetadata(EntityMetadata $metadata): void;
}
