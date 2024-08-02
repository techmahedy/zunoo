<?php

namespace Mii\Middleware;

use Closure;
use Mii\Request;
use Mii\Middleware\Contracts\Middleware as ContractsMiddleware;

class Middleware
{
    /**
     * Closure that handles the request processing.
     * 
     * @var Closure(Request): Request
     */
    public Closure $start;

    /**
     * Initialize the middleware with a default request handler.
     */
    public function __construct()
    {
        $this->start = fn (Request $request) => $request;
    }

    /**
     * Apply a given middleware to the current middleware chain.
     *
     * @param ContractsMiddleware $middleware The middleware to apply.
     * @return void
     */
    public function applyMiddleware(ContractsMiddleware $middleware): void
    {
        $next = $this->start;
        $this->start = fn (Request $request) => $middleware($request, $next);
    }

    /**
     * Handle the incoming request through the middleware chain.
     *
     * @param Request $request The incoming request.
     * @return mixed The result of the middleware processing.
     */
    public function handle(Request $request): mixed
    {
        return ($this->start)($request);
    }
}
