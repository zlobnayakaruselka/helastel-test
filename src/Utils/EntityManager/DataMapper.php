<?php

namespace App\Utils\EntityManager;

use App\Library\Collection\Collection;
use App\Library\Entity\AbstractEntity;
use App\Library\Storage\StorageFactory;
use App\Utils\EntityManager\Metadata\EntityMetadataFactory;

class DataMapper
{
    /**
     * @var EntityMetadataFactory
     */
    private $entityMetadataFactory;

    /**
     * @var StorageFactory
     */
    private $storageFactory;

    /**
     * @var EntityCache
     */
    private $entityCache;

    public function __construct(
        EntityMetadataFactory $entityMetadataFactory,
        StorageFactory $storageFactory,
        EntityCache $entityCache
    ) {
        $this->entityMetadataFactory = $entityMetadataFactory;
        $this->storageFactory = $storageFactory;
        $this->entityCache = $entityCache;
    }


    public function createEmptyEntity(string $entityName): AbstractEntity
    {
        return new $entityName();
    }

    public function createEntityCollection(string $entityName, array $rows = []): Collection
    {
        $entityMetadata = $this->entityMetadataFactory->createEntityMetadata($entityName);

        $collection = $entityMetadata->createEmptyEntityCollection();

        foreach ($rows as $row) {
            $collection->addItem($this->createEntity($entityName, $row));
        }

        return $collection;
    }

    public function createEntity($entityName, array $row = []): AbstractEntity
    {
        $entityMetadata = $this->entityMetadataFactory->createEntityMetadata($entityName);
        $primaryKeyValues = $entityMetadata->getPrimaryKeyValuesFromRow($row);

        $entity = $this->entityCache->getEntityFromCache($primaryKeyValues, $entityMetadata->getName());

        if ($entity === null) {
            $entity = $this->createEmptyEntity($entityName);
            $this->entityCache->cacheEntity($primaryKeyValues, $entityMetadata->getName(), $entity);

            $this->doLoadEntityFromRow($entity, $row);
        }

        return $entity;
    }

    private function doLoadEntityFromRow(AbstractEntity $entity, array $row): void
    {
        $metadata = $this->entityMetadataFactory->createEntityMetadata(get_class($entity));

        foreach ($metadata->getFields() as $field) {
            $field->setValueFromRow($this->storageFactory, $entity, $row);
        }
    }
}
