<?php

namespace App\Library\Entity;

use App\Library\Collection\AuthorCollection;
use App\Library\Collection\BookCollection;
use App\Library\Storage\BookStorage;
use App\Utils\EntityManager\Metadata\EntityMetadata;

class Author extends AbstractEntity
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
     * @var BookCollection
     */
    private $bookCollection;

    public static function loadEntityMetadata(EntityMetadata $metadata): void
    {
        $metadata->setTable('test.author');
        $metadata->setCollection(AuthorCollection::class);

        $metadata->createField([
            'name' => 'id',
            'column' => 'id',
            'isPrimaryKey' => true,
        ]);

        $metadata->createField(['name' => 'name']);

        $metadata->createField([
            'name' => 'bookCollection',
            'mapping' => [
               'storage' => BookStorage::class,
               'method' => 'findBooksByAuthorId',
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
     * @return BookCollection
     */
    public function getBookCollection(): BookCollection
    {
        return $this->bookCollection;
    }
}
