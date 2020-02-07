<?php

namespace App\Library\Storage;

use App\Utils\EntityManager\EntityManagerFactory;

class StorageFactory
{
    private $cache = [];

    public function createByClass(string $storageClass): object
    {
        $pathArray = explode('\\', $storageClass);
        $methodName = 'create' . array_pop($pathArray);

        return $this->$methodName();
    }

    public function createBookStorage(): BookStorage
    {
        if (!isset($this->cache[__METHOD__])) {
            $this->cache[__METHOD__] = new BookStorage($this->createEntityManagerFactory()->createEntityManager());
        }

        return $this->cache[__METHOD__];
    }

    public function createAuthorStorage(): AuthorStorage
    {
        if (!isset($this->cache[__METHOD__])) {
            $this->cache[__METHOD__] = new AuthorStorage($this->createEntityManagerFactory()->createEntityManager());
        }

        return $this->cache[__METHOD__];
    }

    private function createEntityManagerFactory(): EntityManagerFactory
    {
        if (!isset($this->cache[__METHOD__])) {
            $this->cache[__METHOD__] = new EntityManagerFactory($this);
        }

        return $this->cache[__METHOD__];
    }
}
