<?php

return [
    'paths' => [
        'migrations' => './database/migrations',
        'seeds' => './database/seeds',
    ],
    'migration_base_class' => Zuno\Migration\Migration::class,
    'environments' => [
        'default_migration_table' => 'migrations',
        'zuno' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'test',
            'user' => 'mahedi',
            'pass' => '123456',
            'port' => '3306'
        ]
    ]
];
