<?php

namespace App\Http\Middleware;

use Zuno\Middleware\Contracts\Middleware;
use Zuno\Http\Response;
use Zuno\Http\Request;
use Zuno\Auth\Security\Auth;
use Closure;

class Authenticate implements Middleware
{
    /**
     * Handle an incoming request
     *
     * @param Request $request
     * @param \Closure(\Zuno\Http\Request) $next
     * @return Zuno\Http\Response
     */
    public function __invoke(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            return $next($request);
        }

        return redirect()->to('/login');
    }
}
