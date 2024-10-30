<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

use ContentPromoter\Core\Libs\Registry;

class Renderer
{
	/**
	 * Data passed to the view
	 * 
	 * @var  mixed
	 */
	private $data;

	/**
	 * Renders a layout to the screen
	 * 
	 * @param   string	  $layout
	 * @param   array	  $data
	 * @param   boolean   $return
	 * 
	 * @return  void
	 */
	public function render($layout, $data = [], $return = false)
	{
		$this->data = new Registry($data);

		$filename = CTPR_LAYOUTS_DIR . strtolower($layout) . '.php';

		if (!file_exists($filename))
		{
			return;
		}
		
		if ($return)
		{
			ob_start();
			include $filename;
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
		}

		include $filename;
	}
}