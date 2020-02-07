<?php

namespace App\API;

use App\API\Controller\AuthorController;
use App\API\Controller\BookController;

class Routes
{
    public const CONFIG = [
        'GET' => [
            'get_author_list' => [
                'uri_pattern' => '/\A\/authors[\/]??\z/',
                'controller' => AuthorController::class,
                'action' => AuthorController::GET_AUTHOR_LIST
            ],
            'get_books_by_author' => [
                'uri_pattern' => '/\A\/authors\/[+]?\d+\/books[\/]??\z/',
                'controller' => AuthorController::class,
                'action' => AuthorController::GET_BOOKS_BY_AUTHOR_ACTION
            ],
            'get_book_list' => [
                'uri_pattern' => '/\A\/books[\/]??\z/',
                'controller' => BookController::class,
                'action' => BookController::GET_BOOK_LIST
            ],
            'get_authors_by_book' => [
                'uri_pattern' => '/\A\/books\/[+]?\d+\/authors[\/]??\z/',
                'controller' => BookController::class,
                'action' => BookController::GET_AUTHORS_BY_BOOK
            ],
            'get_books_with_authors_count' => [
                'uri_pattern' => '/\A\/books\/authors[\/]??\?((.+&count)|(count))=[+]?\d+(\z|&.*)/',
                'controller' => BookController::class,
                'action' => BookController::GET_BOOKS_WITH_AUTHORS_COUNT
            ]
        ],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];
}
