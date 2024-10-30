<?php
namespace ContentPromoter\Core\Helpers;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class HTML {
	/**
	 * Generates a Pro button
	 * 
	 * @param   array   $atts
	 * 
	 * @return  string
	 */
	public static function renderProButton($atts = [])
	{
		if (!$atts)
		{
			return;
        }
		
		$class = '\ContentPromoter\Core\Fields\Pro';

		$options = [
			'type' => 'Pro',
			'render_group' => false
        ];
        
        $options = array_merge($options, $atts);
        
		$field = new $class($options);

		ob_start();
		$field->render();
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
    }
}