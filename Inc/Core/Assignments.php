<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

use ContentPromoter\Core\Libs\Registry;

class Assignments {
    private $assignments;
    private $post_id;
    
    public function __construct($assignments = null, $post_id)
    {
        if (!$assignments || !$post_id)
        {
            return;
        }
        
        $assignments = new Registry($assignments);
        $this->assignments = $assignments;
        $this->post_id = $post_id;
    }

    /**
     * Check whether we pass the assignments or not
     * 
     * @return  boolean
     */
    public function pass()
    {
        if (!$this->assignments)
        {
            return false;
        }

        $pass_checks = [];

        $pass = false;
        
        $post_pass = $this->IdExistsInPosts();
        if (!empty($this->assignments->get('posts.items', [])) && $this->assignments->get('posts.type', 'none') != 'none')
        {
            $pass_checks[] = $post_pass;
        }
        
        $page_pass = $this->IdExistsInPages();
        if (!empty($this->assignments->get('pages.items', [])) && $this->assignments->get('pages.type', 'none') != 'none')
        {
            $pass_checks[] = $page_pass;
        }
        
        

        if (count($pass_checks))
        {
            $local_pass = false;

            foreach ($pass_checks as $p)
            {
                $local_pass = $local_pass || $p;
            }

            $pass = $local_pass;
        }
        
        return $pass;
    }

    /**
     * Check if we are in a post
     * 
     * @return  boolean
     */
    private function IdExistsInPosts()
    {
        return $this->checkIfItemTypePasses('posts', $this->post_id);
    }
    
    /**
     * Check if we are in a page
     * 
     * @return  boolean
     */
    private function IdExistsInPages()
    {
        return $this->checkIfItemTypePasses('pages', $this->post_id);
    }
    
    

    /**
     * Check if item type passes assignments
     * 
     * @param   string   $item_type
     * @param   int      $item_id
     * 
     * @return  boolean
     */
    private function checkIfItemTypePasses($item_type, $item_id)
    {
        if (!$item_type || !$item_id)
        {
            return false;
        }

        if (!is_string($item_type))
        {
            return false;
        }
        
        if (!$this->assignments->get($item_type))
        {
            return false;
        }

        if (!$type = $this->assignments->get($item_type . '.type', 'none'))
        {
            return false;
        }

        if ($type == 'none')
        {
            return false;
        }
        
        if (!in_array($type, ['include', 'exclude']))
        {
            return false;
        }
        
        if (!$items = $this->assignments->get($item_type . '.items', []))
        {
            return true;
        }

        if ($type == 'include' && in_array($item_id, $items))
        {
            return true;
        }

        if ($type == 'exclude' && in_array($item_id, $items))
        {
            return false;
        }

        return false;
    }
}