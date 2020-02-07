<?php

namespace App\Library\Entity;

use App\Library\Collection\AuthorCollection;
use App\Library\Collection\BookCollection;
use App\Library\Storage\AuthorStorage;
use App\Utils\EntityManager\Metadata\EntityMetadata;

class Book extends AbstractEntity
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var AuthorCollection
     */
    private $authorCollection;

    public static function loadEntityMetadata(EntityMetadata $metadata): void
    {
        $metadata->setTable('test.book');
        $metadata->setCollection(BookCollection::class);

        $metadata->createField([
            'name' => 'id',
            'isPrimaryKey' => true,
        ]);

        $metadata->createField(['name' => 'name']);

        $metadata->createField([
           'name' => 'authorCollection',
           'mapping' => [
               'storage' => AuthorStorage::class,
               'method' => 'findAuthorsByBookId',
               'columns' => ['id'],
           ],
        ]);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return AuthorCollection
     */
    public function getAuthorCollection(): AuthorCollection
    {
        return $this->authorCollection;
    }
}
