<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class Menu {
	/**
	 * Add Menu Page
	 * 
	 * @return  void
	 */
	public function init()
	{
		add_menu_page(
			contentpromoter()->_('CP_PLUGIN_NAME'),
			contentpromoter()->_('CP_PLUGIN_NAME'),
			'manage_options',
			'content-promoter',
			[contentpromoter()->container['Dashboard'], 'render'],
			'dashicons-megaphone',
			80
		);

		add_submenu_page(
			'content-promoter',
			contentpromoter()->_('CP_DASHBOARD'),
			contentpromoter()->_('CP_DASHBOARD'),
			'manage_options',
			'content-promoter'
		);
		
		add_submenu_page(
			'content-promoter',
			contentpromoter()->_('CP_NEW_ITEM'),
			contentpromoter()->_('CP_NEW_ITEM'),
			'manage_options',
			'post-new.php?post_type=content-promoter',
			null
		);
		
		add_submenu_page(
			'content-promoter',
			contentpromoter()->_('CP_ITEMS'),
			contentpromoter()->_('CP_ITEMS'),
			'manage_options',
			'edit.php?post_type=content-promoter',
			null
		);
		
		add_submenu_page(
			'content-promoter',
			contentpromoter()->_('CP_SETTINGS'),
			contentpromoter()->_('CP_SETTINGS'),
			'manage_options',
			'content-promoter-settings',
			[contentpromoter()->container['Settings'], 'render']
		);

		add_submenu_page(
			'content-promoter',
			contentpromoter()->_('CP_GETTING_STARTED'),
			contentpromoter()->_('CP_GETTING_STARTED'),
			'manage_options',
			'content-promoter-getting-started',
			[contentpromoter()->container['GettingStarted'], 'render']
		);

		global $submenu;
		$submenu['content-promoter'][] = [ contentpromoter()->_('CP_DOCUMENTATION'), 'manage_options', CTPR_DOC_URL ];
		$submenu['content-promoter'][] = [ contentpromoter()->_('CP_SUPPORT'), 'manage_options', CTPR_SUPPORT_URL ];
		
		$submenu['content-promoter'][] = [ '<span class="ctpr-yellow-color">' . contentpromoter()->_('CP_UPGRADE_TO_PRO') . '</span>', 'manage_options', CTPR_UPGRADE_URL ];

		// plugin's page extra links
		add_action('plugin_action_links_' . plugin_basename(CTPR_FILE), [$this, 'plugin_action_links']);
		
	}

	
	public function plugin_action_links($links) {
		$links = array_merge( $links, [
			'<a href="' . CTPR_UPGRADE_URL . '" class="ctpr-red-color ctpr-bold">' . contentpromoter()->_('CP_GO_PRO') . '</a>'
		 ] );
			
		return $links;
	}
	
}