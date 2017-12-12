<?php

namespace App\Functions\DB;

class Connection
{
    /**
     * Connection
     * @var type 
     */
    private static $conn;
    public function __construct()
    {

    }

    public function connect($config) {
        $pdo = new \PDO(\str_replace('pdo_','',$config['dbtype']).':host='.$config['dbhost'].';dbname='.$config['dbname'].';', $config['dbuser'], $config['dbpass']);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $pdo;
        
    }

    public static function get() {
        if (null === static::$conn) {
            static::$conn = new static();
        }
        return static::$conn;
    }

    public function simpleConnect($config) {
        $pdo = new \PDO(\str_replace('pdo_','',$config['dbtype']).':host='.$config['dbhost'].';', $config['dbuser'], $config['dbpass']);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $pdo;       
    }

}