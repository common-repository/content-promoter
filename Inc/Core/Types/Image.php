<?php
namespace ContentPromoter\Core\Types;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class Image extends \ContentPromoter\Core\BaseType
{
    protected $type = 'image';
    
    protected function getSettings()
    {
        return [
            [
                'type' => 'Heading',
                'heading' => 'h4',
                'label' => 'CP_IMAGE_TYPE_TITLE',
                'class' => ['no-bold'],
                'render_group' => false
            ],
            'image' => [
                'type' => 'ImageUpload',
                'name' => '[value]',
                'label' => 'CP_UPLOAD_IMAGE',
                'description' => 'CP_UPLOAD_IMAGE_DESC'
            ],
            'image_fullwidth' => [
                'type' => 'GroupRadioList',
                'name' => '[value]',
                'label' => 'CP_IMAGE_FULLWIDTH',
                'description' => 'CP_IMAGE_FULLWIDTH_DESC',
                'default' => 'auto',
                'items' => [
                    'auto' => 'CP_AUTO',
                    'fullwidth' => 'CP_FULL_WIDTH',
                ]
            ],
            'image_link' => [
                'type' => 'Text',
                'name' => '[value]',
                'label' => 'CP_IMAGE_LINK',
                'description' => 'CP_IMAGE_LINK_DESC'
            ],
            
            
            [
                'type' => 'Pro',
                'label' => 'CP_IMAGE_LIGHTBOX',
                'description' => 'CP_IMAGE_LIGHTBOX_DESC'
            ],
            
            'title' => [
                'type' => 'Text',
                'name' => '[value]',
                'label' => 'CP_IMAGE_TITLE',
                'description' => 'CP_IMAGE_TITLE_DESC'
            ],
            
            
            [
                'type' => 'Pro',
                'label' => 'CP_TITLE_POSITION',
                'description' => 'CP_TITLE_POSITION_DESC'
            ],
            
            'description' => [
                'type' => 'Text',
                'name' => '[value]',
                'label' => 'CP_IMAGE_DESCRIPTION',
                'description' => 'CP_IMAGE_DESCRIPTION_DESC'
            ],
            
            
            [
                'type' => 'Pro',
                'label' => 'CP_DESCRIPTION_POSITION',
                'description' => 'CP_DESCRIPTION_POSITION_DESC'
            ],
            
            'open_in' => [
                'type' => 'GroupRadioList',
                'name' => '[value]',
                'label' => 'CP_OPEN_IMAGE_LINK_IN',
                'default' => '_self',
                'description' => 'CP_OPEN_IMAGE_LINK_IN_DESC',
                'items' => [
                    '_self' => 'CP_SAME_TAB',
                    '_blank' => 'CP_NEW_TAB'
                ]
            ],
            
            
            [
                'type' => 'Pro',
                'label' => 'CP_TEXT_ALIGNMENT',
                'description' => 'CP_TEXT_ALIGNMENT_DESC'
            ],
            
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
			'ctpr-pi-image-glightbox-css',
			CTPR_PUBLIC_MEDIA_URL . 'css/ctpr-glightbox.css',
			[],
			CTPR_VERSION,
			false
		);
        wp_enqueue_style( 'ctpr-pi-image-glightbox-css' );

		wp_register_style(
			'ctpr-pi-image',
			CTPR_PUBLIC_MEDIA_URL . 'css/ctpr-promoting-item-image.css',
			[],
			CTPR_VERSION,
			false
		);
        wp_enqueue_style( 'ctpr-pi-image' );
        
		wp_register_script(
			'ctpr-pi-image-glightbox-js',
			CTPR_PUBLIC_MEDIA_URL . 'js/ctpr-glightbox.js',
			[],
			CTPR_VERSION,
			false
		);
		wp_enqueue_script( 'ctpr-pi-image-glightbox-js' );
        
		wp_register_script(
			'ctpr-pi-lightbox-js',
			CTPR_PUBLIC_MEDIA_URL . 'js/ctpr-pi-lightbox.js',
			[],
			CTPR_VERSION,
			false
		);
		wp_enqueue_script( 'ctpr-pi-lightbox-js' );
    }
}