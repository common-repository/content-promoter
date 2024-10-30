<?php
namespace ContentPromoter\Core\Fields;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class Heading extends \ContentPromoter\Core\Field
{
    public function getProps()
    {
        return [
            'heading' => $this->options->get('heading', 'h3')
        ];
    }
}