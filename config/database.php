<?php

return [
    'default' => 'mysql',
    'connections' => [
        'mysql' => [
            'host' => '127.0.0.1',
            'database' => env('DB_DATABASE') ?? 'zuno',
            'username' => env('DB_USERNAME') ?? 'root',
            'password' => env('DB_PASSWORD') ?? 'password',
        ],
    ],
];
