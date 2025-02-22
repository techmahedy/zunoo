<?php

return [
    'paths' => [
        'migrations' => './database/migrations',
        'seeds' => './database/seeds',
    ],

    // Base class for migrations
    'migration_base_class' => 'Zuno\Migration\Migration',

    'environments' => [
        // Default table to track migrations
        'default_migration_table' => 'phinxlog',

        // Configuration for the 'Zuno' environment
        'Zuno' => [
            'adapter' => 'mysql',  // Database adapter type
            'host' => 'localhost',  // Database host
            'name' => 'test', // Database name
            'user' => 'mahedi', // Database user
            'pass' => '123456', // Database password
            'port' => '3306' // Database port
        ]
    ]
];
