<?php

namespace App\Utils\EntityManager\Metadata;

use App\Library\Collection\Collection;
use App\Utils\EntityManager\Metadata\Exception\InvalidCollectionNameException;
use App\Utils\EntityManager\Metadata\Exception\InvalidEntityMetadataException;

class EntityMetadata
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $table;
    /**
     * @var string
     */
    protected $collection;

    /**
     * @var EntityFieldMetadata[]
     */
    protected $fields = [];

    /**
     * @var array
     */
    protected $primaryKey = [];

    public function createEmptyEntityCollection(): Collection
    {
        $collectionName = $this->collection;

        $collection = new $collectionName();

        if (!($collection instanceof Collection)) {
            throw new InvalidCollectionNameException($this->name);
        }

        return $collection;
    }

    public function createField($metadata): void
    {
        $field = new EntityFieldMetadata();
        $field->load($this->name, $metadata);

        if ($field->isPrimaryKey()) {
            $this->primaryKey[] = $field->getName();
        }

        $this->fields[$field->getName()] = $field;
    }

    /**
     * @return EntityFieldMetadata[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    public function getPrimaryKeyValuesFromRow(array $row): array
    {
        $primaryKey = [];
        foreach ($this->primaryKey as $fieldName) {
            if (!isset($row[$fieldName])) {
                return [];
            }
            $primaryKey[$fieldName] = $row[$fieldName];
        }
        return $primaryKey;
    }

    public function validate(): void
    {
        if (!$this->name) {
            throw new InvalidEntityMetadataException('EntityName');
        }
        if (!$this->table) {
            throw new InvalidEntityMetadataException('Table', $this->name);
        }
        if (!$this->collection) {
            throw new InvalidEntityMetadataException('Collection', $this->name);
        }

        if (!$this->primaryKey) {
            throw new InvalidEntityMetadataException('Primary key fields', $this->name);
        }

        if (!$this->fields) {
            throw new InvalidEntityMetadataException('Fields', $this->name);
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($entityName): void
    {
        $this->name = $entityName;
    }

    public function setTable($table): void
    {
        $this->table = $table;
    }

    public function setCollection(string $collection): void
    {

        $this->collection = $collection;
    }
}
