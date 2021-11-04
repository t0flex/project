<?php

namespace application\database;

use PDO;

/**
 * Class Database
 * @package application\database
 */
class Database
{
    private static $instance = null;

    private static $type;
    private static $host;
    private static $dbname;
    private static $charset;
    private static $username;
    private static $password;

    /**
     * Database constructor.
     */
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @return null|PDO
     */
    private static function instance()
    {
        if (self::$instance === null) {
            $opt = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];
            $dsn = self::$type . ':host=' . self::$host . ';dbname=' . self::$dbname . ';charset=' . self::$charset;
            self::$instance = new PDO($dsn, self::$username, self::$password, $opt);
        }

        return self::$instance;
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        return call_user_func_array([self::instance(), $method], $args);
    }

    /**
     * @param $sql
     * @param array $args
     * @return bool|\PDOStatement
     */
    public static function execute($sql, $args = [])
    {
        if (!$args) {
            return self::instance()->query($sql);
        }

        $stmt = self::instance()->prepare($sql);

        $stmt->execute($args);

        return $stmt;

    }

    /**
     * @param $params
     */
    public static function loadParams($params)
    {
        if (null !== $params) {
            $properties = get_class_vars(static::class);
            foreach ($properties as $property => $value) {
                if (isset($params[$property])) {
                    self::$$property = $params[$property];
                }
            }
        }
    }
}