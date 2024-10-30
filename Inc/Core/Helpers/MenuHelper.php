<?php
namespace ContentPromoter\Core\Helpers;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class MenuHelper
{
	/**
	 * Gets Menu Items from the Selected Items of Publishing Assignments Search field
	 * 
	 * @param   array  $items
	 * 
	 * @return  array
	 */
	public static function getSelectedSearchItems($items)
	{
		if (empty($items))
		{
			return [];
		}

		global $wpdb;
		
		$select = '';
		$join = '';

		// set the language data
		if ($wpmlData = WPHelper::getWPMLQueryData())
		{
			$select = $wpmlData['select'];
			$join = $wpmlData['join'];
		}

		$sql = "SELECT DISTINCT
					pm.post_id as id, p.post_title as title $select
				FROM
					{$wpdb->prefix}posts as p
					LEFT JOIN {$wpdb->prefix}postmeta as pm
						ON pm.meta_value = p.ID
					$join
				WHERE
					pm.meta_key = '_menu_item_object_id' AND
					pm.post_id IN (" . implode(',', esc_sql($items)) . ")";

		return $wpdb->get_results($sql);
    }
    
	/**
	 * Searches the navigation items and returns an array of items
	 * 
	 * @param   String  $name
	 * @param   array  	$no_ids  List of already added items
	 * @param   string 	$post_type
	 * 
	 * @return  array
	 */
	public static function searchItems($name, $no_ids = null, $post_type = '')
	{
		global $wpdb;

		$select = '';
		$where_end = '';
		$join = '';

		$name = trim($name);

		$args = ['%' . $wpdb->esc_like($name) . '%'];

		// filter search results by removing given IDs from results
		if ($no_ids)
		{
			$where_end = ' AND pm.post_id NOT IN (' . implode(',', esc_sql($no_ids)) . ')';
		}

		// set the language data
		if ($wpmlData = WPHelper::getWPMLQueryData())
		{
			$select = $wpmlData['select'];
			$join = $wpmlData['join'];
		}

		$sql = "SELECT DISTINCT
					pm.post_id as id, p.post_title as title $select
				FROM
					{$wpdb->prefix}posts as p
					LEFT JOIN {$wpdb->prefix}postmeta as pm
						ON pm.meta_value = p.ID
					$join
				WHERE
					p.post_title LIKE '%s' AND
					pm.meta_key = '_menu_item_object_id'" . $where_end;

		$data = $wpdb->get_results($wpdb->prepare($sql, $args));

		return $data;
	}

	/**
	 * Get menu items data
	 * 
	 * @param   array  $menu_items
	 * 
	 * @return  array
	 */
	public static function getItemsData($menu_items)
	{
		if (!$menu_items)
		{
			return [];
		}

		if (!is_array($menu_items))
		{
			return [];
		}

		global $wpdb;

		$sql = "SELECT DISTINCT
					pm.meta_value as id,
					p.post_title as title,
					(
						SELECT meta_value
						FROM {$wpdb->prefix}postmeta
						WHERE meta_key = '_menu_item_url' AND
							  post_id = pm.post_id
					) as menu_item_url
				FROM
					{$wpdb->prefix}posts as p
					LEFT JOIN {$wpdb->prefix}postmeta as pm
						ON pm.meta_value = p.ID
				WHERE
					pm.meta_key = '_menu_item_object_id' AND
					pm.post_id IN (" . implode(',', esc_sql($menu_items)) . ")";

		return $wpdb->get_results($sql);
	}
}