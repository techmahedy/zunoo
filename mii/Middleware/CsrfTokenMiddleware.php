<?php

namespace Mii\Middleware;

use Closure;
use Mii\Request;
use Mii\Middleware\Contracts\Middleware;

class CsrfTokenMiddleware implements Middleware
{
    /**
     * Handles an incoming request and verifies the CSRF token.
     *
     * This middleware checks if the request is a POST request and if the 
     * CSRF token is present. If the CSRF token is missing, an exception is thrown.
     * 
     * @param Request $request The incoming request instance.
     * @param Closure $next The next middleware or request handler.
     * 
     * @return mixed The result of the next middleware or request handler.
     * 
     * @throws \Exception If the CSRF token is not present in a POST request.
     */
    public function __invoke(Request $request, Closure $next): mixed
    {
        // Check if the request is a POST request
        if ($request->isPost() && !$request->has('csrf_token')) {
            throw new \Exception("CSRF token not found");
        }

        // Pass the request to the next middleware or request handler
        return $next($request);
    }
}
