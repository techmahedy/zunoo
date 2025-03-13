<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value sets the name of your application, which is used in system 
    | notifications, UI elements, and logs where an application name is needed.
    |
    */

    'name' => env('APP_NAME', 'Zuno'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | Defines the current environment of the application (e.g., "local",
    | "production", "staging"). This setting affects configurations such as
    | logging and error handling. It should be set in the ".env" file.
    |
    */

    'env' => env('APP_ENV', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When enabled, the application displays detailed error messages with stack
    | traces. In production, this should be disabled to prevent exposing
    | sensitive information to users.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | The base URL of your application. This is used for generating proper URLs
    | in console commands, links, and redirections. Ensure this matches your
    | deployed application's domain.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | Specifies the default language/locale for the application, used by 
    | translation and localization services. Set this to match the primary 
    | language of your application.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used for encrypting sensitive data within the application. 
    | It should be a randomly generated 32-character string. Do not expose 
    | this key publicly. Ensure it is set in the ".env" file.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'providers' => [
        App\Providers\AppServiceProvider::class,
    ],
];
