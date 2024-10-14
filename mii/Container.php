<?php

namespace Mii;

class Container
{
    /**
     * Array to hold service definitions.
     *
     * @var array<string, mixed>
     */
    private static array $bindings = [];

    public function bind(string $abstract, callable $concrete): void
    {
        self::$bindings[$abstract] = $concrete;
    }

    /**
     * Bind a service to the container.
     *
     * @param string $key The service name or class name (could be an interface).
     * @return mixed
     */
    public function get(string $abstract)
    {
        // Wrap value into a closure if it's a class name
        if (!isset(self::$bindings[$abstract])) {
            return new $abstract();
        }

        return self::$bindings[$abstract]();
    }

    /**
     * Check if the container has a binding for the given service.
     *
     * @param string $key The service name or class name.
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, self::$bindings);
    }
}
