<?php

namespace App\Utils\Database;

use PDO;

class Db
{
    /**
     * @var PDO
     */
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function fetch(string $query, $params = [], int $fetchStyle = null): ?array
    {
        $stm = $this->prepareQuery($query, $params);

        return $stm->fetch($fetchStyle) ?: null;
    }

    public function fetchAll(string $query, $params = [], int $fetchStyle = null): array
    {
        $stm = $this->prepareQuery($query, $params);

        return $stm->fetchAll($fetchStyle);
    }

    private function prepareQuery(string $query, $params = []): \PDOStatement
    {
        $stm = $this->connection->prepare($query);

        foreach ($params as $name => [$value, $type]) {
            $stm->bindValue($name, $value, $type);
        }

        $stm->execute();

        return $stm;
    }
}
