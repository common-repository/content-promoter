<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

class Admin
{
	public $metabox;
	
	public $admin_ajax;

	public function __construct(Metabox $metabox, Admin_Ajax $admin_ajax)
	{
        // metabox
		$this->metabox = $metabox;
		
		// admin ajax
		$this->admin_ajax = $admin_ajax;
	}

	/**
	 * On admin init
	 * 
	 * @return  void
	 */
	public function init()
	{
		if (!$this->canRun())
		{
			return false;
		}

		$this->setupAjax();
		
		add_action( 'admin_enqueue_scripts', function( $hook ) {
			$this->addMedia();
		});

		new ReviewReminder();
		
		
		$this->addProModal();
		
	}

	/**
	 * Whether we can run the admin page
	 * 
	 * @return  boolean
	 */
	public function canRun()
	{
		global $pagenow;

		$screen = get_current_screen();

		$current_plugin_page = $this->getPluginPage();

		$plugin_menu_items = [
			'content-promoter',
			'content-promoter-settings',
			'content-promoter-getting-started'
		];

		$run = false;

		if (in_array($current_plugin_page, $plugin_menu_items))
		{
			$run = true;
		}

		if ($pagenow == 'post.php' && isset($_GET['post']) && 'content-promoter' == get_post_type($_GET['post']))
		{
			$run = true;
		}

		if ($pagenow == 'post-new.php' && isset($_GET['post_type']) && 'content-promoter' == $_GET['post_type'])
		{
			$run = true;
		}

		if (wp_doing_ajax())
		{
			$run = true;
		}

		return $run;
	}

	/**
	 * Returns the current plugin name
	 * 
	 * @return  string
	 */
	public function getPluginPage()
	{
		return isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '';
	}

	
	/**
	 * Adds pro modal to the page
	 * 
	 * @return  void
	 */
	private function addProModal()
	{
		new Pro\Modal();
	}
	

	/**
	 * Setup ajax requestes
	 */
	private function setupAjax()
	{
		// promoting item type change
		add_action('wp_ajax_ctpr_type_change', [$this->admin_ajax, 'setupChangePromotingItemType']);
		
		// get wp item selector data
        add_action('wp_ajax_ctpr_get_wp_item_selector_data', [$this->admin_ajax, 'getWPItemSelectorData']);
	}

	/**
	 * Adds media 
	 * 
	 * @return  void
	 */
	private function addMedia()
	{
		$this->addScripts();
		$this->addStyles();
	}

	/**
	 * Adds scripts to DOM
	 * 
	 * @return  void
	 */
	private function addScripts()
	{
		// media
		wp_enqueue_media();

		// wp editor
		wp_enqueue_editor();

		// color picker
        wp_enqueue_script('wp-color-picker');

		// used by WordPress color picker  ( wpColorPicker() )
		wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n',
			[
				'clear'            => contentpromoter()->_('CP_RESET'),
				'clearAriaLabel'   => contentpromoter()->_('CP_RESET_COLOR'),
				'defaultString'    => contentpromoter()->_('CP_DEFAULT'),
				'defaultAriaLabel' => contentpromoter()->_('CP_SELECT_DEFAULT_COLOR'),
				'pick'             => contentpromoter()->_('CP_SELECT_COLOR'),
				'defaultLabel'     => contentpromoter()->_('CP_COLOR_VALUE'),
			]
		);
		
		// load color picker from wordpress
		// as well as our own for transparency support
		wp_register_script(
			'ctpr-colorpicker-admin-js',
			CTPR_ADMIN_MEDIA_URL . 'js/wp-color-picker-alpha.min.js',
			['wp-color-picker'],
			CTPR_VERSION,
			false
		);
		wp_enqueue_script( 'ctpr-colorpicker-admin-js' );
		
		// Load Sortable
		wp_register_script(
			'ctpr-sortable-lib',
			CTPR_ADMIN_MEDIA_URL . 'js/Sortable.min.js',
			[],
			CTPR_VERSION,
			false
		);
		wp_enqueue_script( 'ctpr-sortable-lib' );

		// load main js
		wp_register_script(
			'ctpr-admin-js',
			CTPR_ADMIN_MEDIA_URL . 'js/ctpr-admin.js',
			[],
			CTPR_VERSION,
			false
		);
		wp_enqueue_script( 'ctpr-admin-js' );
		
		// load review handler js
		wp_register_script(
			'ctpr-review-handler-js',
			CTPR_ADMIN_MEDIA_URL . 'js/ctpr-review-handler.js',
			[],
			CTPR_VERSION,
			false
		);
		wp_enqueue_script( 'ctpr-review-handler-js' );

		$data = array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce'    => wp_create_nonce('ctpr_js_nonce'),
			'site_url' => site_url('/'),
			'SMART_TAG_COPIED_TO_CLIPBOARD' => contentpromoter()->_('CP_SMART_TAG_COPIED_TO_CLIPBOARD'),
			'SAVE' => contentpromoter()->_('CP_SAVE'),
			'SELECTION' => contentpromoter()->_('CP_SELECTION'),
			'PUBLISH_SETTINGS' => contentpromoter()->_('CP_PUBLISH_SETTINGS'),
			'CONFIGURE' => contentpromoter()->_('CP_CONFIGURE'),
		);

		wp_localize_script('ctpr-admin-js', 'ctpr_js_object', $data);
	}

	/**
	 * Adds styles to DOM
	 * 
	 * @return  void
	 */
	private function addStyles()
	{
		// load main css
		wp_register_style(
			'ctpr-admin-css',
			CTPR_ADMIN_MEDIA_URL . 'css/ctpr-admin.css',
			[],
			CTPR_VERSION,
			false
		);
		wp_enqueue_style( 'ctpr-admin-css' );

		// color picker
        wp_enqueue_style('wp-color-picker'); 
	}

}