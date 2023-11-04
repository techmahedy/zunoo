<?php

namespace App\Core;

use ReflectionClass;
use App\Core\Request;
use ReflectionParameter;

class Route
{
    protected array $routes = [];

    protected array $urlParams = [];

    public Request $request;

    protected string $name;

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

    /**
     * get.
     *
     * @access	public
     * @param	mixed	$path    	
     * @param	mixed	$callback	
     * @return	void
     */
    public function get($path, $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     * post.
     *
     * @access	public
     * @param	mixed	$path    	
     * @param	mixed	$callback	
     * @return	void
     */
    public function post($path, $callback): void
    {
        $this->routes['post'][$path] = $callback;
    }

    public function getCallback(): mixed
    {
        $method = $this->request->getMethod();
        $url = $this->request->getPath();
        $routes = $this->routes[$method] ?? [];
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
     * @access	public
     * @param	\App\Core\Middleware\Middleware $middleware	
     * @param	contracts $serviceClass   	
     * @return	mixed
     */
    public function resolve($middleware, $service): mixed
    {
        $middleware->handle($this->request);

        $callback = $this->getCallback();

        if (!$callback) {
            throw new \Exception("Route path " . $this->request->getPath() . " is not defined for " . $this->request->getMethod() . ' request');
        }
        $resolveDependencies = [];

        if (!empty($this->request->getRouteParams())) {
            foreach ($this->request->getRouteParams() ?? [] as $key => $value) {
                $this->urlParams[] = $value;
            }
        }

        if (is_array($callback)) {
            $reflector = new ReflectionClass($callback[0]);
            $parameters = $reflector->getConstructor()?->getParameters() ?? [];
            if (isset($parameters)) {
                $resolveDependencies = array_map(function (ReflectionParameter $parameter) use ($service) {
                    $class = $parameter->getType()->getName();
                    if (class_exists($class)) {
                        return new $class();
                    }
                    if (interface_exists($class)) {
                        $serviceClass = $service->resolveDependency->services[$class];
                        return new $serviceClass();
                    }
                }, $parameters);
            }

            $callback[0] = new $callback[0](...$resolveDependencies);
            $reflector = new ReflectionClass($callback[0]);
            $actionMethod = $callback[1];
            $parameters = $reflector->getMethod($actionMethod)?->getParameters() ?? [];
            $resolveDependencies = array_map(function (
                ReflectionParameter $parameter
            ) use ($service) {
                $class = $parameter->getType()?->getName();
                if (!is_null($class)) {
                    if (interface_exists($class)) {
                        $serviceClass = $service->resolveDependency->services[$class];
                        return new $serviceClass();
                    }
                    return new $class();
                }
            }, $parameters);
        }

        return call_user_func($callback, ...array_merge(array_filter($this->urlParams), array_filter($resolveDependencies)));
    }
}
