<?php

namespace App\Core\Middleware;

use Closure;
use App\Core\Request;
use App\Core\Middleware\Contracts\Middleware as ContractsMiddleware;

class Middleware
{

    /**
     * @var		closure	$start
     */
    protected Closure $start;

    public function __construct()
    {
        $this->start = function (Request $request) {
            return $request;
        };
    }

    /**
     * applyMiddleware.
     *
     * @access	public
     * @param  \App\Core\Middleware\Contracts\Middleware $middleware	
     * @return	void
     */
    public function applyMiddleware(ContractsMiddleware $middleware): void
    {
        $next = $this->start;
        $this->start = function (Request $request) use ($middleware, $next) {
            return $middleware($request, $next);
        };
    }

    /**
     * handle.
     *
     * @access	public
     * @param	request	$request	
     * @return	mixed
     */
    public function handle(Request $request): mixed
    {
        return call_user_func($this->start, $request);
    }
}
