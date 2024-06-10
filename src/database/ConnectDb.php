<?php

namespace Api\database;

use \PDO;

class ConnectDb
{
    
    private static $instance = null;
    private $conn;

    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $name = 'registros';
    private $port = '3306';

    private function __construct()
    {
        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->name", $this->user, $this->pass);
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new ConnectDb();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
