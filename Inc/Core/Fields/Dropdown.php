<?php
namespace ContentPromoter\Core\Fields;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

class Dropdown extends \ContentPromoter\Core\Field
{
    /**
     * Field filter
     * 
     * @var  string
     */
    protected $filter = 'sanitize_key';

    public function getProps()
    {
        return [
			'choices' => $this->options->get('choices', []),
        ];
	}
}