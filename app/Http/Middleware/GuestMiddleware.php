<?php

namespace App\Http\Middleware;

use Zuno\Http\Request;
use Zuno\Auth\Security\Auth;
use Closure;

class GuestMiddleware
{
    /**
     * Handle an incoming request
     *
     * @param Request $request
     * @param \Closure(\Zuno\Http\Request) $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            return redirect()->url('/home');
        }

        return $next($request);
    }
}
