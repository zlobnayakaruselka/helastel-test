<?php

namespace App\API;

use App\API\Request\RequestExecutor;
use App\API\Response\Response;

class Api
{
    public const HTTP_OK = 200;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_INTERNAL_SERVER_ERROR = 500;

    private const HTTP_STATUS_MAP = [
        self::HTTP_OK => 'OK',
        self::HTTP_NOT_FOUND => 'Not Found',
        self::HTTP_INTERNAL_SERVER_ERROR => 'Internal Server Error'
    ];

    /**
     * @var RequestExecutor
     */
    private $requestExecutor;

    public function __construct(RequestExecutor $requestExecutor)
    {
        $this->requestExecutor = $requestExecutor;
    }

    public function run(): void
    {
        try {
            $response = $this->requestExecutor->execute();
        } catch (\Exception $exception) {
            $response = new Response(Api::HTTP_INTERNAL_SERVER_ERROR);
        }

        $this->setHeaders($response->getHttpCode());

        if ($response->getData() !== null) {
            echo json_encode($response->getData(), JSON_PRETTY_PRINT);
        }
    }

    private function setHeaders(int $status)
    {
        $status = array_key_exists($status, self::HTTP_STATUS_MAP) ? $status : self::HTTP_INTERNAL_SERVER_ERROR;
        header("HTTP/1.1 $status " . self::HTTP_STATUS_MAP[$status]);
        header('Content-Type: application/json');
    }
}
