<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

use ContentPromoter\Core\Exceptions\DependencyNotRegisteredException;

class BaseContainer implements Interfaces\ContainerInterface
{
	/**
	 * @var array
	 */
	protected $instances = [];

	/**
	 * @param      $abstract
	 * @param null $concrete
	 */
	public function set($abstract, $concrete = NULL)
	{
		if ($concrete === NULL) {
			$concrete = $abstract;
		}

		$this->instances[$abstract] = $concrete;
	}

	/**
	 * @param       $abstract
	 * @param array $parameters
	 *
	 * @return mixed|null|object
	 * @throws Exception
	 */
	public function get($dependency)
	{
        if (!$this->has($dependency)) {
            throw new DependencyNotRegisteredException($dependency);
        }
		
        $entry = $this->instances[$dependency];
		
        if ($entry instanceof Closure) { // We use closures in order to enable factory composition
            return $entry($this);
		}

		if (is_object($entry))
		{
			return $entry($this);
		}
		
        return $this->concretize($entry);
    }
    
    /**
	 * @param       $abstract
     * 
	 * @return mixed|null|object
     */
    public function has($abstract)
    {
        return isset($this->instances[$abstract]);
    }

	/**
	 * resolve single
	 *
	 * @param $concrete
	 * @param $parameters
	 *
	 * @return mixed|object
	 * @throws Exception
	 */
	public function concretize(String $entry)
	{
		$resolved = [];
        $reflector = $this->getReflector($entry);
        $constructor = null;
        $parameters = [];

        if ($reflector->isInstantiable())
        {
            $constructor = $reflector->getConstructor();
            if (!is_null($constructor))
            {
                $parameters = $constructor->getParameters();
            }
        }
        else
        {
            throw new DependencyIsNotInstantiableException($className);
        }

        if (is_null($constructor) || empty($parameters))
        {
            return $reflector->newInstance(); // return new instance from class
        }

        foreach ($parameters as $parameter)
        {
            $resolved[] = $this->resolveParameter($parameter);
        }

        return $reflector->newInstanceArgs($resolved); // return new instance with dependencies resolved
	}

	/**
	 * Get class reflector
	 */
    private function getReflector(String $entry)
    {
        $className = null;
        
        if (is_object($entry))
        {
            $className = get_class($entry);
        }
        elseif (is_string($entry))
        {
            $className = $entry;

            if (!class_exists($className))
            {
                throw new \InvalidArgumentException(sprintf(
                    'Unable to build reflector as class "%s" does not exist',
                    $className
                ));
            }
        }
        else
        {
            throw new \InvalidArgumentException('Expected either class name as string or an object to build a ReflectionClass');
        }

        if (!isset($this->instances[$className]))
        {
            $this->instances[$className] = new \ReflectionClass($className);
        }

        return $this->instances[$className];
	}
	
	/**
	 * get all dependencies resolved
	 *
	 * @param $parameters
	 *
	 * @return array
	 * @throws Exception
	 */
	public function resolveParameter(\ReflectionParameter $parameter)
    {
        // The parameter is a class
        if ($parameter->getClass() !== null)
        {
            $typeName = $parameter->getType()->__toString();
            if (!$this->isUserDefined($parameter))
            { // The parameter is not user defined

                $this->set($typeName); // Register it
            }
            return $this->get($typeName); // Instantiate it
        }
        // The parameter is a built-in primitive type
        else
        {
            if ($parameter->isDefaultValueAvailable())
            { // Check if default value for a parameter is available

                return $parameter->getDefaultValue(); // Get default value of parameter
            }
            else
            {
                throw new DependencyHasNoDefaultValueException($parameter->name);
            }
        }
    }
}