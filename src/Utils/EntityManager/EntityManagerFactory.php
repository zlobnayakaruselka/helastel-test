<?php

namespace App\Utils\EntityManager;

use App\Library\Storage\StorageFactory;
use App\Utils\Database\Db;
use App\Utils\Database\MysqlConnection;
use App\Utils\EntityManager\Metadata\EntityMetadataFactory;

class EntityManagerFactory
{
    private $cache = [];

    /**
     * @var StorageFactory
     */
    private $storageFactory;

    public function __construct(StorageFactory $storageFactory)
    {
        $this->storageFactory = $storageFactory;
    }

    public function createEntityManager(): EntityManager
    {
        if (!isset($this->cache[__METHOD__])) {
            $this->cache[__METHOD__] = new EntityManager($this->createDb(), $this->createDataMapper());
        }

        return $this->cache[__METHOD__];
    }

    private function createDataMapper(): DataMapper
    {
        if (!isset($this->cache[__METHOD__])) {
            $this->cache[__METHOD__] = new DataMapper(
                $this->createEntityMetadataFactory(),
                $this->storageFactory,
                $this->createEntityCache()
            );
        }

        return $this->cache[__METHOD__];
    }

    private function createEntityCache(): EntityCache
    {
        if (!isset($this->cache[__METHOD__])) {
            $this->cache[__METHOD__] = new EntityCache();
        }

        return $this->cache[__METHOD__];
    }

    private function createEntityMetadataFactory(): EntityMetadataFactory
    {
        if (!isset($this->cache[__METHOD__])) {
            $this->cache[__METHOD__] = new EntityMetadataFactory();
        }

        return $this->cache[__METHOD__];
    }

    private function createDb(): Db
    {
        if (!isset($this->cache[__METHOD__])) {
            $this->cache[__METHOD__] = new Db(MysqlConnection::getPDO());
        }

        return $this->cache[__METHOD__];
    }
}
