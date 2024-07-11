<?php

namespace Mii\Database;

use PDO;
use Mii\Database\Builder;

class DB extends Builder
{
    public function setConnection(): PDO
    {
        $host = $_ENV['DB_HOST'];
        $dbName = $_ENV['DB_DATABASE'];
        $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8";
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];

        return new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
}
