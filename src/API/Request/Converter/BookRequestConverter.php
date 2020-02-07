<?php

namespace App\API\Request\Converter;

use App\API\Controller\BookController;

class BookRequestConverter extends AbstractRequestConverter
{
    protected const SUPPORTED_CONTROLLER = BookController::class;
    protected const SUPPORTED_ACTIONS = [
        BookController::GET_BOOK_LIST,
        BookController::GET_AUTHORS_BY_BOOK,
        BookController::GET_BOOKS_WITH_AUTHORS_COUNT
    ];

    protected function convertForGetAuthorsByBook(string $uri): array
    {
        $uriPath = parse_url($uri, PHP_URL_PATH);

        $authorId = (int)preg_replace('/(\A\/books\/)|(\/authors[\/]??\z)/', '', $uriPath);

        return [$authorId];
    }

    protected function convertForGetBooksWithAuthorsCount(string $uri): array
    {
        $uriQuery = parse_url($uri, PHP_URL_QUERY);
        parse_str($uriQuery, $uriQuery);

        return [(int)$uriQuery['count']];
    }


    protected function convertForGetBookList(string $uri): array
    {
        return [];
    }
}
