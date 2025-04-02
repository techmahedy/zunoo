<?php

use Zuno\DI\Container;

$app = require_once __DIR__ . '/bootstrap/app.php';

return [
    'paths' => [
        'migrations' => './database/migrations',
        'seeds' => './database/seeds',
    ],
    'migration_base_class' => Zuno\Migration\Migration::class,
    'environments' => [
        'default_migration_table' => 'migrations',
        'zuno' => [
            'adapter' => env('DB_CONNECTION'),
            'host' => env('DB_HOST'),
            'name' => env('DB_DATABASE'),
            'user' => env('DB_USERNAME'),
            'pass' => env('DB_PASSWORD'),
            'port' => env('DB_PORT'),
        ]
    ],
    'migration_order' => 'creation',
    'migration_file_name' => 'datetime',
    'callback' => fn() => Container::setInstance($app)
];
