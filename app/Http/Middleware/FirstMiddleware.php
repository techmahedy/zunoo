<?php

namespace App\Http\Middleware;

use Closure;
use App\Core\Request;
use App\Core\Middleware\Contracts\Middleware;

class FirstMiddleware implements Middleware
{
    public function __invoke(Request $request, Closure $next)
    {
        $data = $request->getBody();
        dump($data);
        return $next($request);
    }
}
