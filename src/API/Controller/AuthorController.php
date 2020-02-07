<?php

namespace App\API\Controller;

use App\API\Response\ResponseBuilder;
use App\Library\Storage\AuthorStorage;
use App\API\Response\Response;
use App\Utils\EntityManager\Exception\EntityNotFoundException;

class AuthorController
{
    public const GET_BOOKS_BY_AUTHOR_ACTION = 'getBooksByAuthor';
    public const GET_AUTHOR_LIST = 'getAuthorList';

    /**
     * @var AuthorStorage
     */
    private $authorStorage;

    /**
     * @var ResponseBuilder
     */
    private $responseBuilder;

    public function __construct(AuthorStorage $authorStorage, ResponseBuilder $responseBuilder)
    {
        $this->authorStorage = $authorStorage;
        $this->responseBuilder = $responseBuilder;
    }

    /**
     * name = get_author_list
     * Route /authors
     */
    public function getAuthorList(): Response
    {
        $authors = $this->authorStorage->findAuthors();

        return $this->responseBuilder->buildAuthorCollectionResponse($authors);
    }

    /**
     * name = get_books_by_author
     * Route /authors/{author_id}/books
     */
    public function getBooksByAuthor(int $authorId): Response
    {
        try {
            $author = $this->authorStorage->findOneById($authorId);
            $response = $this->responseBuilder->buildBookCollectionResponse($author->getBookCollection());
        } catch (EntityNotFoundException $notFoundException) {
            $response = $this->responseBuilder->buildEntityNotFoundResponse($notFoundException);
        }

        return $response;
    }
}
