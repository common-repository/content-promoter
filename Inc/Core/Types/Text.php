<?php
namespace ContentPromoter\Core\Types;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class Text extends \ContentPromoter\Core\BaseType
{
    protected $type = 'text';
    
    protected function getSettings()
    {
        return [
            [
                'type' => 'Heading',
                'heading' => 'h4',
                'label' => 'CP_TEXT_TYPE_TITLE',
                'class' => ['no-bold'],
                'render_group' => false
            ],
            'text' => [
                'type' => 'WPEditor',
                'name' => '[value]',
                'label' => 'CP_ENTER_TEXT',
                'rows' => 5
            ]
        ];
    }

    /**
     * Add front-end media files for this field
     * 
     * @return  void
     */
    protected function addFrontMedia()
    {
		wp_register_style(
			'ctpr-pi-text',
			CTPR_PUBLIC_MEDIA_URL . 'css/ctpr-promoting-item-text.css',
			[],
			CTPR_VERSION,
			false
		);
		wp_enqueue_style( 'ctpr-pi-text' );
    }
}