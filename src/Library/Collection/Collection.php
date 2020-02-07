<?php

namespace App\Library\Collection;

use App\Library\Entity\AbstractEntity;

class Collection implements \IteratorAggregate
{
    protected $collection = [];

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->collection);
    }

    public function addItem(AbstractEntity $item): void
    {
        $this->collection[spl_object_hash($item)] = $item;
    }
}
