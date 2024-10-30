<?php
namespace ContentPromoter\Core\Libs\Vendors;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

/**
 * Abstract Format for Registry
 */
abstract class AbstractRegistryFormat implements FormatInterface
{
	/**
	 * @var    AbstractRegistryFormat[]  Format instances container.
	 */
	protected static $instances = array();

	/**
	 * Returns a reference to a Format object, only creating it
	 * if it doesn't already exist.
	 *
	 * @param   string  $type     The format to load
	 * @param   array   $options  Additional options to configure the object
	 *
	 * @return  AbstractRegistryFormat  Registry format handler
	 *
	 * @throws  \InvalidArgumentException
	 */
	public static function getInstance($type, array $options = array())
	{
		return \ContentPromoter\Core\Libs\Vendors\Factory::getFormat($type, $options);
	}
}
