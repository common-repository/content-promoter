<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

use ContentPromoter\Core\Libs\Registry;
use ContentPromoter\Core\Helpers\PromotingContentsHelper;

class PromotingContents
{
    const valid_post_types = [
        'post',
        'page'
    ];

    private $item;
    
	public function init()
	{
        add_filter('the_content', [$this, 'run']);
    }

    /**
     * Initialize the filter of post content
     * 
     * @param   string  $content
     * 
     * @return  string
     */
    public function run($content)
    {
        global $post;

        if (!$post)
        {
            return $content;
        }

        if (!$this->canRun($post->ID))
        {
            // remove all smart tags from the post content
            PromotingContentsHelper::autoCleanup($content);
            
            return $content;
        }

        

        PromotingContentsHelper::prepareContent($content, $this->item);

        return $content;
    }

    

    /**
     * Check whether we can add the publishing items to the post
     * 
     * @param   int    $id
     * 
     * @return  boolean
     */
    private function canRun($id)
    {
        if (!$id)
        {
            return false;
        }
        
        if (!$this->item = PromotingContentsHelper::checkIfPromotingItemExistsForPost($id))
        {
            return false;
        }

        $this->item = new Registry($this->item);
        
        if (!is_single() && !is_page())
        {
            return false;
        }
        
        if (!$post_type = get_post_type())
        {
            return false;
        }

        $cpts = self::valid_post_types;
        
        
        
        if (!in_array($post_type, $cpts))
        {
            return false;
        }
        
        return true;
    }

    /**
     * Render the promoting item
     * 
     * @param   array    $fields
     * @param   string   $type
     * @param   integer  $promoting_content_id
     * 
     * @return  string
     */
    public static function render($fields = [], $type = '', $promoting_content_id = '')
    {
        if (!$fields || !$type || !count((array) $fields) || !is_string($type) || empty($type) || !$promoting_content_id)
        {
            return '';
        }

        $class = '\ContentPromoter\Core\Types\\' . $type;
        
        if (!class_exists($class))
        {
            return;
        }
        
        $fields = (array) $fields;

        $fields['promoting_content_id'] = $promoting_content_id;

        $obj = new $class($fields);
        ob_start();
        $obj->renderFront();
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}