<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

class Validator
{
    private static $instance = null;
    
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new Validator();
        }

        return self::$instance;
    }

    /**
     * Validate the fields values
     * 
     * @param   array  $fields
     * 
     * @return  void
     */
    public function run(&$fields)
    {
        if (!count($fields))
        {
            return;
        }
        
        foreach ($fields as $key => &$value)
        {
            switch ($key)
            {
                // total promoting content items
                case 'total_items':
                    $value = preg_replace('/\D/', '', $value);
                    break;
                
                // promoting content items
                case 'items':
                    foreach ($value as $item_key => &$item_value)
                    {
                        // validate promoting item title
                        if (isset($item_value['title']))
                        {
                            $item_value['title'] = sanitize_text_field($item_value['title']);
                        }
                        
                        // validate promoting item type
                        if (isset($item_value['type']))
                        {
                            $item_value['type'] = sanitize_text_field($item_value['type']);
                        }

                        // validate promoting item fields
                        if (isset($item_value['fields']))
                        {
                            $this->validateSubfields($item_value['fields']);
                        }
                    }
                    break;
                // publish settings
                case 'publish_settings':
                    $cats = [
                        'posts',
                        'pages',
                        
                    ];

                    foreach ($value as $item_key => &$item_value)
                    {
                        // posts, pages, etc...
                        if (in_array($item_key, $cats))
                        {
                            // type
                            if (isset($item_value['type']))
                            {
                                $item_value['type'] = sanitize_text_field($item_value['type']);
                            }

                            // items
                            if (isset($item_value['items']))
                            {
                                foreach ($item_value['items'] as $ps_key => &$ps_value)
                                {
                                    $ps_value = sanitize_key($ps_value);
                                }
                            }
                        }
                        else if (in_array($item_key, ['custom_css', 'custom_js']))
                        {
                            $item_value = wp_strip_all_tags($item_value);
                        }
                        else
                        {
                            // mode, replacement element
                            $item_value = sanitize_key($item_value);
                        }
                    }
                    break;
            }
            
        }
    }

    /**
     * Validate subfields of a Promoting Content Item
     * 
     * @param   array  $subfields
     * 
     * @return  void
     */
    public function validateSubfields(&$subfields)
    {
        foreach ($subfields as $key => &$value)
        {
            // skip empty fields
            if (!isset($value['value']))
            {
                continue;
            }
            
            // skip fields that do not have a type for some reason
            if (!isset($value['type']))
            {
                continue;
            }

            // skip pro field
            if (strtolower($value['type']) == 'pro')
            {
                continue;
            }
            
            $this->validateFieldValue($value);
        }
    }

    /**
     * Validates a fields value
     * 
     * @param   array  $value   The field data
     * 
     * @return  void
     */
    public function validateFieldValue(&$value)
    {
        if (!isset($value['type']))
        {
            return;
        }

        if (!isset($value['value']))
        {
            return;
        }

        $field = $value['type'];

        $field_path = '\ContentPromoter\Core\Fields\\' . $field;

        if (!class_exists($field_path))
        {
            return;
        }

        $field_class = new $field_path();

        $filterMethod = $field_class->getFilter();

        $multi_values_field_types = [
            'checkbox',
            'wpitemselector'
        ];
        
        // array-values fields validation
        if (in_array($field, $multi_values_field_types))
        {
            if (is_array($value['value']))
            {
                foreach ($value['value'] as $key => &$checkbox_value)
                {
                    $checkbox_value = $filterMethod($checkbox_value);
                }
            }
        }
        else
        {
            // single value validation
            if ($filterMethod != 'raw')
            {
                $value['value'] = $filterMethod($value['value']);
            }
        }
    }
}