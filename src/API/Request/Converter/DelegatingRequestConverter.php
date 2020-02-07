<?php

namespace App\API\Request\Converter;

use App\API\Request\Converter\Exception\ConverterNotExistException;

class DelegatingRequestConverter
{
    /**
     * @var AbstractRequestConverter[]
     */
    private $converters;

    public function __construct(array $converters)
    {
        $this->converters = $converters;
    }

    public function convertToActionArguments(string $controllerName, string $actionName, string $uri): array
    {
        /** @var AbstractRequestConverter $converter */
        foreach ($this->converters as $converter) {
            if ($converter->isSupport($controllerName, $actionName)) {
                return $converter->convertToActionArguments($actionName, $uri);
            }
        }

        throw new ConverterNotExistException($controllerName, $actionName);
    }
}
