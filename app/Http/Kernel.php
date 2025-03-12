<?php

namespace App\Http;

use Zuno\Middleware\Middleware;

class Kernel extends Middleware
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    public array $middleware = [
        \Zuno\Middleware\CorsMiddleware::class,
        \Zuno\Middleware\CsrfTokenMiddleware::class,
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected array $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'guest' => \App\Http\Middleware\GuestMiddleware::class,
    ];
}
