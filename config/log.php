<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that is utilized to write
    | messages to your logs. The value provided here should match one of
    | the channels present in the list of "channels" configured below.
    |
    */

    'default' => env('LOG_CHANNEL', 'daily'), // Or 'single', 'daily'

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Zuno
    | utilizes the Monolog PHP logging library, which includes a variety
    | of powerful log handlers and formatters that you're free to use.
    |
    | Available drivers: "single", "daily", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single', 'daily'],
            'firephp' => true,
        ],

        'single' => [
            'driver' => 'single',
            'path' => getcwd() . '/storage/logs/zuno.log',
            'level' => \Monolog\Level::Debug,
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => getcwd() . '/storage/logs/zuno.log',
            'level' => \Monolog\Level::Info
        ],
    ],
];
