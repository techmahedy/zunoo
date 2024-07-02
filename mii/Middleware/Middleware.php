<?php

namespace Mii\Middleware;

use Closure;
use Mii\Request;
use Mii\Middleware\Contracts\Middleware as ContractsMiddleware;

class Middleware
{
    /**
     * @var		closure	$start
     */
    public Closure $start;

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
     * @param  \Mii\Middleware\Contracts\Middleware $middleware	
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
