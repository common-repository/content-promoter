<?php
namespace ContentPromoter\Core\Fields;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

class Text extends \ContentPromoter\Core\Field
{
    /**
     * Field filter
     * 
     * @var  string
     */
    protected $filter = 'sanitize_text_field';
}