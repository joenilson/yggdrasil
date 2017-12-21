<?php
/**
 * Copyright (C) 2017 Joe Nilson <joenilson at gmail dot com>
 * This program is free software: you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation, version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace App\Functions;

use App\Functions\DB\Connection;

class BaseConfig
{
    public $conn;
    public $dbExists;
    public function __construct()
    {

    }

    public static function verifyDatabase($config)
    {
        try {
            $conn = Connection::get()->connect($config);
            if($conn){
                return 'app-db-created-success';
            }
            return 'app-db-non-exists';
        } catch (\PDOException $e) {
            if($e->getCode() === 1049 || $e->getCode() === 7){
                return 'app-db-non-exists';
            }
            return $e->getCode();
        }
    }

    public static function createDatabase($config)
    {
        try {
            $conn = Connection::get()->simpleConnect($config);
            $conn->exec("CREATE DATABASE ".$config['dbname'].";");
            return 'app-db-created-success';
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
}