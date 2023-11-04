<?php

namespace App\Http\Middleware;

use Closure;
use App\Core\Request;
use App\Core\Middleware\Contracts\Middleware;

class ExampleMiddleware implements Middleware
{
    /**
     * __invoke.
     *
     * @param	Request	$request	
     * @param	Closure	$next   	
     * @return	mixed
     */
    public function __invoke(Request $request, Closure $next)
    {
        return $next($request);
    }
}
