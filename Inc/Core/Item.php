<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

class Item {
    /**
     * Returns an Items data
     * 
     * @param   int  $id
     * 
     * @return  array
     */
    public static function getItemData($id)
    {
        $itemdata = [];
        $itemdata['types'] = Types::getTypes();

        if(!$data = Helpers\ItemHelper::getMeta($id))
        {
            return $itemdata;
        }

        $itemdata['post'] = get_post($id);

        if (!isset($data['items']))
        {
            return $itemdata;
        }

        $index = 1;
        
        foreach ($data['items'] as $key => &$value)
        {
            $type = isset($value['type']) ? $value['type'] : '';
            
            if (empty($type))
            {
                continue;
            }

            // if its a promotion, then load the inner type
            if (strtolower($type) == 'promotion')
            {
                $type = self::getInnerType($value);
            }

            $value['item_id'] = $index;
            
            $class = '\ContentPromoter\Core\Types\\' . str_replace('_', '', $type);

            if (!class_exists($class))
            {
                continue;
            }
            
            $baseType = new $class($value);
            $value['content'] = $baseType->render();

            $index++;
        }

        $itemdata = array_merge($data, $itemdata);

        return $itemdata;
    }

    /**
     * Gets the inner type of a base type
     * 
     * @param   string  $value
     * 
     * @return  string
     */
    private static function getInnerType($value)
    {
        $type = $value['type'];

        $fields = isset($value['fields']) ? $value['fields'] : [];
        if (!count($fields))
        {
            return $type;
        }

        foreach ($fields as $key => $field)
        {
            if ($key == 'promotion_content_chooser')
            {
                $type = $field['value'];
                break;
            }
        }

        return $type;
    }
}