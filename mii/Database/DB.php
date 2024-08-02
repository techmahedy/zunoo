<?php

namespace Mii\Database;

use PDO;
use Mii\Database\Builder;

class DB extends Builder
{
    /**
     * Set up and return a PDO connection instance.
     *
     * This method reads database configuration from environment variables,
     * constructs a DSN (Data Source Name) for connecting to a MySQL database,
     * and returns a new PDO instance configured with appropriate error handling
     * and default fetch mode.
     *
     * @return PDO The PDO connection instance.
     */
    public function getPdoInstance(): PDO
    {
        // Retrieve database configuration from environment variables
        $host = $_ENV['DB_HOST'];
        $dbName = $_ENV['DB_DATABASE'];
        $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8";
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];

        // Create and return a new PDO instance with error handling and fetch mode settings
        return new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable exception mode for errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch results as associative arrays
        ]);
    }
}
