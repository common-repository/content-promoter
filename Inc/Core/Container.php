<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

class Container extends BaseContainer implements \ArrayAccess
{
	/**
     * Tells if the offset in the container is set to anything
     *
     * @param string $offset
     * @return void
     */
    public function offsetExists ( $offset )
    {
        return $this->has($offset);
	}
	
    /**
     * Sets the dependency at the given offset.
     *
     * @param string $offset
     * @return mixed the dependency
     */
    public function offsetGet ( $offset)
    {
        return $this->get($offset);
	}
	
    /**
     * Sets the dependency at the given offset.
     *
     * @param string $offset
     * @param mixed $dependency
     * @return void
     */
    public function offsetSet ( $offset , $dependency )
    {
        if (is_null($offset))
        {
            $this->set($dependency);
        }
        else
        {
            $this->set($offset, $dependency);
        }
	}
	
	/**
	 * Removes dependency from container
	*
	* @param string $offset
	* @return void
	*/
    public function offsetUnset ( $offset )
    {
		$this->unset($offset);
	}
}