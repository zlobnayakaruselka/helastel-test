<?php

namespace App\Utils\EntityManager;

use App\Library\Collection\Collection;
use App\Library\Entity\AbstractEntity;
use App\Utils\Database\Db;
use App\Utils\EntityManager\Exception\EntityNotFoundException;
use PDO;

class EntityManager
{
    /**
     * @var Db
     */
    private $db;

    /**
     * @var DataMapper
     */
    private $dataMapper;

    public function __construct(Db $db, DataMapper $dataMapper)
    {
        $this->db = $db;
        $this->dataMapper = $dataMapper;
    }

    public function findOneBy(string $entityName, $query, $params = []): AbstractEntity
    {
        $row = $this->db->fetch($query, $params, PDO::FETCH_ASSOC);

        if ($row === null) {
            throw new EntityNotFoundException($entityName, $query, $params);
        }

        return $this->dataMapper->createEntity($entityName, $row);
    }

    public function findBy(string $entityName, $query, $params = []): Collection
    {
        $rows = $this->db->fetchAll($query, $params, PDO::FETCH_ASSOC);

        return $this->dataMapper->createEntityCollection($entityName, $rows);
    }
}
