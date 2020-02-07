<?php

namespace App\API;

use App\Library\Storage\StorageFactory;
use App\API\Controller\ControllerFactory;
use App\API\Request\Converter\RequestConverterFactory;
use App\API\Request\RequestExecutor;

class ApiFactory
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


    public function createApi(): Api
    {
        if (!isset($this->cache[__METHOD__])) {
            $this->cache[__METHOD__] = new Api($this->createRequestExecutor());
        }

        return $this->cache[__METHOD__];
    }

    private function createRequestExecutor(): RequestExecutor
    {
        if (!isset($this->cache[__METHOD__])) {
            $this->cache[__METHOD__] = new RequestExecutor(
                $this->createRequestConverterFactory()->createRequestConverter(),
                $this->createControllerFactory()
            );
        }

        return $this->cache[__METHOD__];
    }

    private function createRequestConverterFactory(): RequestConverterFactory
    {
        if (!isset($this->cache[__METHOD__])) {
            $this->cache[__METHOD__] = new RequestConverterFactory();
        }

        return $this->cache[__METHOD__];
    }

    private function createControllerFactory(): ControllerFactory
    {
        if (!isset($this->cache[__METHOD__])) {
            $this->cache[__METHOD__] = new ControllerFactory($this->storageFactory);
        }

        return $this->cache[__METHOD__];
    }
}
