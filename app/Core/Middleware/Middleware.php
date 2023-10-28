<?php

namespace App\Core\Middleware;

use App\Core\Request;
use App\Core\Middleware\Contracts\Middleware as ContractsMiddleware;

class Middleware
{
    protected $start;

    public function __construct()
    {
        $this->start = function (Request $request) {
            return $request;
        };
    }

    public function applyMiddleware(ContractsMiddleware $middleware)
    {
        $next = $this->start;
        $this->start = function (Request $request) use ($middleware, $next) {
            return $middleware($request, $next);
        };
    }

    public function handle(Request $request)
    {
        return call_user_func($this->start, $request);
    }
}
