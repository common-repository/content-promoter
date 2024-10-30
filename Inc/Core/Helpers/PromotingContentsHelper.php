<?php
namespace ContentPromoter\Core\Helpers;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

use ContentPromoter\Core\Libs\Registry;

class PromotingContentsHelper
{
    /**
     * The smart tag used in manual mode to identify all spots to place promoting items.
     * 
     * @var  string
     */
    const smart_tag = '{{CTPR_PROMOTING_ITEM}}';
    
    /**
     * Get items
     * 
     * @param   int     $id
     * @param   int     $limit
     * @param   string  $post_status
     * 
     * @return  object
     */
    public static function get($id = null, $limit = null, $post_status = 'publish')
    {
        global $wp;

        $payload = [
            'post_type' => 'content-promoter',
            'post_status' => $post_status
        ];

        if ($limit)
        {
            $payload['posts_per_page'] = $limit;
        }

        $method = 'get_posts';
        
        if (!empty($id) && is_int($id))
        {
            $payload['ID'] = $id;
            $method = 'get_post';
        }

        if (!$data = $method($payload))
        {
            return [];
        }
        
        if ($method == 'get_post')
        {
            $data->meta = ItemHelper::getMeta($data->ID);
        }
        else
        {
            foreach ($data as $key => &$value)
            {
                $value->meta = ItemHelper::getMeta($value->ID);
            }
        }

        return $data;
    }

    public static function getAll($limit = null, $post_status = 'publish')
    {
        return self::get(null, $limit, $post_status);
    }

    /**
     * Check if we have a promoting item for a post
     * 
     * @param   int    $post_id
     * 
     * @return  mixed
     */
    public static function checkIfPromotingItemExistsForPost($post_id)
    {
        if (!is_int($post_id))
        {
            return false;
        }

        if (!$data = self::get())
        {
            return false;
        }

        $foundData = false;

        foreach ($data as $key => &$value)
        {
            $meta = ItemHelper::getMeta($value->ID);
            $metaParsed = new Registry($meta);

            $assignments = new \ContentPromoter\Core\Assignments($metaParsed->get('publish_settings', []), $post_id);
            if (!$assignments->pass())
            {
                continue;
            }

            $value->meta = $meta;
            $foundData = $value;
            break;
        }

        return $foundData;
    }

    /**
     * Prepares the content of the output
     * 
     * @param   string  $content
     * @param   object  $item
     * 
     * @return  string
     */
    public static function prepareContent(&$content, $item)
    {
        $mode = $item->get('meta.publish_settings.mode', 'auto');

        if ($mode == 'auto')
        {
            self::prepareInAuto($content, $item);
        }
        else
        {
            self::prepareInManual($content, $item);
        }

        // clean up, hide all leftover {{CTPR_PROMOTING_ITEM}} smart tags
        self::autoCleanup($content);
    }

    /**
     * Prepare items in auto mode
     * 
     * @param   string  $content
     * @param   object  $item
     * 
     * @return  void
     */
    public static function prepareInAuto(&$content, $item)
    {
        if (!$items = $item->get('meta.items', []))
        {
            return;
        }
        
        if (!$total_items = (int) $item->get('meta.total_items', 0))
        {
            return;
        }

        // todo: check for items that require a plugin to be active and remove them if their respective plugins are inactive
        if (!$rendered_promoting_items = self::getRenderedPromotingItems($items, $item))
        {
            return;
        }

        $replacement_element = $item->get('meta.publish_settings.replacement_element', 'div');

        // if its global, then fetch the global value
        if ($replacement_element == 'global')
        {
            $ctpr_settings = get_option('ctpr_settings_page_data');
            $replacement_element = isset($ctpr_settings['global_default_replacement_element']) ? $ctpr_settings['global_default_replacement_element'] : 'div';
        }

        $needle = '</' . $replacement_element . '>';

        $positions = self::getAllPositionsOfNeedleInHaystack($needle, $content);

        if (!count($positions))
        {
            return;
        }
        
        $total_ending_divs = count($positions);

        // check if we have set first item to appear on top and remove it from $total_items
        $first_item_at_start = $item->get('meta.first_item_at_start');
        $first_item_at_start = ($first_item_at_start == 'on');
        if ($first_item_at_start)
        {
            $total_items -= 1;

            // set first item at the start of the content
            $content = $rendered_promoting_items[0] . $content;
            
            unset($rendered_promoting_items[0]);
        }
        
        // check if we have set last item to appear on end and remove it from $total_items
        $last_item_at_end = $item->get('meta.last_item_at_end');
        $last_item_at_end = ($last_item_at_end == 'on');
        $last_item = null;
        if ($last_item_at_end)
        {
            // if $total_items == total amount of items, lower it by 1
            // if we have 3 total items, we cannot fetch key 3, we need to fetch key 2
            if ($total_items == count($rendered_promoting_items))
            {
                $last_item = $rendered_promoting_items[$total_items - 1];
            }
            else
            {
                $last_item = $rendered_promoting_items[$total_items];
            }
            

            unset($rendered_promoting_items[$total_items]);

            $total_items -= 1;
        }
        
        // reset array key values
        $rendered_promoting_items = array_values($rendered_promoting_items);

        $per_items = floor($total_ending_divs / ($total_items + 1));

        $current_pos = $per_items;

		if (!class_exists('DOMDocument') || !class_exists('DOMXPath'))
		{
			return;
        }

		libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $xp = new \DOMXPath($dom);

        for ($i = 0; $i < $total_items; $i++)
        {
            $pos = $current_pos;
        
            // get the promoting item HTML
            $promoting_item_html = isset($rendered_promoting_items[$i]) ? $rendered_promoting_items[$i] : '';

            // do not replace empty promoting items
            if (empty($promoting_item_html))
            {
                continue;
            }

            $nodes = $dom->getElementsByTagName($replacement_element);

            $newNode = $dom->createElement('div');

            self::appendHTMLToElement($newNode, $promoting_item_html);

            if (!$nodes->item($pos))
            {
                continue;
            }

            $nodes->item($pos)->parentNode->insertBefore($newNode->firstChild, $nodes->item($pos));

            $result = '';
            foreach ($dom->documentElement->childNodes as $childNode)
            {
                $result .= $dom->saveHTML($childNode);
            }
            $content = $result;

            // re-calculate positions
            $positions_new = self::getAllPositionsOfNeedleInHaystack($needle, $content);
            
            $new_pos_count = count($positions_new) - $pos;

            $current_pos += floor((2 * $new_pos_count) / ($total_items - $i));
        }
        
        // append last item at the end
        if ($last_item_at_end && $last_item)
        {
           $content .= $last_item;
        }
    }

