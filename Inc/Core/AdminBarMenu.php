<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class AdminBarMenu
{
	public function init()
	{
		// add media to both front and back end
		add_action( 'wp_enqueue_scripts', [ $this, 'addMedia' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'addMedia' ] );

		// add menu item on top admin bar
		add_action( 'admin_bar_menu', [ $this, 'register' ], 999 );
	}

	/**
	 * Enqueue styles.
	 * 
	 * @return  void
	 */
	public function addMedia()
	{
		if (!$this->canRun())
		{
			return;
		}

		wp_enqueue_style(
			'content-promoter-admin-bar',
			CTPR_ADMIN_MEDIA_URL . 'css/admin-bar.css',
			[],
			CTPR_VERSION
		);
	}

	/**
	 * Check if current user has access to see admin bar menu.
	 *
	 * @return  boolean
	 */
	public function canRun()
	{
		if (is_user_logged_in() &&
			current_user_can('administrator') &&
			!get_option('hide-admin-bar', false))
		{
			return true;
		}

		return false;
	}

	/**
	 * Register and render admin menu bar items.
	 *
	 * @param   $wp_admin_bar  WordPress Admin Bar object.
	 * 
	 * @return  void
	 */
	public function register($wp_admin_bar)
	{
		if (!$this->canRun())
		{
			return;
		}

		$items = [
			'main_menu',
			'all_items_menu',
			'add_new_menu',
			'support_menu',
			
			'upgrade_to_pro_menu',
			
		];

		foreach ($items as $item)
		{
			$this->{$item}($wp_admin_bar);
		}
	}

	/**
	 * Render Content Promoter plugin main page
	 *
	 * @param   object  $wp_admin_bar  WordPress Admin Bar object.
	 * 
	 * @return  void
	 */
	public function main_menu($wp_admin_bar)
	{
		$logo = '<span class="ab-icon"></span>';
		
		$wp_admin_bar->add_menu(
			[
				'id'    => 'content-promoter-menu',
				'title' => $logo . contentpromoter()->_('CP_PLUGIN_NAME'),
				'href'  => admin_url( 'admin.php?page=content-promoter' ),
			]
		);
	}

	/**
	 * Render Content Promoter Items page
	 *
	 * @param   object  $wp_admin_bar  WordPress Admin Bar object.
	 * 
	 * @return  void
	 */
	public function all_items_menu($wp_admin_bar)
	{
		$wp_admin_bar->add_menu(
			[
				'parent' => 'content-promoter-menu',
				'id'    => 'content-promoter-menu-all-items',
				'title' => contentpromoter()->_('CP_PROMOTING_ITEMS'),
				'href'  => admin_url( 'edit.php?post_type=content-promoter' ),
			]
		);
	}

	/**
	 * Render Content Promoter New Item page
	 *
	 * @param   object  $wp_admin_bar  WordPress Admin Bar object.
	 * 
	 * @return  void
	 */
	public function add_new_menu($wp_admin_bar)
	{
		$wp_admin_bar->add_menu(
			[
				'parent' => 'content-promoter-menu',
				'id'    => 'content-promoter-menu-new-item',
				'title' => contentpromoter()->_('CP_NEW_ITEM'),
				'href'  => admin_url( 'post-new.php?post_type=content-promoter' ),
			]
		);
	}

	/**
	 * Render Content Promoter Support Page
	 *
	 * @param   object  $wp_admin_bar  WordPress Admin Bar object.
	 * 
	 * @return  void
	 */
	public function support_menu($wp_admin_bar)
	{
		$wp_admin_bar->add_menu(
			[
				'parent' => 'content-promoter-menu',
				'id'    => 'content-promoter-menu-support',
				'title' => contentpromoter()->_('CP_SUPPORT'),
				'href'  => CTPR_SUPPORT_URL
			]
		);
	}

	
	/**
	 * Render Content Promoter Upgrade to Pro Page
	 *
	 * @param   object  $wp_admin_bar  WordPress Admin Bar object.
	 * 
	 * @return  void
	 */
	public function upgrade_to_pro_menu($wp_admin_bar)
	{
		$wp_admin_bar->add_menu(
			[
				'parent' => 'content-promoter-menu',
				'id'    => 'content-promoter-menu-upgrade-to-pro',
				'title' => contentpromoter()->_('CP_UPGRADE_TO_PRO'),
				'href'  => CTPR_UPGRADE_URL,
				'meta'  => [
					'class' => 'fb-yellow-link'
				]
			]
		);
	}
	
}