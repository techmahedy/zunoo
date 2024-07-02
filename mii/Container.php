<?php

namespace Mii;

use Closure;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use Mii\Controllers\Controller;
use Psr\Container\ContainerInterface;
use Mii\Exceptions\CouldNotResolveClassException;
use Mii\Exceptions\CouldNotResolveAbstractionException;

class Container extends Controller implements ContainerInterface
{
    /**
     * @var	array $services
     */
    public array $services = [];

    /**
     * @var	array $instances
     */
    protected array $instances = [];

    /**
     * @var	static $instance
     */
    protected static $instance;

    /**
     * getInstance.
     *
     * @access	public static
     * @return	mixed
     */
    public static function getInstance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new static;
        }

        return self::$instance;
    }

    /**
     * bind.
     *
     * @access	public
     * @param	string 	$key      	
     * @param	mixed  	$value    	
     * @param	boolean	$singleton	Default: false
     * @return	$this
     */
    public function bind(string $key, mixed $value, bool $singleton = false): self
    {
        if (class_exists($key)) {
            $value = fn () => new $value;
        }

        $this->services[$key] = $value;

        if ($singleton) {
            return $this->instances[$key] = null;
        }

        return $this;
    }

    /**
     * singleton.
     *
     * @access	public
     * @param	string	$key     	
     * @param	mixed 	$callback	
     * @return	mixed
     */
    public function singleton(string $key, mixed $callback): self
    {
        return $this->bind($key, $callback, true);
    }

    /**
     * get.
     *
     * @access	public
     * @param	string	$service	
     * @return	mixed
     */
    public function get(string $service): mixed
    {
        if ($this->has($service)) {
            return $this->fetchBoundService($service);
        }

        return $this->build($service);
    }

    /**
     * has.
     *
     * @access	public
     * @param	string	$key	
     * @return	mixed
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->services);
    }

    /**
     * build.
     *
     * @access	protected
     * @param	string	$service	
     * @return	mixed
     */
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

    /**
     * fetchBoundService.
     *
     * @access	protected
     * @param	string	$service	
     * @return	mixed
     */
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
