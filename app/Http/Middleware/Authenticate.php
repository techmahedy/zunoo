<?php

namespace App\Http\Middleware;

use Closure;
use Zuno\Request;

//! Example middleware
class Authenticate
{
    /**
     * Handle an incoming request
     *
     * @param Request $request
     * @param \Closure(\Zuno\Request) $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Example
        // $ip = $_SERVER['REMOTE_ADDR'] ??= '127.0.0.1';
        // if ($ip === '127.0.0.1') {
        //     return $next($request);
        // }

        // dd("{This $ip is bloked}");

        return $next($request);
    }
}
