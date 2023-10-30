<?php

namespace App\Core;

use Closure;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use App\Core\Controllers\Controller;
use Psr\Container\ContainerInterface;
use App\Core\Exceptions\CouldNotResolveClassException;
use App\Core\Exceptions\CouldNotResolveAbstractionException;

class Container extends Controller implements ContainerInterface
{
    public array $services = [];

    protected array $instances = [];

    protected static $instance;

    public static function getInstance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new static;
        }

        return self::$instance;
    }

    public function bind(string $key, mixed $value, bool $singleton = false): self
    {
        if (is_string($key) && class_exists($key)) {
            $value = fn () => new $value;
        }

        $this->services[$key] = $value;

        if ($singleton) {
            return $this->instances[$key] = null;
        }

        return $this;
    }

    public function singleton(string $key, mixed $callback): self
    {
        return $this->bind($key, $callback, true);
    }

    public function get(string $service): mixed
    {
        if ($this->has($service)) {
            return $this->fetchBoundService($service);
        }

        return $this->build($service);
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->services);
    }

    protected function build(string $service)
    {
        try {
            $reflector = new ReflectionClass($service);
        } catch (ReflectionException) {
            throw new CouldNotResolveClassException();
        }

        if (!$reflector->isInstantiable()) {
            throw new CouldNotResolveAbstractionException(sprintf('Could not resolve interface or abstract class [%s]', $service));
        }

        $parameters = $reflector->getConstructor()?->getParameters() ?? [];
        $resolveDependencies = array_map(function (ReflectionParameter $parameter) {
            $class = $parameter->getType()->getName();
            if (class_exists($class)) {
                return $this->build($class);
            }
        }, $parameters);

        return $reflector->newInstanceArgs($resolveDependencies);
    }

    protected function fetchBoundService(string $service)
    {
        if (
            array_key_exists($service, $this->instances)
            && !is_null($this->instances[$service])
        ) {
            return $this->instances[$service];
        }

        $serviceResolver = $this->services[$service];

        $resolvedService = $serviceResolver instanceof Closure
            ? $serviceResolver($this)
            : $serviceResolver;

        if (array_key_exists($service, $this->instances)) {
            return $this->instances[$service] = $resolvedService;
        }

        return $resolvedService;
    }
}
