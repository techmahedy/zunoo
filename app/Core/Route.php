<?php

namespace App\Core;

use ReflectionClass;
use App\Core\Request;
use ReflectionParameter;

class Route
{
    protected array $routes = [];

    public Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function getCallback()
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

    public function resolve($service)
    {
        $callback = $this->getCallback();

        if (!$callback) {
            return $this->request->getPath() . ' url not found';
        }
        $resolveDependencies = [];

        if (is_array($callback)) {
            $callback[0] = new $callback[0]();
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
                    if ($class === 'App\Core\Request') {
                        return $resolveDependencies[] = $this->request;;
                    }
                    return new $class();
                }
            }, $parameters);
        }

        return call_user_func($callback, ...$resolveDependencies);
    }
}
