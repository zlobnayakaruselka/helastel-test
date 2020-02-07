<?php

namespace App\Utils\EntityManager\Exception;

class EntityNotFoundException extends \RuntimeException
{
    /** @var string */
    private $entityName;

    /** @var array */
    private $params;

    public function __construct(string $entityName, ?string $query = null, array $params = [])
    {
        $message = 'Entity "' . $entityName . '" not found';

        if ($query !== null) {
            $message .= PHP_EOL . $query;
        }

        if (!empty($params)) {
            $message .= PHP_EOL . var_export($params, true);
        }

        parent::__construct($message);

        $this->entityName = $entityName;
        $this->params = $params;
    }

    public function getEntityName(): string
    {
        return $this->entityName;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getParamsForExport(): array
    {
        $exportParams = [];
        array_walk($this->params, function ($param, $key) use (&$exportParams) {
            $exportKey = str_replace(':', '', $key);
            $exportParams[$exportKey] = $param[0];
        });

        return $exportParams;
    }
}
