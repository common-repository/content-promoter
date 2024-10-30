<?php
namespace ContentPromoter\Core\Helpers;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class Status {
	/**
	 * Returns the version
	 * 
	 * @return  string
	 */
	public static function getVersion()
	{
		$xml = [];

		if (function_exists('simplexml_load_file'))
		{
			$xml = simplexml_load_file(realpath(dirname(__FILE__) . '/../../../plugin.xml'));
		}

		$version = isset($xml->version) ? $xml->version : '1.0.0';
		
		return (string) $version;
	}
	
	/**
	 * The Status of the plugin
	 * 
	 * @return  string
	 */
	public static function getStatus()
	{
		return (self::isFree()) ? contentpromoter()->_('CP_FREE') : contentpromoter()->_('CP_PRO');
	}

	/**
	 * Returns whether we have Free version or not
	 * 
	 * @return  boolean
	 */
	public static function isFree()
	{
		$status = 0;
		if (defined('CTPR_STATUS'))
		{
			$status = CTPR_STATUS;
		}
		return $status == 0 ? true : false;
	}

	/**
	 * Returns whether we have Pro version or not
	 * 
	 * @return  boolean
	 */
	public static function isPro()
	{
		return !self::isFree();
	}

	
}