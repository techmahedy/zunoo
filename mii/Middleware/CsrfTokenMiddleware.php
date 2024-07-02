<?php

namespace Mii\Middleware;

use Closure;
use Mii\Request;
use Mii\Middleware\Contracts\Middleware;

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
            throw new \Exception("CSRF token not found");
        }

        return $next($request);
    }
}
