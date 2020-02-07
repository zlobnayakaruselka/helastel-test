<?php

namespace App\API\Request\Converter;

use App\API\Controller\AuthorController;

class AuthorRequestConverter extends AbstractRequestConverter
{
    protected const SUPPORTED_CONTROLLER = AuthorController::class;
    protected const SUPPORTED_ACTIONS = [
        AuthorController::GET_BOOKS_BY_AUTHOR_ACTION,
        AuthorController::GET_AUTHOR_LIST
    ];

    protected function convertForGetBooksByAuthor(string $uri): array
    {
        $uriPath = parse_url($uri, PHP_URL_PATH);

        $authorId = (int)preg_replace('/(\A\/authors\/)|(\/books[\/]??\z)/', '', $uriPath);

        return [$authorId];
    }

    protected function convertForGetAuthorList(string $uri): array
    {
        return [];
    }
}
