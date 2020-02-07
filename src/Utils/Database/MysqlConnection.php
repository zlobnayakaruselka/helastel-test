<?php

namespace App\Utils\Database;

use PDO;

class MysqlConnection
{
    /**
     * @var PDO | null
     */
    private static $connection = null;

    public static function getPDO(): PDO
    {
        if (self::$connection === null) {
            self::$connection = new PDO(Config::getDsn(), Config::getUser(), Config::getPassword());
        }

        return self::$connection;
    }
}
