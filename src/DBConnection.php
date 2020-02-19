<?php
namespace Service;

use Config\Config;
use \PDO;

class DBConnection
{
    private $connection;

    public function __construct()
    {
        $config = new Config();
        $params = $config->getDatabaseConfig();
        try {
            $connection = new PDO("mysql:host=$params[servername];dbname=$params[database]",
                $params['username'], $params['password']);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            throw new \Exception("Não foi possível estabelecer".
                "uma conexão com o banco de dados.");
        }

        $this->connection = $connection;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
