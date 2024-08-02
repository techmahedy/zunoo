<?php

namespace Mii;

use Closure;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use Psr\Container\ContainerInterface;
use Mii\Exceptions\CouldNotResolveClassException;
use Mii\Exceptions\CouldNotResolveAbstractionException;

class Container implements ContainerInterface
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
     * The service can be a class name or a closure. If it's a class name,
     * the container will create an instance of the class when needed.
     * 
     * If $singleton is true, the service will be resolved once and stored for future use.
     *
     * @param string $key The service name or class name.
     * @param mixed $value The service definition or closure.
     * @param bool $singleton Whether to store the service as a singleton.
     * @return $this
     */
    public function bind(string $key, mixed $value, bool $singleton = false): self
    {
        if (class_exists($key)) {
            $value = fn () => new $value;
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
     * The service will be resolved once and the same instance will be returned on subsequent requests.
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
     * If the service is bound as a singleton, it will return the stored instance.
     * Otherwise, it will build a new instance.
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
        } catch (ReflectionException) {
            throw new CouldNotResolveClassException("Could not resolve class [$service]");
        }

        if (!$reflector->isInstantiable()) {
            throw new CouldNotResolveAbstractionException(sprintf('Could not resolve interface or abstract class [%s]', $service));
        }

        $parameters = $reflector->getConstructor()?->getParameters() ?? [];
        $resolveDependencies = array_map(
            fn (ReflectionParameter $parameter) => $this->resolveParameter($parameter),
            $parameters
        );

        return $reflector->newInstanceArgs($resolveDependencies);
    }

    /**
     * Resolve a parameter's dependency.
     *
     * This method uses reflection to determine the parameter's type and recursively resolves it.
     *
     * @param ReflectionParameter $parameter The reflection parameter.
     * @return mixed
     */
    protected function resolveParameter(ReflectionParameter $parameter): mixed
    {
        $class = $parameter->getType()?->getName();
        return class_exists($class) ? $this->build($class) : null;
    }

    /**
     * Fetch a bound service from the container.
     *
     * If the service is a singleton, it returns the stored instance.
     * Otherwise, it resolves the service and returns it.
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
