<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

class ReviewReminder
{
	public function __construct()
	{
		if (!$this->canRun())
		{
			return;
		}
		
		// Rate reminder actions.
		add_action( 'admin_notices', [$this, 'show_rate_reminder'] );
		add_action( 'upgrader_process_complete', [$this, 'set_update_rate_reminder'], 1, 2 );
		add_action( 'wp_ajax_ctpr_update_rate_reminder', [$this, 'ctpr_update_rate_reminder'] );
	}

	/**
	 * Ensure the review handler appears only on content promoter pages
	 * 
	 * @return  boolean
	 */
	private function canRun()
	{
		// skip check if we are calling from ajax
		if (wp_doing_ajax())
		{
			return true;
		}
		
		$page = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : false;

		if (!$page)
		{
			return false;
		}

		if (strpos($page, 'content-promoter') !== 0)
		{
			return false;
		}

		return true;
	}

	/**
	 * Set reminder transients on plugins update.
	 *
	 * @return  void
	 */
	function set_update_rate_reminder( $upgrader_object, $options ) {
		if ( $options['action'] == 'update' && $options['type'] == 'plugin' ) {
			if( ! get_transient( 'ctpr_rate_reminder_deleted' ) ) {
				$date = new \DateTime('2020-03-10');
				set_transient( 'ctpr_rate_reminder', $date->format( 'Y-m-d' ) );
			}
		}
	}

	/**
	 * Show reminders.
	 *
	 * @return  void
	 */
	function show_rate_reminder() {
		if( get_transient( 'ctpr_rate_reminder' ) ) {

			$start_date = new \DateTime( get_transient( 'ctpr_rate_reminder' ) );
			$start_date->add( new \DateInterval( 'P7D' ) );

			$current_date = new \DateTime();

			if( $current_date >= $start_date ) {
				$image = sprintf( esc_html( '%1$s' ), '<img src="' . CTPR_ADMIN_MEDIA_URL . 'img/logo.svg' . '" width="100" alt="Content Promoter Plugin Avatar" />' );
				$message = sprintf( esc_html__( contentpromoter()->_('CP_REVIEW_REMINDER_MSG1') ), '<p style="margin-top: 0;">', '<b>', '</b>', '&ndash;', '</br>', '<em>', '</em>', '</p>' );
				$message .= sprintf( esc_html__( contentpromoter()->_('CP_REVIEW_REMINDER_MSG2'), 'content-promoter'  ), '<span>', '<a class="button button-primary ctpr-clear-rate-reminder" href="https://wordpress.org/support/plugin/content-promoter/reviews/?filter=5" target="_blank">', '</a>', '<a class="button ctpr-ask-later" href="#">', '<a class="button ctpr-delete-rate-reminder" href="#">', '</span>' );
				printf( '<div class="notice ctpr-review-reminder"><div class="ctpr-review-author-avatar">%1$s</div><div class="ctpr-review-message">%2$s</div></div>', wp_kses_post( $image ), wp_kses_post( $message ) );
			}
		}
	}

	/**
	 * Delete or update the rate reminder admin notice.
	 *
	 * @return  void
	 */
	function ctpr_update_rate_reminder() {
		check_ajax_referer( 'ctpr_js_nonce' );

		if( isset( $_POST['update'] ) ) {
			if( $_POST['update'] === 'ctpr_delete_rate_reminder' ) {
				
				delete_transient( 'ctpr_rate_reminder' );

				if( ! get_transient( 'ctpr_rate_reminder' ) && set_transient( 'ctpr_rate_reminder_deleted', 'No reminder to show' ) ) {
					$response = [
						'error' => false,
					];
				} else {
					$response = [
						'error' => true,
					];
				}
			}

			if( $_POST['update'] === 'ctpr_ask_later' ) {
				$date = new \DateTime();
				$date->add( new \DateInterval( 'P7D' ) );
				$date_format = $date->format( 'Y-m-d' );

				delete_transient( 'ctpr_rate_reminder' );

				if( set_transient( 'ctpr_rate_reminder', $date_format ) ) {
					$response = [
						'error' => false,
					];
				} else {
					$response = [
						'error' => true,
						'error_type' => set_transient( 'ctpr_rate_reminder', $date_format ),
					];
				}
			}

			wp_send_json( $response );
		}
	}
}