<?php

namespace App\Http\Middleware;

use Closure;
use App\Core\Request;
use App\Core\Middleware\Contracts\Middleware;

class Authenticate implements Middleware
{
    /**
     * handle.
     *
     * @param	Request	$request	
     * @param	Closure	$next   	
     * @return	mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /**
         * code
         */
        return $next($request);
    }
}
