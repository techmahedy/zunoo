<?php

namespace Mii;

use App\Http\Kernel;
use ReflectionClass;
use Mii\Request;
use ReflectionParameter;
use Mii\Middleware\Middleware;

class Route extends Kernel
{
    protected static array $routes = [];

    protected array $urlParams = [];

    public Request $request;

    /**
     * __construct.
     *
     * @param	Request	$request	
     * @return	void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public static function __callStatic($name, $arguments)
    {
        return match ($name) {
            'get' => (new Route(new Request))->getRoute($arguments[0], $arguments[1]),
            'post' => (new Route(new Request))->postRoute($arguments[0], $arguments[1]),
            default => throw new \Exception($name . ' method not found', true)
        };
    }

    /**
     * get.
     *
     * @access	public
     * @param	mixed	$path    	
     * @param	mixed	$callback	
     * @return	Route
     */
    public function getRoute($path, $callback): Route
    {
        self::$routes['get'][$path] = $callback;

        return $this;
    }

    /**
     * post.
     *
     * @access	public
     * @param	mixed	$path    	
     * @param	mixed	$callback	
     * @return	Route
     */
    public function postRoute($path, $callback): Route
    {
        self::$routes['post'][$path] = $callback;

        return $this;
    }

    /**
     * middleware.
     *
     * @access public
     * @param string $key middleware
     * @return Route
     * @throws \Exception
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
     * getCallback.
     *
     * @access	public
     * @return	mixed
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
     * resolve.
     *
     * @access public
     * @param Middleware $middleware
     * @param $service
     * @return mixed
     * @throws \ReflectionException
     * @throws \Exception
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
