<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

use ContentPromoter\Core\Libs\Registry;

class Field
{
    /**
     * Field settings
     * 
     * @var  array
     */
    protected $settings;

    /**
     * Given field options
     * 
     * @var  array
     */
    protected $options;
    
    public function __construct($options = [])
    {
        $this->options = new Registry($options);
        
        $this->setDefaults();
        $this->settings = wp_parse_args($this->options, $this->settings);
        
        if (method_exists($this, 'getProps'))
        {
            $this->settings = array_merge($this->settings, $this->getProps());
        }

        $this->setValue();
    }

    /**
     * Render the field
     * 
     * @return  void
     */
    public function render()
    {
        if (method_exists($this, 'addMedia'))
        {
            $this->addMedia();
        }
        
        $field_html = contentpromoter()->renderer->render('fields/' . $this->options->get('type'), $this->settings, true);

        if ($this->options->get('render_group', true))
        {
            $this->settings['content'] = $field_html;
            contentpromoter()->renderer->render('fields/tmpl', $this->settings);
        }
        else
        {
            echo $field_html;
        }
    }

    /**
     * Get field value
     * 
     * @return  string
     */
    public function getValue()
    {
        global $pagenow;
        
        $options = $this->options;

		// if we were given a value directly, then use it
		if (!empty($options['value']))
		{
			return $options['value'];
        }
        
        $default = $options['default'];

		// In a new Custom Post Type(CPT) Item
		if ($pagenow == 'post-new.php')
		{
			return $default;
        }
        
		if ($pagenow != 'post.php')
		{
            return '';
        }

        // Editing a CPT Item, we need to fetch the data from the post meta
        $namePrefix = Metabox::$prefix;

        global $post;
        $meta = get_post_meta($post->ID, $namePrefix, true);

        $name = $this->options['name'];
        
		if (empty($name))
		{
			return $default;
		}

        return Helpers\FieldsHelper::findFieldValueInArray($name, $default, $meta);
    }

    /**
     * Set field value
     * 
     * @return  void
     */
    public function setValue()
    {
        $this->options['value'] = $this->getValue();
        $this->settings['value'] = $this->options['value'];
    }

    /**
     * Set option value
     * 
     * @param   string  $name
     * @param   mixed   $value
     * 
     * @return  void
     */
    public function setOptionValue($name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * Sets defaults
     * 
     * @return  void
     */
    private function setDefaults()
    {
        $namePrefix = Metabox::$prefix;

        $simple_name = $this->options->get('simple_name', false);

        $base_name = $namePrefix . '[items][' . $this->options->get('item_id', '') . '][fields][' . $this->options->get('field_id', '') . ']';
        
        $name = $this->options->get('name', '');
        if ($simple_name)
        {
            $base_name = '';
            $name = $namePrefix . $name;
        }

        $this->settings = [
            'base_name' => $base_name,
            'name' => $base_name . $name,
            'type' => $this->options->get('type', ''),
            'label' => $this->options->get('label', ''),
            'description' => $this->options->get('description', ''),
            'placeholder' => contentpromoter()->_($this->options->get('placeholder', '')),
            'default' => $this->options->get('default', ''),
            'hint' => $this->options->get('hint', ''),
            'value' => $this->options->get('value', ''),
            'item_id' => $this->options->get('item_id', ''),
            'field_id' => $this->options->get('field_id', ''),
            'item_type' => $this->options->get('item_type', 'post'),
            'class' => $this->options->get('class', []),
            'input_class' => $this->options->get('input_class', []),
            'render_group' => $this->options->get('render_group', true),
            'promoting_content_id' => $this->options->get('promoting_content_id', ''),
            'description_pos' => $this->options->get('description_pos', 'start'),
        ];
    }

    public function getFilter()
    {
        return $this->filter;
    }
}