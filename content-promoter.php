<?php
/**
 * Plugin Name:       Content Promoter
 * Plugin URI:        https://www.feataholic.com/wordpress-plugins/content-promoter
 * Description:       Content Promoter helps you promote content throughout your site by generating new leads.
 * Version:           1.0.0
 * Author:            feataholic.com
 * Author URI:        https://www.feataholic.com/
 * Text Domain:       content-promoter
 * Domain Path:       /languages
 * Requires at least: 5.4
 * Tested up to: 	  5.5.1
 * Requires PHP: 	  7.1.0
 * License: 		  GNU General Public License v2.0+
 * License URI: 	  http://www.gnu.org/licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

// Kick off our autoloader
spl_autoload_register(function ($class) {
	$base = dirname(__FILE__) . '/Inc/Core/';

	$file = str_replace('ContentPromoter\Core\\', $base, $class);
	$file = str_replace('\\', '/', $file) . '.php';
	
	if (file_exists($file))
	{
		require_once $file;
	}
});

/**
 * Site URL
 */
if (!defined( 'CTPR_SITE_URL' )) {
	$url = 'https://feataholic.com/';
	
	define ( 'CTPR_SITE_URL' , $url);
}


// Upgrade URL
if (!defined('CTPR_UPGRADE_URL'))
{
	define('CTPR_UPGRADE_URL', 'https://www.feataholic.com/?edd_action=add_to_cart&download_id=1778&discount=PROUPGRADE30OFF');
}

/**
 * Free Status
 */
if (!defined( 'CTPR_STATUS' )) {
	define ( 'CTPR_STATUS' , 0);
}


/**
 * Get License Version URL
 */
if (!defined( 'CTPR_GET_LICENSE_VERSION_URL' )) {
	define ( 'CTPR_GET_LICENSE_VERSION_URL' , CTPR_SITE_URL . 'updates/?action=get_version&slug=' . rtrim(basename(__FILE__), '.php'));
}



// Documentation URL
if (!defined('CTPR_DOC_URL'))
{
	define('CTPR_DOC_URL', 'https://www.feataholic.com/docs/content-promoter');
}

// Upgrade to Pro Read More URL
if (!defined('CTPR_UPGRADE_READ_MORE_URL'))
{
	define('CTPR_UPGRADE_READ_MORE_URL', 'https://www.feataholic.com/wordpress-plugins/content-promoter/');
}

// Changelog URL
if (!defined('CTPR_CHANGELOG_URL'))
{
	define('CTPR_CHANGELOG_URL', 'https://www.feataholic.com/wordpress-plugins/content-promoter/changelog/');
}

// Support URL
if (!defined('CTPR_SUPPORT_URL'))
{
	define('CTPR_SUPPORT_URL', 'https://www.feataholic.com/contact/');
}

// Review URL
if (!defined('CTPR_REVIEW_URL'))
{
	define('CTPR_REVIEW_URL', 'https://wordpress.org/support/plugin/content-promoter/reviews/#new-post');
}

// Plugin version
if (!defined('CTPR_VERSION'))
{
	define('CTPR_VERSION', ContentPromoter\Core\Helpers\Status::getVersion());
}

// Plugin file
if (!defined('CTPR_FILE'))
{
	define('CTPR_FILE', __FILE__);
}

// Base Plugin Directory
if (!defined('CTPR_PLUGIN_DIR'))
{
	define('CTPR_PLUGIN_DIR', plugin_dir_path(__FILE__));
}

// Layouts Folder Path
if (!defined('CTPR_LAYOUTS_DIR'))
{
	define('CTPR_LAYOUTS_DIR', plugin_dir_path(__FILE__) . 'Inc/Core/Layouts/');
}

// Admin Media Folder URL
if (!defined('CTPR_ADMIN_MEDIA_URL'))
{
	define('CTPR_ADMIN_MEDIA_URL', plugin_dir_url(__FILE__) . 'media/admin/');
}

// Public Media Folder URL
if (!defined('CTPR_PUBLIC_MEDIA_URL'))
{
	define('CTPR_PUBLIC_MEDIA_URL', plugin_dir_url(__FILE__) . 'media/public/');
}

// PHP Minimm Version
if (!defined('CTPR_MINIMUM_PHP_VERSION'))
{
	define('CTPR_MINIMUM_PHP_VERSION', '7.1.0');
}

/**
 * Handles plugin deactivation.
 */
register_deactivation_hook(__FILE__, function() {
	$settings = get_option('ctpr_settings_page_data');
	$keep_data_on_uninstall = isset($settings['keep_data_on_uninstall']) ? (bool) $settings['keep_data_on_uninstall'] : false;

	// remove all data on uninstall
	if (!$keep_data_on_uninstall)
	{
		// de-register post type
		unregister_post_type(\ContentPromoter\Core\Cpts::NAME);

		// remove all custom post types data
		$items = get_posts(['post_type' => \ContentPromoter\Core\Cpts::NAME, 'post_status' => 'any', 'numberposts' => -1, 'fields' => 'ids']);

		if ($items)
		{
			foreach ($items as $item)
			{
				wp_delete_post($item, true);
			}
		}

		// remove options
		delete_option('ctpr_settings_page_data');
	}
});

// Minimum PHP version check
if (!version_compare( PHP_VERSION, CTPR_MINIMUM_PHP_VERSION, '>='))
{
	add_action( 'admin_notices', 'contentpromoter_fail_php_version' );
}
else
{
	require dirname(__FILE__) . '/Inc/Core/Plugin.php';
	contentpromoter();
}

/**
 * Content Promoter admin notice for minimum PHP version.
 *
 * Warning when the site doesn't have the minimum required PHP version.
 *
 * @return void
 */
function contentpromoter_fail_php_version()
{
	$message = sprintf('Content Promoter requires PHP version %s+, please upgrade to the mentioned PHP version in order for Content Promoter to work.', CTPR_MINIMUM_PHP_VERSION);
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}