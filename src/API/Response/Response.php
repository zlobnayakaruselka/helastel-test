<?php

namespace App\API\Response;

class Response
{
    /**
     * @var int
     */
    private $httpCode;

    /**
     * @var array | null
     */
    private $data;

    public function __construct(int $httpCode, ?array $data = null)
    {
        $this->httpCode = $httpCode;
        $this->data = $data;
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    public function getData(): ?array
    {
        return $this->data;
    }
}
