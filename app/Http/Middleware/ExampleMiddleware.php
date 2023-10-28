<?php

namespace App\Http\Middleware;

use Closure;
use App\Core\Request;
use App\Core\Middleware\Contracts\Middleware;

class ExampleMiddleware implements Middleware
{
    public function __invoke(Request $request, Closure $next)
    {
        $data = $request->getBody();
        return $next($request);
    }
}
