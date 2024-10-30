<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

class Wizard
{
    /**
     * Returns all available items to add in the wizard
     * 
     * @return  int
     */
    public function getTotalItems()
    {
        
        $total = 3;
        
        

        return $total;
    }
}