<?php

return [
    'paths' => [
        'migrations' => './database/migrations',
        'seeds' => './database/seeds',
    ],
    'migration_base_class' => 'Mii\Migration\Migration',
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'laravel10' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'laravel10',
            'user' => 'mahedi',
            'pass' => '123',
            'port' => '3306'
        ]
    ]
];
