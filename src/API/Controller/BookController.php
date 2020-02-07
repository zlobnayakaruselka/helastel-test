<?php

namespace App\API\Controller;

use App\API\Response\ResponseBuilder;
use App\Library\Storage\BookStorage;
use App\API\Response\Response;
use App\Utils\EntityManager\Exception\EntityNotFoundException;

class BookController
{
    public const GET_BOOK_LIST = 'getBookList';
    public const GET_AUTHORS_BY_BOOK = 'getAuthorsByBook';
    public const GET_BOOKS_WITH_AUTHORS_COUNT = 'getBooksWithAuthorsCount';

    /**
     * @var BookStorage
     */
    private $bookStorage;

    /**
     * @var ResponseBuilder
     */
    private $responseBuilder;

    public function __construct(BookStorage $bookStorage, ResponseBuilder $responseBuilder)
    {
        $this->bookStorage = $bookStorage;
        $this->responseBuilder = $responseBuilder;
    }

    /**
     * name = get_book_list
     * Route /books
     */
    public function getBookList(): Response
    {
        $books = $this->bookStorage->findBooks();

        return $this->responseBuilder->buildBookCollectionResponse($books);
    }

    /**
     * name = get_authors_by_book
     * Route /books/{book_id}/authors
     */
    public function getAuthorsByBook(int $bookId): Response
    {
        try {
            $book = $this->bookStorage->findOneById($bookId);

            $response = $this->responseBuilder->buildAuthorCollectionResponse($book->getAuthorCollection());
        } catch (EntityNotFoundException $notFoundException) {
            $response = $this->responseBuilder->buildEntityNotFoundResponse($notFoundException);
        }

        return $response;
    }


    /**
     * name = get_authors_by_book
     * Route /books/authors?count={authors_count}
     */
    public function getBooksWithAuthorsCount(int $authorsCount): Response
    {
        $books = $this->bookStorage->findBooksWithAuthorsCount($authorsCount);

        return $this->responseBuilder->buildBookCollectionResponse($books);
    }
}
