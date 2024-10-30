<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

class Cpts
{
    const NAME = 'content-promoter';
    
    /**
     * Add Content Promoter CPT
     * 
     * @return  void
     */
    public function init()
    {
        $labels = [
            'name'                => __('Content Promoter', 'content-promoter'),
            'singular_name'       => __('Content Promoter Item', 'content-promoter'),
            'menu_name'           => __('Content Promoter', 'content-promoter'),
            'parent_item_colon'   => __('Parent Content Promoter Item', 'content-promoter'),
            'all_items'           => __('All Content Promoter Items', 'content-promoter'),
            'view_item'           => __('View Content Promoter Item', 'content-promoter'),
            'add_new_item'        => __('Add New Content Promoter Item', 'content-promoter'),
            'add_new'             => __('Add New', 'content-promoter'),
            'edit_item'           => __('Edit Content Promoter Item', 'content-promoter'),
            'update_item'         => __('Update Content Promoter Item', 'content-promoter'),
            'search_items'        => __('Search Content Promoter Item', 'content-promoter'),
            'not_found'           => __('Not Found', 'content-promoter'),
            'not_found_in_trash'  => __('Not found in Trash', 'content-promoter')
        ];

        $args = [
            'label'               => __('Content Promoter', 'content-promoter'),
            'labels'              => $labels,
            'supports'            => ['title', 'author', 'revisions'],
            'public'              => true,
            'hierarchical'        => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => false,
            'has_archive'         => false,
            'can_export'          => true,
            'exclude_from_search' => true,
            'yarpp_support'       => true,
            'publicly_queryable'  => true,
            'capability_type'     => 'post'
        ];

        register_post_type('content-promoter', $args);
    }

}