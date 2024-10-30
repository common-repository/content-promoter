<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

class PublishSettings {
    /**
     * Publish Settings Fields
     * 
     * @var  array
     */
    private $fields;
    
    public function __construct()
    {
        $this->fields = $this->getSettings();
    }

    /**
     * Render fields
     * 
     * @return  void
     */
    public function render()
    {
        $html = '';

        foreach ($this->fields as $field)
        {
			$class = '\\ContentPromoter\\Core\\Fields\\' . $field['type'];
			if (!class_exists($class))
			{
				continue;
            }
            
            // create field to retrieve the value
            $field_class = new $class($field);
            $field['value'] = $field_class->getValue();

            // then create a new field to pass the value to be able to render it
            $field_class = new $class($field);

			ob_start();
			$field_class->render();
			$field_html = ob_get_contents();
            ob_end_clean();
            
            if ($field['type'] == 'WPItemSelector')
            {
                // type selector
                $type_selector_data = [
                    'type' => 'Dropdown',
                    'simple_name' => true,
                    'name' => '[publish_settings][' . $field['item_type'] . 's][type]',
                    'input_class' => ['ctpr-publish-settings-item-type-selector'],
                    'label' => 'CP_TYPE',
                    'default' => 'none',
                    'choices' => [
                        'none' => 'CP_NONE',
                        'include' => 'CP_INCLUDE',
                        'exclude' => 'CP_EXCLUDE'
                    ]
                ];
                $type_selector = new \ContentPromoter\Core\Fields\Dropdown($type_selector_data);
                
                ob_start();
                $type_selector->render();
                $type_selector_html = ob_get_contents();
                ob_end_clean();
                
                $data = [
                    'type' => $type_selector->getValue(),
                    'type_selector' => $type_selector_html,
                    'content' => $field_html
                ];

                $html .= contentpromoter()->renderer->render('publish_settings/item', $data, true);
            }
            else
            {
                $html .= $field_html;
            }
        }

        $data = [
            'content' => $html
        ];
        contentpromoter()->renderer->render('publish_settings/tmpl', $data);
    }

    /**
     * Get page settings
     * 
     * @return  array
     */
    private function getSettings()
    {
        global $post;
        // get whether the replacement element field should be hidden or not
        // it should be hidden when we have selected auto
        $replacement_element_hidden = true;
        if ($post)
        {
            $meta = get_post_meta($post->ID, 'ctpr_meta_settings', true);
            $mode = isset($meta['publish_settings']['mode']) ? $meta['publish_settings']['mode'] : 'manual';
            $replacement_element_hidden = ($mode == 'auto') ? false : true;
        }
        
        return [
            [
                'type' => 'Heading',
                'heading' => 'h4',
                'label' => 'CP_PUBLISH_SETTINGS_TITLE',
                'class' => ['no-bold', 'text-center'],
                'render_group' => false
            ],
            'publish_settings_post' => [
                'type' => 'WPItemSelector',
                'item_type' => 'post',
                'simple_name' => true,
                'name' => '[publish_settings][posts][items]',
                'label' => 'CP_POSTS_SELECTOR',
                'description' => 'CP_PUBLISH_SETTINGS_POSTS_SELECTOR_DESC',
                'description_pos' => 'end'
            ],
            'publish_settings_page' => [
                'type' => 'WPItemSelector',
                'item_type' => 'page',
                'simple_name' => true,
                'name' => '[publish_settings][pages][items]',
                'label' => 'CP_PAGES_SELECTOR',
                'description' => 'CP_PUBLISH_SETTINGS_PAGES_SELECTOR_DESC',
                'description_pos' => 'end'
            ],
            
            
            [
                'type' => 'Pro',
                'label' => 'CP_CPTS_SELECTOR',
                'description' => 'CP_PUBLISH_SETTINGS_CPTS_SELECTOR_DESC'
            ],
            
            [
                'type' => 'Heading',
                'heading' => 'h2',
                'label' => 'CP_CONFIGURATION',
                'class' => ['light-bg'],
                'render_group' => false
            ],
            'publish_settings_mode' => [
                'simple_name' => true,
                'type' => 'GroupRadioList',
                'name' => '[publish_settings][mode]',
                'label' => 'CP_PUBLISH_SETTINGS_MODE',
                'description' => 'CP_PUBLISH_SETTINGS_MODE_DESC',
                'default' => 'manual',
                'input_class' => ['ctpr-publish-settings-mode-selector'],
                'class' => ['default'],
                'items' => [
                    'auto' => 'CP_AUTO',
                    'manual' => 'CP_MANUAL',
                ]
            ],
            'publish_settings_mode_desc' => [
                'type' => 'Heading',
                'description' => 'CP_PUBLISH_SETTINGS_MODE_MORE_DESC'
            ],
            'publish_settings_replacement_element' => [
                'simple_name' => true,
                'type' => 'Dropdown',
                'name' => '[publish_settings][replacement_element]',
                'label' => 'CP_PUBLISH_SETTINGS_REPLACEMENT_ELEMENT',
                'description' => 'CP_PUBLISH_SETTINGS_REPLACEMENT_ELEMENT_DESC',
                'default' => 'global',
                'class' => ['ctpr-publish-settings-replacement-element ' . (($replacement_element_hidden) ? 'ctpr-field-hidden' : '')],
                'choices' => [
                    'global' => 'CP_GLOBAL',
                    'div' => 'CP_DIV',
                    'span' => 'CP_SPAN',
                    'p' => 'CP_P',
                    
                ]
            ],
            
            [
                'type' => 'Pro',
                'label' => 'CP_PUBLISH_SETTINGS_REPLACEMENT_ELEMENT_FREE',
                'description' => 'CP_PUBLISH_SETTINGS_REPLACEMENT_ELEMENT_FREE_DESC'
            ],
            
            [
                'type' => 'Heading',
                'heading' => 'h2',
                'label' => 'CP_CUSTOM_CSS_JS',
                'class' => ['light-bg'],
                'render_group' => false
            ],
            
            
            [
                'type' => 'Pro',
                'label' => 'CP_CUSTOM_CODE_CSS',
                'description' => 'CP_CUSTOM_CODE_CSS_DESC'
            ],
            [
                'type' => 'Pro',
                'label' => 'CP_CUSTOM_CODE_JS',
                'description' => 'CP_CUSTOM_CODE_JS_DESC'
            ],
            
        ];
    }
}