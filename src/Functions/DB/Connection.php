<?php
namespace App\Functions\DB;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

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

    /**
     * Set a connection to the app database using Doctrine
     * @param type $dbconfig
     * @return Doctrine object
     */
    public function connect($dbconfig) {
        $config = new Configuration();
        $connectionParams = ['url'=>$dbconfig];
        $conn = DriverManager::getConnection($connectionParams, $config);
        //$pdo = new \PDO(\str_replace('pdo_','',$config['dbtype']).':host='.$config['dbhost'].';dbname='.$config['dbname'].';', $config['dbuser'], $config['dbpass']);
        //$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $conn->connect();
        return $conn->isConnected();

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