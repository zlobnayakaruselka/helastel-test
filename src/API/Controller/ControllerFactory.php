<?php

namespace App\API\Controller;

use App\API\Controller\AuthorController;
use App\API\Controller\BookController;
use App\API\Response\ResponseBuilder;
use App\Library\Storage\StorageFactory;

class ControllerFactory
{
    private $cache = [];

    /**
     * @var StorageFactory
     */
    private $storageFactory;

    public function __construct(StorageFactory $storageFactory)
    {
        $this->storageFactory = $storageFactory;
    }

    public function createByClass(string $controllerClass): object
    {
        $pathArray = explode('\\', $controllerClass);
        $methodName = 'create' . array_pop($pathArray);

        return $this->$methodName();
    }

    public function createAuthorController(): AuthorController
    {
        if (!isset($this->cache[__METHOD__])) {
            $this->cache[__METHOD__] = new AuthorController(
                $this->storageFactory->createAuthorStorage(),
                $this->createResponseBuilder()
            );
        }

        return $this->cache[__METHOD__];
    }

    public function createBookController(): BookController
    {
        if (!isset($this->cache[__METHOD__])) {
            $this->cache[__METHOD__] = new BookController(
                $this->storageFactory->createBookStorage(),
                $this->createResponseBuilder()
            );
        }

        return $this->cache[__METHOD__];
    }

    private function createResponseBuilder(): ResponseBuilder
    {
        if (!isset($this->cache[__METHOD__])) {
            $this->cache[__METHOD__] = new ResponseBuilder();
        }

        return $this->cache[__METHOD__];
    }
}
