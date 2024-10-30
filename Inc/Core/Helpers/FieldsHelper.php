<?php
namespace ContentPromoter\Core\Helpers;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class FieldsHelper
{
	/**
	 * Searches for a name in an array and returns its value or a default value.
	 * Can find value of keys : [name][name2][name3] in array
	 * 
	 * @param   string  $name
	 * @param   string  $default
	 * @param   array   $values
	 * 
	 * @return  string
	 */
	public static function findFieldValueInArray($name, $default, $values)
	{
		if (!is_string($name))
		{
			return '';
		}

		if (!is_array($values))
		{
			return '';
		}

		// field name: [name][name2][name3]
		if (substr_count($name, '[') > 1)
		{
			// split name
			$splited_name = explode('[', $name);
			unset($splited_name[0]);

			// find value
			$tmp_value = $values;

			foreach ($splited_name as $key => $_name)
			{
				$_name = str_replace(']', '', $_name);
				if (!isset($tmp_value[$_name]))
				{
					// key does not exist, return default
					$tmp_value = $default;
					break;
				}
				else
				{
					if (empty($tmp_value[$_name]))
					{
						$tmp_value = $default;
						break;
					}
				}

				$tmp_value = $tmp_value[$_name];
			}

			// return value
			return $tmp_value;
		}
		else
		{
			// field name: [name]
			$name = str_replace(['[', ']'], '', $name);
			
			return isset($values[$name]) && !empty($values[$name]) ? $values[$name] : '';
		}
    }
}