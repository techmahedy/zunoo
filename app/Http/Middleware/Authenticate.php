<?php

namespace App\Http\Middleware;

use Closure;
use Mii\Request;
use Mii\Middleware\Contracts\Middleware;

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
