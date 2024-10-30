<?php
namespace ContentPromoter\Core\Libs\Vendors;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

/**
 * Interface defining a format object
 */
interface FormatInterface
{
	/**
	 * Converts an object into a formatted string.
	 *
	 * @param   object  $object   Data Source Object.
	 * @param   array   $options  An array of options for the formatter.
	 *
	 * @return  string  Formatted string.
	 */
	public function objectToString($object, $options = null);

	/**
	 * Converts a formatted string into an object.
	 *
	 * @param   string  $data     Formatted string
	 * @param   array   $options  An array of options for the formatter.
	 *
	 * @return  object  Data Object
	 */
	public function stringToObject($data, array $options = array());
}
