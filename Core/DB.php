<?php

namespace Core;

use mysqli;

class DB
{
    protected static $connection;

    public static function connect($host, $user, $pass, $db)
    {
        self::$connection = new mysqli($host, $user, $pass, $db);

        if (self::$connection->connect_error) {
            die('Database connection failed: ' . self::$connection->connect_error);
        }
    }

    public static function query($sql)
    {
        return self::$connection->query($sql);
    }

    public static function getConnection()
    {
        return self::$connection;
    }
}
