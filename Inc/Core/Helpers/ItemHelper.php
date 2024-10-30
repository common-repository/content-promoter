<?php
namespace ContentPromoter\Core\Helpers;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class ItemHelper
{
	/**
	 * Parses given item type for a more helpful name in input placeholder
	 * 
	 * @param   string  $item_type
	 * 
	 * @return  array
	 */
	public static function parseItemTypeForPlaceholder($item_type)
	{
        switch ($item_type)
        {
            
            default:
                $item_type = str_replace('_', ' ', $item_type);
                break;
        }
        
        return $item_type;
    }

    /**
     * Get the meta data of the post
     * 
     * @param   int  $id
     * 
     * @return  array
     */
    public static function getMeta($id)
    {
        $meta = get_post_meta($id, \ContentPromoter\Core\Metabox::$prefix, true);

        $meta = is_array($meta) ? $meta : [];
        
        $meta['promoting_content_id'] = $id;

        return $meta;
    }
}