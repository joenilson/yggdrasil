<?php

namespace App\Functions\DB;

class SystemTables
{
    /**
     * Connection Interface
     *
     * @var PDO\Object connection
     */
    public $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
}