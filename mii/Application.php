<?php

namespace Mii;

use Mii\Route;
use Mii\Middleware\Middleware;
use App\Providers\AppServiceProvider;
use Mii\Middleware\Contracts\Middleware as ContractsMiddleware;

class Application extends AppServiceProvider
{
    /**
     * The version of the application.
     *
     * @var string
     */
    public const VERSION = '1.0';

    /**
     * Dependency resolver instance.
     *
     * This property holds the result of the dependency registration.
     *
     * @var mixed
     */
    public mixed $resolveDependency;

    /**
     * The route handler instance.
     *
     * This property holds an instance of the Route class responsible for routing.
     *
     * @var Route
     */
    public Route $route;

    /**
     * The middleware handler instance.
     *
     * This property holds an instance of the Middleware class responsible for handling middleware.
     *
     * @var Middleware
     */
    protected Middleware $middleware;

    /**
     * Constructs the Application instance.
     *
     * Initializes the dependency resolver, route handler, and middleware handler.
     *
     * @param Route $route The route handler instance.
     * @param Middleware $middleware The middleware handler instance.
     */
    public function __construct(Route $route, Middleware $middleware)
    {
        /**
         * Register application dependency injection.
         *
         * This method should handle the registration of dependencies for the application.
         *
         * @return void The result of the dependency registration.
         */
        $this->resolveDependency = $this->register();

        // Assign the route handler instance.
        $this->route = $route;

        // Assign the middleware handler instance.
        $this->middleware = $middleware;
    }

    /**
     * Apply global middleware to the application.
     *
     * Delegates the application of middleware to the middleware handler.
     *
     * @param ContractsMiddleware $middleware The middleware to be applied.
     * @return mixed The result of applying the middleware.
     */
    public function applyMiddleware(ContractsMiddleware $middleware): mixed
    {
        // Delegate the middleware application to the middleware handler.
        return $this->middleware->applyMiddleware($middleware);
    }

    /**
     * Run the application and resolve the route.
     *
     * Executes the application logic by resolving the route using the provided middleware
     * and dependency resolver.
     *
     * @return void
     * @throws \ReflectionException If there is an issue with reflection during route resolution.
     */
    public function run(): void
    {
        // Resolve and output the route result using the route handler,
        // middleware handler, and dependency resolver.
        echo $this->route->resolve(
            $this->middleware,
            $this->resolveDependency
        );
    }
}
