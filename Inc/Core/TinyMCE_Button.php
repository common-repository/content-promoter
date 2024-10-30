<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class TinyMCE_Button
{
	public function init()
	{
		// Add new buttons
		add_filter( 'mce_buttons', [$this, 'register_buttons'] );
		
		// Load the TinyMCE plugin js file
		add_filter( 'mce_external_plugins', [$this, 'register_tinymce_js'] );
	}

	/**
	 * Register the button
	 * 
	 * @return  void
	 */
	public function register_buttons($buttons)
	{
		array_push( $buttons, '|', 'ctpr-tinymce-button' );

		return $buttons;
	}

	function register_tinymce_js( $plugin_array )
	{
		$plugin_array['ctpr-tinymce-button'] = CTPR_ADMIN_MEDIA_URL . 'js/ctpr-tinymce-editor-button.js';
		return $plugin_array;
	}
}