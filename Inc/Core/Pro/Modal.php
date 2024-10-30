<?php
namespace ContentPromoter\Core\Pro;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

class Modal {
	public function __construct()
	{
        add_action('admin_footer', [$this, 'addProModal']);
    }

    /**
     * Render Pro Modal to the page
     * 
     * @return  void
     */
    public function addProModal()
    {
        contentpromoter()->renderer->render('pro/modal');
    }
}