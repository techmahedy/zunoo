<?php

namespace App\Core;

use App\Core\Route;
use App\Core\Middleware\Middleware;
use App\Providers\AppServiceProvider;

class Application extends AppServiceProvider
{
    public $resolveDependency;
    public Route $route;
    protected $middleware;

    public function __construct(Route $route, Middleware $middleware)
    {
        $this->resolveDependency = $this->register();
        $this->route = $route;
        $this->middleware = $middleware;
    }

    /**
     * applyMiddleware.
     * @param  \App\Core\Middleware\Contracts\Middleware $middleware	
     * @return	mixed
     */
    public function applyMiddleware($middleware)
    {
        return $this->middleware->applyMiddleware($middleware);
    }

    public function run()
    {
        /**
         * @param  \App\Core\Middleware\Middleware $middleware	
         * @param	$this->resolveDependency
         */
        echo $this->route->resolve(
            $this->middleware,
            $this->resolveDependency
        );
    }
}
