<?php

namespace App\Http;

class Kernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    public array $middleware = [
        \App\Core\Middleware\CsrfTokenMiddleware::class,
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected array $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
    ];
}
