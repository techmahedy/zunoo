<?php

namespace App\Http\Middleware;

use Closure;
use Zuno\Request;
use Zuno\Middleware\Contracts\Middleware;

//! Example middleware
class Authenticate implements Middleware
{
    /**
     * handle.
     *
     * @param Request $request	
     * @param Closure $next   	
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /**
         * code
         */
        return $next($request);
    }
}