    /**
     * @param DOMNode $newnode Node to insert next to $ref
     * @param DOMNode $ref Reference node
     * @requires $ref has a parent node
     * @return DOMNode the real node inserted
     */
    private static function appendSibling(\DOMNode $newnode, \DOMNode $ref)
    {
        if ($ref->nextSibling) {
            // $ref has an immediate brother : insert newnode before this one
            return $ref->parentNode->insertBefore($newnode, $ref->nextSibling);
        } else {
            // $ref has no brother next to him : insert newnode as last child of his parent
            return $ref->parentNode->appendChild($newnode);
        }
    }

    public static function autoCleanup(&$content)
    {
        $content = str_replace(self::smart_tag, '', $content);
    }

    /**
     * Prepare items in manual mode
     * 
     * @param   string  $content
     * @param   object  $item
     * 
     * @return  void
     */
    public static function prepareInManual(&$content, $item)
    {
        if (!$items = $item->get('meta.items', []))
        {
            return;
        }
        
        if (!$total_items = (int) $item->get('meta.total_items', 0))
        {
            return;
        }

        // todo: check for items that require a plugin to be active and remove them if their respective plugins are inactive
        if (!$rendered_promoting_items = self::getRenderedPromotingItems($items, $item))
        {
            return;
        }

        if (!$smart_tag_positions = self::strpos_all($content, self::smart_tag))
        {
            return;
        }

        // replace first X smart tags
        for ($i = 0; $i < $total_items; $i++)
        {
            $content = substr_replace($content, $rendered_promoting_items[$i], $smart_tag_positions[0], strlen(self::smart_tag));

            if (!$smart_tag_positions = self::strpos_all($content, self::smart_tag))
            {
                break;
            }
        }

        // remove all other smart tags
        $content = str_replace(self::smart_tag, '', $content);
    }

    /**
     * Return an array of positions of substring in a string
     * 
     * @param   string   $haystack
     * @param   string   $needle
     * 
     * @return  array
     */
    public static function strpos_all($haystack, $needle) {
        $offset = 0;
        $allpos = array();
        while (($pos = strpos($haystack, $needle, $offset)) !== FALSE)
        {
            $offset   = $pos + 1;
            $allpos[] = $pos;
        }
        return $allpos;
    }

    /**
     * Append HTML to an element
     * 
     * @param   object  $parent
     * @param   string  $source
     * 
     * @return  void
     */
    private static function appendHTMLToElement(&$parent, $source) {
        $tmpDoc = new \DOMDocument();
        $tmpDoc->loadHTML($source);
        foreach ($tmpDoc->getElementsByTagName('body')->item(0)->childNodes as $node)
        {
            $node = $parent->ownerDocument->importNode($node, true);
            $parent->appendChild($node);
        }
    }

    /**
     * Returns all HTML of promoting items
     * 
     * @param   array  $items
     * @param   array  $promoting_item
     * 
     * @return  array
     */
    public static function getRenderedPromotingItems($items, $promoting_item)
    {
        if (!$items || !count((array) $items) || !$promoting_item)
        {
            return [];
        }

        $rendered_items = [];
        
        foreach ($items as $key => $item)
        {
            $item = new Registry($item);
            $rendered_items[] = \ContentPromoter\Core\PromotingContents::render($item->get('fields', []), $item->get('type', ''), $promoting_item->get('meta.promoting_content_id'));
        }

        return $rendered_items;
    }

    /**
     * Find all positions of needle in haystack
     * 
     * @param   string   $needle
     * @param   string   $haystack
     * 
     * @return  array
     */
    public static function getAllPositionsOfNeedleInHaystack($needle, $haystack)
    {
        if (!$needle || !$haystack)
        {
            return [];
        }

        if (!is_string($needle))
        {
            return [];
        }

        if (!is_string($haystack))
        {
            return [];
        }
        
        
        $lastPos = 0;
        $positions = [];

        while (($lastPos = strpos($haystack, $needle, $lastPos))!== false)
        {
            $positions[] = $lastPos;
            $lastPos = $lastPos + strlen($needle);
        }

        return $positions;
    }
}