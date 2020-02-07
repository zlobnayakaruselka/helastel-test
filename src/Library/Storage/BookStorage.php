<?php

namespace App\Library\Storage;

use App\Library\Collection\BookCollection;
use App\Library\Entity\Book;
use App\Utils\EntityManager\EntityManager;
use PDO;

class BookStorage
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findOneById(int $authorId): Book
    {
        /** @var Book $book */
        $book = $this->entityManager->findOneBy(
            Book::class,
            'SELECT * FROM test.book WHERE id = :id',
            [':id' => [$authorId, PDO::PARAM_INT]]
        );

        return $book;
    }

    public function findBooks(): BookCollection
    {
        /** @var BookCollection $books */
        $books = $this->entityManager->findBy(Book::class, 'SELECT * FROM test.book');

        return $books;
    }

    public function findBooksByAuthorId(int $authorId): BookCollection
    {
        /** @var BookCollection $books */
        $books = $this->entityManager->findBy(
            Book::class,
            '
            SELECT book.* FROM test.book book
                JOIN test.authorship authorship ON book.id = authorship.book_id
                JOIN test.author author ON author.id = authorship.author_id
            WHERE author_id = :author_id',
            [':author_id' => [$authorId, PDO::PARAM_INT]]
        );

        return $books;
    }

    public function findBooksWithAuthorsCount(int $authorsCount): BookCollection
    {
        /** @var BookCollection $books */
        $books = $this->entityManager->findBy(
            Book::class,
            '
            SELECT book.* FROM book
                JOIN (
                        SELECT book_id, count(author_id) `count`
                        FROM authorship
                        GROUP BY book_id
                    ) authors_count ON authors_count.book_id = book.id
            WHERE authors_count.count = :authors_count',
            [':authors_count' => [$authorsCount, PDO::PARAM_INT]]
        );

        return $books;
    }
}
