<?php

namespace App\Utils\EntityManager;

use App\Library\Entity\AbstractEntity;

class EntityCache
{
    private $cache = [];

    public function getEntityFromCache(array $primaryKeyValues, string $entityName): ?AbstractEntity
    {
        return $this->cache[$entityName][$this->getCacheKey($primaryKeyValues)] ?? null;
    }

    public function cacheEntity(array $primaryKeyValues, string $entityName, AbstractEntity $entity): void
    {
        $this->cache[$entityName][$this->getCacheKey($primaryKeyValues)] = $entity;
    }

    private function getCacheKey(array $primaryKeyValues): string
    {
        return implode(' ', $primaryKeyValues);
    }
}
