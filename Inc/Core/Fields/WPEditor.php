<?php
namespace ContentPromoter\Core\Fields;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

class WPEditor extends \ContentPromoter\Core\Field
{
    /**
     * Field filter
     * 
     * @var  string
     */
    protected $filter = 'raw';
    
    public function getProps()
    {
        return [
            'rows' => $this->options->get('rows', 3)
        ];
    }
}