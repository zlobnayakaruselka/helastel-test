<?php

namespace App\Library\Storage;

use App\Library\Collection\AuthorCollection;
use App\Library\Entity\Author;
use App\Utils\EntityManager\EntityManager;
use PDO;

class AuthorStorage
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findOneById(int $authorId): Author
    {
        /** @var Author $author */
        $author = $this->entityManager->findOneBy(
            Author::class,
            'SELECT * FROM test.author WHERE id = :id',
            [':id' => [$authorId, PDO::PARAM_INT]]
        );

        return $author;
    }

    public function findAuthors(): AuthorCollection
    {
        /** @var AuthorCollection $collection */
        $collection = $this->entityManager->findBy(Author::class, 'SELECT * FROM test.author');

        return $collection;
    }

    public function findAuthorsByBookId(int $bookId): AuthorCollection
    {
        /** @var AuthorCollection $collection */
        $collection = $this->entityManager->findBy(
            Author::class,
            '
            SELECT author.* FROM test.author author
               JOIN test.authorship authorship ON author.id = authorship.author_id
               JOIN test.book book ON book.id = authorship.book_id
            WHERE book.id = :book_id',
            [':book_id' => [$bookId, PDO::PARAM_INT]]
        );

        return $collection;
    }
}
