<?php

namespace App\Core;

use App\Core\Route;
use App\Core\Middleware\Middleware;
use App\Providers\AppServiceProvider;

class Application extends AppServiceProvider
{
    /**
     * @var		public	cons
     */
    public const VERSION = '1.0';

    /**
     * @var		public	$resolveDependency
     */
    public $resolveDependency;

    /**
     * @var		route	$route
     */
    public Route $route;

    /**
     * @var		mixed	$middleware
     */
    protected $middleware;

    /**
     * __construct.
     *
     * @access	public
     * @param	route     	$route     	
     * @param	middleware	$middleware	
     * @return	void
     */
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
    public function applyMiddleware($middleware): mixed
    {
        return $this->middleware->applyMiddleware($middleware);
    }

    /**
     * Run the application.
     *
     * @access	public
     * @return	void
     */
    public function run(): void
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
