<?php

namespace Mii;

use App\Http\Kernel;
use ReflectionClass;
use Mii\Request;
use ReflectionParameter;
use Mii\Middleware\Middleware;

class Route extends Kernel
{
    /**
     * Holds the registered routes.
     *
     * @var array
     */
    protected static array $routes = [];

    /**
     * Stores URL parameters extracted from routes.
     *
     * @var array
     */
    protected array $urlParams = [];

    /**
     * The current request instance.
     *
     * @var Request
     */
    public Request $request;

    /**
     * Constructor to initialize the request property.
     *
     * @param Request $request The request instance.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Magic method to handle static method calls for 'get' and 'post' route registration.
     *
     * @param string $name The method name.
     * @param array $arguments The method arguments.
     * @return Route
     * @throws \Exception If method name is not 'get' or 'post'.
     */
    public static function __callStatic($name, $arguments): Route
    {
        return match ($name) {
            'get' => (new Route(new Request))->getRoute($arguments[0], $arguments[1]),
            'post' => (new Route(new Request))->postRoute($arguments[0], $arguments[1]),
            default => throw new \Exception($name . ' method not found', true)
        };
    }

    /**
     * Registers a GET route with a callback.
     *
     * @param string $path The route path.
     * @param callable $callback The callback for the route.
     * @return Route
     */
    public function getRoute($path, $callback): Route
    {
        self::$routes['get'][$path] = $callback;

        return $this;
    }

    /**
     * Registers a POST route with a callback.
     *
     * @param string $path The route path.
     * @param callable $callback The callback for the route.
     * @return Route
     */
    public function postRoute($path, $callback): Route
    {
        self::$routes['post'][$path] = $callback;

        return $this;
    }

    /**
     * Applies middleware to the route.
     *
     * @param string $key The middleware key.
     * @return Route
     * @throws \Exception If the middleware is not defined.
     */
    public function middleware(string $key): Route
    {
        if (!isset($this->routeMiddleware[$key])) {
            throw new \Exception("Middleware " . '[' . $key . ']' . " is not defined");
        }

        (new $this->routeMiddleware[$key])->handle(
            new Request,
            (new Middleware)->start
        );

        return $this;
    }

    /**
     * Retrieves the callback for the current route based on the request method and path.
     *
     * @return mixed The route callback or false if not found.
     */
    public function getCallback(): mixed
    {
        $method = $this->request->getMethod();
        $url = $this->request->getPath();
        $routes = self::$routes[$method] ?? [];
        $routeParams = false;

        // Start iterating registed routes
        foreach ($routes as $route => $callback) {
            // Trim slashes
            $routeNames = [];

            if (!$route) {
                continue;
            }

            // Find all route names from route and save in $routeNames
            if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) {
                $routeNames = $matches[1];
            }

            // Convert route name into regex pattern
            $routeRegex = "@^" . preg_replace_callback('/\{\w+(:([^}]+))?}/', fn ($m) => isset($m[2]) ? "({$m[2]})" : '(\w+)', $route) . "$@";

            // Test and match current route against $routeRegex
            if (preg_match_all($routeRegex, $url, $valueMatches)) {
                $values = [];
                $counter = count($valueMatches);
                for ($i = 1; $i < $counter; $i++) {
                    $values[] = $valueMatches[$i][0];
                }
                $routeParams = array_combine($routeNames, $values);

                $this->request->setRouteParams($routeParams);
                return $callback;
            }
        }
        return false;
    }

    /**
     * Resolves and executes the route callback with the middleware and dependencies.
     *
     * @param Middleware $middleware The middleware instance.
     * @param $service The service container for resolving dependencies.
     * @return mixed The result of the callback execution.
     * @throws \ReflectionException If there is an issue with reflection.
     * @throws \Exception If the route callback is not defined.
     */
    public function resolve(Middleware $middleware, $service): mixed
    {
        $middleware->handle($this->request);

        $callback = $this->getCallback();

        if (!$callback) {
            throw new \Exception("Route path " . '[' . $this->request->getPath() . ']' . " is not defined");
        }

        $resolveDependencies = [];
        if (!empty($this->request->getRouteParams())) {
            foreach ($this->request->getRouteParams() as $key => $value) {
                $this->urlParams[] = $value;
            }
        }

        if (is_array($callback)) {
            $reflector = new ReflectionClass($callback[0]);
            $parameters = $reflector->getConstructor()?->getParameters() ?? [];
            if (isset($parameters)) {
                $resolveDependencies = array_map(function (ReflectionParameter $parameter) use ($service) {
                    $resolvedClass = $parameter->getType()->getName();
                    $serviceClass = $service->resolveDependency->services[$resolvedClass] ?? $resolvedClass;
                    if ($serviceClass instanceof $resolvedClass) {
                        return new $resolvedClass();
                    }
                    return new $serviceClass();
                }, $parameters);
            }

            $callback[0] = new $callback[0](...$resolveDependencies);
            $reflector = new ReflectionClass($callback[0]);
            $actionMethod = $callback[1];
            $parameters = $reflector->getMethod($actionMethod)?->getParameters() ?? [];

            $resolveDependencies = array_map(function (
                ReflectionParameter $parameter
            ) use ($service) {
                $resolvedClass = $parameter->getType()?->getName();
                if (!is_null($resolvedClass)) {
                    $serviceClass = $service->resolveDependency->services[$resolvedClass] ?? $resolvedClass;
                    if ($resolvedClass instanceof $serviceClass) {
                        return new $resolvedClass();
                    }

                    return new $serviceClass();
                }
            }, $parameters);
        }

        return call_user_func(
            $callback,
            ...array_merge(
                array_filter($this->urlParams),
                array_filter($resolveDependencies)
            )
        );
    }
}
