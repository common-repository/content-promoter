<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

use ContentPromoter\Core\Libs\Registry;

abstract class BaseType
{
	/**
	 * The options
	 * 
	 * @var  array
	 */
	protected $options;

	/**
	 * List of fields that do not need a name
	 * 
	 * @var  array
	 */
	const list_of_fields_that_dont_need_a_name = [
		
		'pro',
		
		
	];

	public function __construct($options = null)
	{
		$this->options = $options;
	}

	/**
	 * Renders the type's content
	 * 
	 * @return  string
	 */
	public function render()
	{
		$settings = $this->getSettings();

		$html = '';

		$index = 1;
		foreach ($settings as $key => $options)
		{
			$class = '\\ContentPromoter\\Core\\Fields\\' . $options['type'];
			if (!class_exists($class))
			{
				continue;
			}

			// skip fields that do not have a name
			if (!isset($options['name']) && in_array($options['type'], self::list_of_fields_that_dont_need_a_name))
			{
				continue;
			}

			$options['value'] = isset($options['value']) && !empty($options['value']) ? $options['value'] : $this->findFieldValueInOptions($key, $options);
			$options['item_id'] = $this->options['item_id'];
			$options['field_id'] = $key;

			$field_class = new $class($options);

			ob_start();
			$field_class->render();
			$html .= ob_get_contents();
			ob_end_clean();

			$index++;
		}

		return $html;
	}

	/**
	 * Finds the value in the options
	 * 
	 * @param   string  $key
	 * @param   array   $options
	 * 
	 * 
	 * @return  mixed
	 */
	public function findFieldValueInOptions($key, $options)
	{
		if (!isset($key))
		{
			return '';
		}

		if (!isset($this->options['fields']))
		{
			return '';
		}

		$name = str_replace(['[', ']'], '', $key);
		
		foreach ($this->options['fields'] as $key => $value)
		{
			if ($key != $name)
			{
				continue;
			}

			if (isset($value['value']) && !empty($value['value']))
			{
				return $value['value'];
			}
			
			if (isset($value['default']))
			{
				return $value['default'];
			}
			
			break;
		}

		return '';
	}

	/**
	 * Renders the promoting item on the front-end
	 * 
	 * @return  void
	 */
	public function renderFront()
	{
		// if no options are set abort
		if (empty($this->options))
		{
			return;
		}

		
		// ensure Promoting Type has a valid type set
		if (!property_exists($this, 'type'))
		{
			return;
		}
		
		// add default media files
		$this->addDefaultMedia();
		
		// add promoting type media files if they exist
		if (method_exists($this, 'addFrontMedia'))
		{
			$this->addFrontMedia();
		}
		
        contentpromoter()->renderer->render('item_content/' . $this->type, $this->options);
	}

	private function addDefaultMedia()
	{
		wp_register_style(
			'ctpr-front-css',
			CTPR_PUBLIC_MEDIA_URL . 'css/ctpr-front.css',
			[],
			CTPR_VERSION,
			false
		);
		wp_enqueue_style( 'ctpr-front-css' );
	}
}