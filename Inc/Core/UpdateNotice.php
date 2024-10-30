<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class UpdateNotice {
	public function init()
	{
		$this->registerAjax();

		if (!$this->canRun())
		{
			return false;
		}

		$this->loadMedia();
	}

	private function canRun()
	{
		global $pagenow;
		if (!$pagenow || $pagenow != 'admin.php')
		{
			return false;
		}

		$page = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '';

		$allowed_pages = [
			'content-promoter-settings',
			'content-promoter',
			'content-promoter-getting-started'
		];
		
		if (!in_array($page, $allowed_pages))
		{
			return false;
		}
		
		return true;
	}

	private function registerAjax()
	{
		add_action('wp_ajax_ctpr_show_update_notice', [$this, 'ctpr_show_update_notice']);
	}

	public function ctpr_show_update_notice()
	{
		$url = CTPR_GET_LICENSE_VERSION_URL;

		$response = wp_remote_get($url);

		if (!is_array($response))
		{
			return false;
		}

		$response_decoded = null;

		try
		{
			$response_decoded = json_decode( $response['body'] );
		}
		catch ( Exception $ex )
		{
			return false;
		}

		if (!isset($response_decoded->version))
		{
			return false;
		}

		$new_version = $response_decoded->version;

		$installed_version = CTPR_VERSION;

		if (!version_compare($installed_version, $new_version, '<'))
		{
			return false;
		}

		// load update notice
		$notice = contentpromoter()->renderer->render('template/update_notice', [
			'name' => contentpromoter()->plugin_name,
			'version' => $new_version
		], true);
		
		echo json_encode([
			'html' => $notice
		]);
		wp_die();
	}

	private function loadMedia()
	{
		// load update notice js
		wp_register_script(
			'ctpr-update-notice-js',
			CTPR_ADMIN_MEDIA_URL . 'js/ctpr-update-notice.js',
			[],
			CTPR_VERSION,
			false
		);
		wp_enqueue_script( 'ctpr-update-notice-js' );
	}
}