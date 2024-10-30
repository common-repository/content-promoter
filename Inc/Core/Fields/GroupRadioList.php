<?php
namespace ContentPromoter\Core\Fields;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

class GroupRadioList extends \ContentPromoter\Core\Field
{
    /**
     * Field filter
     * 
     * @var  string
     */
    protected $filter = 'sanitize_key';
    
    public function getProps()
    {
        $items = $this->options->get('items', []);

        if (empty($items))
        {
            $items = [
                'no' => 'CP_NO',
                'yes' => 'CP_YES'
            ];
        }
        
        return [
            'items' => $items
        ];
    }
}