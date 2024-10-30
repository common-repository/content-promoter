<?php
namespace ContentPromoter\Core\Fields;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class ImageUpload extends \ContentPromoter\Core\Field
{
    /**
     * Field filter
     * 
     * @var  string
     */
    protected $filter = 'esc_url_raw';
}