<?php

return [
    // Paths configuration for migrations and seeds
    'paths' => [
        // Directory where migration files are stored
        'migrations' => './database/migrations',
        // Directory where seed files are stored
        'seeds' => './database/seeds',
    ],

    // Base class for migrations
    'migration_base_class' => 'Zuno\Migration\Migration',

    'environments' => [
        // Default table to track migrations
        'default_migration_table' => 'phinxlog',

        // Configuration for the 'Zuno' environment
        'Zuno' => [
            // Database adapter type
            'adapter' => 'mysql',
            // Database host
            'host' => 'localhost',
            // Database name
            'name' => 'Zuno',
            // Database user
            'user' => 'mahedi',
            // Database password
            'pass' => '123',
            // Database port
            'port' => '3306'
        ]
    ]
];
