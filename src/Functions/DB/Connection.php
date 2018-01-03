<?php
namespace App\Functions\DB;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use PDO;

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
        try {
            $conn = DriverManager::getConnection($connectionParams, $config);
            $conn->connect();
            $status = $conn->isConnected();
        } catch(DBALException $e) {
            $status = false;
        }        
        return $status;

    }

    public static function get() {
        if (null === static::$conn) {
            static::$conn = new static();
        }
        return static::$conn;
    }

    public function simpleConnect($config) {
        $pdo = new PDO(\str_replace('pdo_','',$config['database_driver']).':host='.$config['database_host'].';', $config['database_user'], $config['database_password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

}