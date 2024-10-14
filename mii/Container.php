<?php

namespace Mii;

class Container
{
    private static array $bindings = [];

    public function bind(string $abstract, callable $concrete): void
    {
        self::$bindings[$abstract] = $concrete;
    }

    public function get(string $abstract)
    {
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
