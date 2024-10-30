<?php
namespace ContentPromoter\Core\Fields;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

use \ContentPromoter\Core\Helpers\WPHelper;

class WPItemSelector extends \ContentPromoter\Core\Field
{
    /**
     * Field filter
     * 
     * @var  string
     */
    protected $filter = 'sanitize_key';
    
    /**
     * All types
     * 
     * @var  array
     */
    public static $types = [
        'post',
        'page',
        'menu_item',
        'wpforms',
        'gravityforms',
        'woocommerce',
        'cpt'
    ];

    /**
     * The item type
     * 
     * @var  string
     */
    private $item_type;
    
    public function getProps()
    {
        $this->item_type = $this->options->get('item_type', 'post');

        $value = $this->options->get('value', []);

        $class = '\ContentPromoter\Core\Helpers\\' . WPHelper::getHelperClassName($this->item_type) . 'Helper';

        if (!class_exists($class))
        {
            return [];
        }

        $items = $class::getSelectedSearchItems($value, WPHelper::parsePostType($this->item_type));

        $items = WPHelper::parseData($items, $this->item_type);
        
        return [
            'items' => $items
        ];
    }
}