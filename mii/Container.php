<?php

namespace Mii;

use Closure;
use ReflectionClass;
use ReflectionParameter;
use Mii\Exceptions\CouldNotResolveClassException;
use Mii\Exceptions\CouldNotResolveAbstractionException;

class Container
{
    /**
     * Array to hold service definitions.
     *
     * @var array<string, mixed>
     */
    public array $services = [];

    /**
     * Array to hold singleton instances.
     *
     * @var array<string, mixed|null>
     */
    protected array $instances = [];

    /**
     * The single instance of the container (singleton pattern).
     *
     * @var ?self
     */
    protected static ?self $instance = null;

    /**
     * Get the singleton instance of the container.
     *
     * If the instance does not exist, it will be created.
     *
     * @return self
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new static;
        }

        return self::$instance;
    }

    /**
     * Bind a service to the container.
     *
     * @param string $key The service name or class name (could be an interface).
     * @param mixed $value The service definition or closure.
     * @param bool $singleton Whether to store the service as a singleton.
     * @return $this
     */
    public function bind(string $key, mixed $value, bool $singleton = false): self
    {
        // Wrap value into a closure if it's a class name
        if (is_string($value) && class_exists($value)) {
            $value = fn() => new $value();
        }

        $this->services[$key] = $value;

        if ($singleton) {
            $this->instances[$key] = null;
        }

        return $this;
    }

    /**
     * Bind a service as a singleton.
     *
     * @param string $key The service name or class name.
     * @param mixed $callback The service definition or closure.
     * @return $this
     */
    public function singleton(string $key, mixed $callback): self
    {
        return $this->bind($key, $callback, true);
    }

    /**
     * Retrieve a service from the container.
     *
     * @param string $service The service name or class name.
     * @return mixed
     */
    public function get(string $service): mixed
    {
        if ($this->has($service)) {
            return $this->fetchBoundService($service);
        }
        return $this->build($service);
    }

    /**
     * Check if the container has a binding for the given service.
     *
     * @param string $key The service name or class name.
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->services);
    }

    /**
     * Build a new instance of the given service.
     *
     * This will resolve all dependencies using reflection and instantiate the service.
     *
     * @param string $service The service name or class name.
     * @return mixed
     * @throws CouldNotResolveClassException If the class cannot be resolved.
     * @throws CouldNotResolveAbstractionException If the service is an interface or abstract class.
     */
    protected function build(string $service): mixed
    {
        try {
            $reflector = new ReflectionClass($service);
        } catch (\ReflectionException $e) {
            throw new CouldNotResolveClassException("Could not resolve class [$service]");
        }

        if (!$reflector->isInstantiable()) {
            throw new CouldNotResolveAbstractionException(sprintf('Could not resolve interface or abstract class [%s]', $service));
        }

        $parameters = $reflector->getConstructor()?->getParameters() ?? [];
        $resolveDependencies = array_map(
            fn(ReflectionParameter $parameter) => $this->resolveParameter($parameter),
            $parameters
        );

        return $reflector->newInstanceArgs($resolveDependencies);
    }

    /**
     * Resolve a parameter's dependency.
     *
     * @param ReflectionParameter $parameter The reflection parameter.
     * @return mixed
     */
    protected function resolveParameter(ReflectionParameter $parameter): mixed
    {
        $class = $parameter->getType()?->getName();

        // If class is an interface or class, resolve it from the container
        if ($class && $this->has($class)) {
            return $this->get($class);
        }

        // If it's a class that exists, build it
        if ($class && class_exists($class)) {
            return $this->build($class);
        }

        return null;
    }

    /**
     * Fetch a bound service from the container.
     *
     * @param string $service The service name or class name.
     * @return mixed
     */
    protected function fetchBoundService(string $service): mixed
    {
        if (isset($this->instances[$service]) && $this->instances[$service] !== null) {
            return $this->instances[$service];
        }

        $serviceResolver = $this->services[$service];
        $resolvedService = $serviceResolver instanceof Closure
            ? $serviceResolver($this)
            : $serviceResolver;

        if (isset($this->instances[$service])) {
            return $this->instances[$service] = $resolvedService;
        }

        return $resolvedService;
    }
}
