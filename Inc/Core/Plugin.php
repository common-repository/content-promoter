<?php
namespace ContentPromoter\Core {

	if (!defined('ABSPATH'))
	{
		exit; // Exit if accessed directly.
	}

	/**
	 * This class is responsible for initializing Content Promoter.
	 * 
	 * It registers all required components needed for the plugin to run.
	 */
	final class Plugin
	{
		/**
		 * The plugin name
		 * 
		 * @var  String
		 */
		public $plugin_name = 'Content Promoter';

		/**
		 * The plugin slug
		 * 
		 * @var  String
		 */
		public $plugin_slug = 'content-promoter';
		
		/**
		 * Holds the plugin instance
		 *
		 * @var Plugin $instance
		 */
		public static $instance = null;

		

		/**
		 * The container
		 * 
		 * @var  Container
		 */
		public $container;

		private function __construct()
		{
			$this->container = new Container();

			register_activation_hook(CTPR_FILE, [$this, 'activation']);
			add_action( 'activated_plugin', [$this, 'set_rate_reminder'] );

			// loads text domain
			add_action('plugins_loaded', [$this, 'loadTextdomain']);

			// run admin init
			add_action('admin_init', [$this, 'admin_init']);

			// run init
			add_action('admin_menu', [$this, 'admin_menu']);
			
			// run init
			add_action('init', [$this, 'init']);
		}

		/**
		 * Set rate reminder transient on plugin activation.
		 *
		 * @return  void
		 */
		public function set_rate_reminder() {
			if( ! get_transient( 'ctpr_rate_reminder_deleted' ) && ! get_transient( 'ctpr_rate_reminder' ) ) {
				$date = new \DateTime('2020-03-10');
				set_transient( 'ctpr_rate_reminder', $date->format( 'Y-m-d' ) );
			}
		}

		/**
		 * On plugin activate
		 * 
		 * @return  void
		 */
		public function activation()
		{
			if (false === get_option('ctpr_settings_page_data'))
			{
				$this->container['Settings'] = function($c = null) { return new Settings; };

				update_option('ctpr_settings_page_data', $this->container['Settings']->getDefaultSettings());
			}

			// Add transient to trigger redirect to the Welcome screen.
			set_transient( 'ctpr_activation_redirect', true, 30 );
		}

		/**
		 * Ensures only one instance of the plugin class is loaded or can be loaded
		 *
		 * @return  Plugin An instance of the class.
		 */
		public static function instance()
		{
			if (is_null(self::$instance))
			{
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Loads the textdomain
		 * 
		 * @return  void
		 */
		public function loadTextdomain()
		{
			load_plugin_textdomain( 'content-promoter', false, CTPR_PLUGIN_DIR . 'languages/' );
		}

		/**
		 * Admin init
		 * 
		 * @return  void
		 */
		public function admin_init()
		{
			$this->container['UpdateNotice'] = function($c = null) { return new UpdateNotice; };
			$this->container['UpdateNotice']->init();
			$this->container['Metabox'] = function($c = null) { return new Metabox; };
			$this->container['Admin_Ajax'] = function($c = null) { return new Admin_Ajax; };
			$this->container['Wizard'] = function($c = null) { return new Wizard; };
			$this->container['PublishSettings'] = function($c = null) { return new PublishSettings; };

			$this->container['Cpts'] = function($c = null) { return new Cpts; };
			$this->container['Cpts']->init();
			
			$this->container['Admin'] = function ($c = null) { return new Admin($c['Metabox'], $c['Admin_Ajax']); };
			$this->container['Admin']->init();
		}

		/**
		 * Initializes Content Promoter Plugin with the required components.
		 * Initializes all components used by front-end and back-end.
		 * 
		 * @return  void
		 */
		public function init()
		{
			$this->container['Item'] = function ($c = null) { return new Item; };
			$this->container['Renderer'] = function ($c = null) { return new Renderer; };
			$this->container['Translations'] = function ($c = null) { return new Translations; };
			
			$this->container['AdminBarMenu'] = function ($c = null) { return new AdminBarMenu; };
			$this->container['AdminBarMenu']->init();

			// Gutenberg block
			$this->container['Block'] = function ($c = null) { return new Block; };
			$this->container['Block']->init();

			// TinyMCE Button
			$this->container['TinyMCE_Button'] = function ($c = null) { return new TinyMCE_Button; };
			$this->container['TinyMCE_Button']->init();
			
			$this->renderer = $this->container['Renderer'];

			if (!is_admin())
			{
				$this->container['PromotingContents'] = function ($c = null) { return new PromotingContents; };
				$this->container['PromotingContents']->init();

				$this->container['Previewer'] = function ($c = null) { return new Previewer; };
				$this->container['Previewer']->init();
			}
		}

		/**
		 * Admin Menu
		 * 
		 * @return  void
		 */
		public function admin_menu()
		{
			$this->container['GettingStarted'] = function($c = null) { return new GettingStarted; };
			$this->container['GettingStarted']->init();
			
			$this->container['Settings'] = function($c = null) { return new Settings; };
			$this->container['Dashboard'] = function($c = null) { return new Dashboard; };
			
			$this->container['Menu'] = function($c = null) { return new Menu; };
			$this->container['Menu']->init();
		}

		/**
		 * Returns translation string
		 */
		public function _($lang)
		{
			return $this->container['Translations']->get($lang);
		}
	}
}

namespace {
	/**
	 * The function which returns the one Content Promoter instance.
	 * 
	 * @return  Plugin
	 */
	function contentpromoter() {
		return ContentPromoter\Core\Plugin::instance();
	}
}