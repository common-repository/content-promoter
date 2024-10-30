<?php
namespace ContentPromoter\Core\Helpers;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class GeneralPostsHelper
{
    /**
	 * Gets posts from the Selected Items
	 * 
     * @param   array   $items
	 * 
	 * @return  array
	 */
	public static function getSelectedSearchItems($items, $post_type)
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
					p.ID as id, p.post_title as title $select
				FROM
					{$wpdb->prefix}posts as p
					$join
				WHERE
					p.post_status = 'publish' AND
					p.post_type = '$post_type' AND
                    p.ID IN (" . implode(',', esc_sql($items)) . ")";
        
        return $wpdb->get_results($sql);
    }

    /**
     * Search posts
     * 
     * @param   string  $query
     * @param   array   $no_ids
     * 
     * @return  array
     */
    public static function searchItems($query, $no_ids = null, $post_type)
    {
        if (empty($query))
        {
            return [];
        }

        $query = trim($query);

		global $wpdb;
		
		$select = '';
		$join = '';
        $where = '';
        
		$args = ['%' . $wpdb->esc_like($query) . '%'];

		// set the language data
		if ($wpmlData = WPHelper::getWPMLQueryData())
		{
			$select = $wpmlData['select'];
			$join = $wpmlData['join'];
        }
        
		if ($no_ids)
		{
			$where = 'AND p.ID NOT IN(' . implode(',', esc_sql($no_ids)) . ')';
		}
        
		$sql = "SELECT DISTINCT
                    p.ID as id, p.post_title as title $select
                FROM
                    {$wpdb->prefix}posts as p
                    $join
                WHERE
                    p.post_status = 'publish' AND
                    p.post_type = '$post_type' AND
                    p.post_title LIKE '%s'
					$where";
					
        return $wpdb->get_results($wpdb->prepare($sql, $args));
	}
	
	/**
	 * Get Posts Data
	 * 
	 * @param   mixed   $ids
	 * @param   string  $post_type
	 * 
	 * @return  array
	 */
	public static function getItemsData($ids, $post_type)
	{
		if (!$ids && !is_array($ids))
		{
			return [];
		}

		if (!$post_type && empty($post_type) && !is_string($post_type))
		{
			return [];
		}

		$data = get_posts([
			'post__in' => $ids,
			'post_type' => $post_type
		]);

		return $data;
	}
}