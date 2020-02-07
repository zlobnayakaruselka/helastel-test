<?php

namespace App\Utils\EntityManager\Metadata;

use App\Library\Storage\StorageFactory;
use App\Utils\EntityManager\Metadata\Exception\InvalidEntityInstanceException;
use App\Utils\EntityManager\Metadata\Exception\UnsupportedEntityFieldAttributeException;

class EntityFieldMetadata
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string | null
     */
    private $column = null;

    /**
     * @var bool
     */
    private $isPrimaryKey = false;

    /**
     * @var array
     * [
     *      'storage' => 'fullStorageName',
     *      'method' => 'storageMethod',
     *      'columns' => ['column1', 'column2']
     * ]
     */
    private $mapping;

    /**
     * @var \ReflectionProperty
     */
    private $reflectionProperty;

    /**
     * @var string
     */
    private $reflectionPropertyClass;

    public function getName(): string
    {
        return $this->name;
    }

    public function isPrimaryKey(): bool
    {
        return $this->isPrimaryKey;
    }

    public function load($entityName, $metadata): void
    {
        foreach ($metadata as $name => $value) {
            if (property_exists($this, $name)) {
                $this->$name = $value;
            } else {
                throw new UnsupportedEntityFieldAttributeException($name);
            }
        }

        $this->reflectionProperty = $this->createReflectionProperty($entityName);
        $this->reflectionPropertyClass = $this->reflectionProperty->getDeclaringClass()->getName();
    }

    public function setValueFromRow(StorageFactory $storageFactory, $entity, array $row): void
    {
        $this->checkEntityInstance($entity);

        $value = $this->getDirectMappingValue($storageFactory, $row);

        if ($value !== null) {
            $this->reflectionProperty->setValue($entity, $value);
        }
    }

    /**
     * @param StorageFactory $storageFactory
     * @param array $row
     * @return mixed
     */
    public function getDirectMappingValue(StorageFactory $storageFactory, array $row)
    {
        if ($this->mapping) {
            $parameters = [];
            foreach ($this->mapping['columns'] as $columnName) {
                if (!isset($row[$columnName])) {
                    return null;
                }
                $parameters[] = $row[$columnName];
            }

            $storage = $storageFactory->createByClass($this->mapping['storage']);
            $method = $this->mapping['method'];

            return call_user_func_array([$storage, $method], $parameters);
        }

        $columnName = $this->column ?? $this->name;

        if (isset($row[$columnName])) {
            return $row[$columnName];
        }

        return null;
    }

    public function checkEntityInstance($entity): void
    {
        if (!($entity instanceof $this->reflectionPropertyClass)) {
            throw new InvalidEntityInstanceException($this->reflectionPropertyClass, get_class($entity));
        }
    }

    private function createReflectionProperty($entityName): \ReflectionProperty
    {
        $property = new \ReflectionProperty($entityName, $this->name);
        $property->setAccessible(true);

        return $property;
    }
}
