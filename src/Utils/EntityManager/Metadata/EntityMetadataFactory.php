<?php

namespace App\Utils\EntityManager\Metadata;

class EntityMetadataFactory
{
    protected $cache = [];

    public function createEntityMetadata(string $entityName): EntityMetadata
    {
        if (!isset($this->cache[$entityName])) {
            $this->cache[$entityName] = $this->getEntityMetadata($entityName);
        }
        return $this->cache[$entityName];
    }

    public function createEmptyEntityMetadata()
    {
        return new EntityMetadata();
    }

    protected function getEntityMetadata(string $entityName): EntityMetadata
    {
        $method = 'loadEntityMetadata';
        $metadata = $this->createEmptyEntityMetadata();
        $metadata->setName($entityName);
        $entityName::$method($metadata);
        $metadata->validate();

        return $metadata;
    }
}
