<?php

namespace App\API\Request;

use App\API\Api;
use App\API\Controller\ControllerFactory;
use App\API\Request\Converter\DelegatingRequestConverter;
use App\API\Request\Exception\MethodNotSupportedException;
use App\API\Response\Response;
use App\API\Routes;

class RequestExecutor
{
    /**
     * @var DelegatingRequestConverter
     */
    private $requestConverter;

    /**
     * @var ControllerFactory
     */
    private $controllerFactory;

    public function __construct(DelegatingRequestConverter $requestConverter, ControllerFactory $controllerFactory)
    {
        $this->requestConverter = $requestConverter;
        $this->controllerFactory = $controllerFactory;
    }

    public function execute(): Response
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        $this->validateMethod($method);

        $routeData = $this->getRouteData($method, $uri);

        return $routeData
            ? $this->executeByRouteData($routeData, $uri)
            : new Response(Api::HTTP_NOT_FOUND, ['message' => "Route for $uri not found"]);
    }

    private function executeByRouteData(array $routeData, string $uri): Response
    {
        $controllerClass = $routeData['controller'];
        $action = $routeData['action'];

        $requestParameters = $this->requestConverter->convertToActionArguments($controllerClass, $action, $uri);

        $controller = $this->controllerFactory->createByClass($controllerClass);

        /** @var Response $response */
        $response = $controller->$action(...$requestParameters);

        return $response;
    }

    private function validateMethod(string $method): void
    {
        if (!array_key_exists($method, Routes::CONFIG)) {
            throw new MethodNotSupportedException($method);
        }
    }

    private function getRouteData($method, $uri): ?array
    {
        foreach (Routes::CONFIG[$method] as $routeData) {
            if (preg_match($routeData['uri_pattern'], $uri)) {
                return $routeData;
            }
        }

        return null;
    }
}
