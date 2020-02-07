<?php

namespace App\API\Request\Converter;

class RequestConverterFactory
{
    private $cache = [];

    public function createRequestConverter(): DelegatingRequestConverter
    {
        if (!isset($this->cache[__METHOD__])) {
            $this->cache[__METHOD__] = new DelegatingRequestConverter([
                $this->createAuthorRequestConverter(),
                $this->createBookRequestConverter()
            ]);
        }

        return $this->cache[__METHOD__];
    }

    private function createAuthorRequestConverter(): AuthorRequestConverter
    {
        if (!isset($this->cache[__METHOD__])) {
            $this->cache[__METHOD__] = new AuthorRequestConverter();
        }

        return $this->cache[__METHOD__];
    }

    private function createBookRequestConverter(): BookRequestConverter
    {
        if (!isset($this->cache[__METHOD__])) {
            $this->cache[__METHOD__] = new BookRequestConverter();
        }

        return $this->cache[__METHOD__];
    }
}
