<?php

namespace App\API\Response;

use App\API\Api;
use App\Library\Collection\AuthorCollection;
use App\Library\Collection\BookCollection;
use App\Utils\EntityManager\Exception\EntityNotFoundException;

class ResponseBuilder
{
    public function buildAuthorCollectionResponse(AuthorCollection $authorCollection): Response
    {
        $responseData = [];
        foreach ($authorCollection->getIterator() as $author) {
            $responseData[] = ['id' => $author->getId(), 'name' => $author->getName()];;
        }

        return new Response(Api::HTTP_OK, $responseData);
    }

    public function buildBookCollectionResponse(BookCollection $bookCollection, ?int $authorsCount = null): Response
    {
        $responseData = [];
        foreach ($bookCollection->getIterator() as $book) {
            $bookData = ['id' => $book->getId(), 'name' => $book->getName()];
            if ($authorsCount !== null) {
                $bookData['authors_count'] = $authorsCount;
            }

            $responseData[] = $bookData;
        }

        return new Response(Api::HTTP_OK, $responseData);
    }

    public function buildEntityNotFoundResponse(EntityNotFoundException $notFoundException): Response
    {
        $pathArray = explode('\\', $notFoundException->getEntityName());
        $entityName = array_pop($pathArray);

        $exportParameters = json_encode($notFoundException->getParamsForExport());

        return new Response(
            Api::HTTP_NOT_FOUND,
            ['message' => "$entityName with parameters = $exportParameters not found"]
        );
    }
}
