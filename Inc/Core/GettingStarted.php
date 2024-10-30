<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

class GettingStarted {
	/**
	 * Hidden welcome page slug.
	 *
     * @var  string
	 */
	const SLUG = 'content-promoter-getting-started';

    public function init()
    {
		$this->redirect();
    }
    
    public function render()
    {
        contentpromoter()->renderer->render('getting_started/tmpl');
    }

	/**
	 * Welcome screen redirect.
	 *
	 * This function checks if a new install or update has just occurred. If so,
	 * then we redirect the user to the appropriate page.
	 *
	 * @since 1.0.0
	 */
    public function redirect()
    {
		// Check if we should consider redirection.
		if ( ! get_transient( 'ctpr_activation_redirect' ) ) {
			return;
		}

		// If we are redirecting, clear the transient so it only happens once.
		delete_transient( 'ctpr_activation_redirect' );

		// Check option to disable welcome redirect.
		// if ( get_option( 'ctpr_activation_redirect', false ) ) {
		// 	return;
		// }

		// Only do this for single site installs.
		if ( isset( $_GET['activate-multi'] ) || is_network_admin() ) { // WPCS: CSRF ok.
			return;
		}

        // Initial install.
        wp_safe_redirect( admin_url( 'admin.php?page=' . self::SLUG ) );
        exit;
	}
}