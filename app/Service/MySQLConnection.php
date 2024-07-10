<?php

namespace App\Service;

use App\Interface\ConnectionInterface;

class MySQLConnection implements ConnectionInterface
{
    public function getConnection(): string
    {
        return dd("MySQL Connection");
    }
}
