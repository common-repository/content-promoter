<?php
namespace ContentPromoter\Core\Helpers;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

use ContentPromoter\Core\Libs\Registry;

class WPHelper {
	/**
	 * JOIN clause used by WPML to fetch related items only
	 * 
	 * @var  String
	 */
	const join_clause = " AND (iclt.element_type = 'post_page' || iclt.element_type = 'post_post' || iclt.element_type = 'post_nav_menu_item')";
    
	/**
	 * Parses given data to a key,value array
	 * 
	 * @param   array  $items
	 * @param   string  $type
	 * 
	 * @return  array
	 */
	public static function parseData($items, $type = '')
	{
		$data = [];

		foreach ($items as $key => $item)
		{
            $item = (object) $item;
            
			$data[] = [
				'id' => $item->id,
				'label' => $item->title,
				'lang' => isset($item->lang) ? $item->lang : ''
			];
		}
		
		return $data;
    }

    /**
     * Get helper class name
     * 
     * @param   string  $type
     * 
     * @return  string
     */
    public static function getHelperClassName($type)
    {
        switch ($type) {
            case 'post':
            case 'page':
            case 'wpforms':
            case 'woocommerce':
                $type = 'GeneralPosts';
                break;
            case 'menu_item':
                $type = 'Menu';
                break;
            case 'cpt':
                $type = 'Cpts';
                break;
        }
        
        return ucfirst($type);
    }
    
    /**
     * Returns the Post Type that we use to search in the wp_posts table
     * 
     * @param   string   $type
     * 
     * @return  string
     */
    public static function parsePostType($type)
    {
        switch ($type) {
            case 'woocommerce':
                $type = 'product';
                break;
        }
        
        return $type;
    }

    /**
     * Returns WPML data needed to get the locale for each post
     * 
     * @param   string  $item
     * @param   string  $join_clause
     * 
     * @return  array
     */
    public static function getWPMLQueryData($item = 'p.ID', $join_clause = self::join_clause)
    {
		if (!class_exists('SitePress'))
		{
            return [];
        }

        global $wpdb;

        $locale = get_locale();
        $lang_explode = explode('_', $locale);

        $select = ',iclt.language_code as lang';
        $join = "LEFT JOIN {$wpdb->prefix}icl_translations as iclt ON iclt.element_id = {$item} {$join_clause}";

        return [
            'select' => $select,
            'join' => $join,
            'lang_code' => $lang_explode[0]
        ];
    }

    /**
     * Retives the WPML Flag image from country code
     * 
     * @param   string   $code
     * 
     * @return  string
     */
    public static function getWPMLFlagUrlFromCode($code)
    {
        if (!class_exists('SitePress'))
        {
            return '';
        }

        if (empty($code))
        {
            return '';
        }
        
        global $wpdb;
        $wpml_flags = new \WPML_Flags( $wpdb, new \icl_cache( 'flags', true ), new \WP_Filesystem_Direct( null ) );

        return '<img src="' . $wpml_flags->get_flag_url($code) . '" style="width:18px;height:12px;" alt="wpml flag image" />';
    }

    /**
     * Check if table exists
     * 
     * @param   string  $table_name,
     * 
     * @return  boolean
     */
    public static function tableExists($table_name)
    {
        if (empty($table_name))
        {
            return false;
        }
        
        global $wpdb;
        $table_name = $wpdb->base_prefix . $table_name;
        $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );
        
        if ( ! $wpdb->get_var( $query ) == $table_name ) {
            return false;
        }

        return true;
    }

    /**
     * Check if plugin is active
     * 
     * @param   array  $payload
     * 
     * @return  boolean
     */
    public static function isPluginActive($payload)
    {
        if (!$payload instanceof Registry)
        {
            $payload = new Registry($payload);
        }

		$check_plugin_table_exists = $payload->get('check_plugin_table_exists', false);

		if ($check_plugin_table_exists)
		{
			$table = $payload->get('table', '');

			if (empty($table))
			{
				return false;
			}

			return \ContentPromoter\Core\Helpers\WPHelper::tableExists($table);
		}
		else
		{
			$plugin_name = $payload->get('plugin_name', '');
			$plugin_folders = $payload->get('plugin_folders', '');
			
			if (empty($plugin_name) || empty($plugin_folders))
			{
				return false;
            }
            
            if (!is_admin())
            {
                return true;
            }
			
			foreach ($plugin_folders as $folder)
			{
				if (\is_plugin_active($folder . '/' . $plugin_name . '.php'))
				{
					return true;
				}
			}

			return false;
		}
    }

    /**
     * Return URL with preview GET attribute attached used to preview promoting content item.
     *
     * @param   int     $cp_id
     * @param   bool    $new_window
     *
     * @return  string
     */
    public static function ctpr_get_item_preview_url($cp_id, $new_window = false)
    {
        $url = add_query_arg(
            [
                'ctpr_item_preview' => absint( $cp_id ),
            ],
            home_url()
        );

        if ($new_window)
        {
            $url = add_query_arg(
                [
                    'new_window' => 1,
                ],
                $url
            );
        }

        return $url;
    }
}