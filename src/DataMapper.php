<?php

namespace refactored;

class DataMapper
{
    static protected $db; //Represents a connection between PHP and a MySQL database

    static protected function initDbc()
    {
        self::$db = new \PDO('mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME.';charset=utf8mb4', DB_USERNAME, DB_PASSWORD,
            array(
                \PDO::ATTR_EMULATE_PREPARES => false, 
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            )
        );
    }
}

?>