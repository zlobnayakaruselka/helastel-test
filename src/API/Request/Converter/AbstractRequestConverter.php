<?php

namespace App\API\Request\Converter;

use App\API\Request\Converter\Exception\ConverterNotExistException;

abstract class AbstractRequestConverter
{
    protected const SUPPORTED_CONTROLLER = '';
    protected const SUPPORTED_ACTIONS = [];

    public function isSupport(string $controllerName, string $actionName): bool
    {
        return $controllerName === static::SUPPORTED_CONTROLLER
            && in_array($actionName, static::SUPPORTED_ACTIONS)
            && method_exists($this, $this->getConverterMethodName($actionName));
    }

    public function convertToActionArguments(string $actionName, string $uri): array
    {
        $methodName = $this->getConverterMethodName($actionName);

        if (!method_exists($this, $methodName)) {
            throw new ConverterNotExistException(self::SUPPORTED_CONTROLLER, $actionName);
        }

        return $this->$methodName($uri);
    }

    protected function getConverterMethodName(string $actionName): string
    {
        return 'convertFor' . ucfirst($actionName);
    }
}
