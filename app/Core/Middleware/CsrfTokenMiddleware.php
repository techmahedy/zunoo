<?php

namespace App\Core\Middleware;

use Closure;
use App\Core\Request;
use App\Core\Middleware\Contracts\Middleware;

class CsrfTokenMiddleware implements Middleware
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
        if (
            $request->isPost() &&
            !$request->has('csrf_token')
        ) {
            throw new \Exception("csrf token not found while form submission");
        }

        return $next($request);
    }
}
