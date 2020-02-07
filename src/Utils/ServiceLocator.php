<?php

namespace App\Utils;

use App\Library\Storage\StorageFactory;
use App\API\ApiFactory;

class ServiceLocator
{
    /**
     * @var self
     */
    private static $instance;

    private $cache = [];

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getApiFactory(): ApiFactory
    {
        if (!isset($this->cache[__METHOD__])) {
            $this->cache[__METHOD__] = new ApiFactory($this->getStorageFactory());
        }

        return $this->cache[__METHOD__];
    }

    public function getStorageFactory(): StorageFactory
    {
        if (!isset($this->cache[__METHOD__])) {
            $this->cache[__METHOD__] = new StorageFactory();
        }

        return $this->cache[__METHOD__];
    }

    private function __construct()
    {
    }
}
