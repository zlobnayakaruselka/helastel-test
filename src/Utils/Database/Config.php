<?php

namespace App\Utils\Database;

use App\Utils\Database\Exception\InvalidDbConfigException;

/**
 * @method static string getDsn()
 * @method static string getUser()
 * @method static string getPassword()
 */
class Config
{
    private const PARAMETERS = ['PERCONA_HOST', 'PERCONA_PORT', 'DB_USER', 'DB_PASSWORD', 'DB_NAME'];

    /**
     * @var bool
     */
    private static $initialized = false;

    /**
     * @var string
     */
    private static $dsn;

    /**
     * @var string
     */
    private static $user;

    /**
     * @var string
     */
    private static $password;

    public static function __callStatic($name, $arguments):string
    {
        if (!self::$initialized) {
            self::initializeConfigs();
        }
        $propertyName = lcfirst(str_replace('get' , '', $name));

        return self::$$propertyName;
    }

    private static function initializeConfigs(): void
    {
        self::validate();

        $host = getenv('PERCONA_HOST') . ':' . getenv('PERCONA_PORT');
        $dbName = getenv('DB_NAME');

        self::$dsn = "mysql:host=$host;dbname=$dbName;charset=utf8";
        self::$user = getenv('DB_USER');
        self::$password = getenv('DB_PASSWORD');

        self::$initialized = true;
    }

    private static function validate(): void
    {
        foreach (self::PARAMETERS as $parameter) {
            if (empty(getenv($parameter))) {
                throw new InvalidDbConfigException($parameter);
            }
        }
    }
}
