<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class Block
{
	public function init()
	{
		$this->register_block();
	}

	/**
	 * Register the block
	 * 
	 * @return  void
	 */
	public function register_block()
	{
		wp_register_script(
			'content-promoter-block-js-register-file',
			CTPR_ADMIN_MEDIA_URL . 'js/ctpr-gutenberg-block.js',
			[],
			CTPR_VERSION,
			false
		);

		wp_register_style(
			'content-promoter-block-css-register-file',
			CTPR_ADMIN_MEDIA_URL . 'css/ctpr-gutenberg-block.css',
			[],
			CTPR_VERSION,
			false
		);
	 
		register_block_type( 'content-promoter/smart-tag', [
			'editor_script' => 'content-promoter-block-js-register-file',
			'editor_style' => 'content-promoter-block-css-register-file',
		] );
	}
}