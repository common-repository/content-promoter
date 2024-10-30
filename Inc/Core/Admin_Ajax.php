<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

class Admin_Ajax
{
    /**
     * Returns the content for the new type selected
     * 
     * @return  string
     */
    public function setupChangePromotingItemType()
    {
		if (!current_user_can('administrator'))
		{
			return;
        }

        $nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';
        
        // verify nonce
        if (!$verify = wp_verify_nonce($nonce, 'ctpr_js_nonce'))
        {
            return false;
        }

        $item_id = isset($_POST['item_id']) ? sanitize_text_field($_POST['item_id']) : 1;
        $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : 'text';

        $error = false;
        $response = '';
        
        $class = '\ContentPromoter\Core\Types\\' . str_replace('_', '', $type);

        if (class_exists($class))
        {
            $payload = [
                'item_id' => $item_id,
                'type' => $type
            ];
            
            $object = new $class($payload);

            $response = $object->render();
        }
        else
        {
            $error = true;
            $type = ucfirst($type);
            $type = str_replace('_', ' ', $type);
            $response = sprintf(contentpromoter()->_('CP_TYPE_DOES_NOT_EXIST'), $type);
        }

        echo json_encode([
            'data' => $response,
            'error' => $error
        ]);
        wp_die();
    }

    /**
     * Search for WP Items and return data based on a query
     * 
     * @return  string
     */
    public function getWPItemSelectorData()
    {
        if (!current_user_can('administrator'))
		{
			return;
        }

        $nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';
        
        // verify nonce
        if (!$verify = wp_verify_nonce($nonce, 'ctpr_js_nonce'))
        {
            return false;
        }

        $q = isset($_POST['q']) ? sanitize_text_field($_POST['q']) : '';
        $post_type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : 'post';
        $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $no_ids = isset($_POST['no_ids']) && !empty($_POST['no_ids']) ? sanitize_text_field($_POST['no_ids']) : [];
        if (!empty($no_ids))
        {
            $no_ids = array_map('strval', explode(',', $no_ids));
            $no_ids = array_unique($no_ids);
        }

        $error = false;
        $response = '';

        if (empty($q) || empty($name) || !in_array($post_type, Fields\WPItemSelector::$types))
        {
            $error = true;
            $response = contentpromoter()->renderer->render('ajax/wpitemselector_result_item', ['label' => contentpromoter()->_('CP_NO_RESULTS_FOUND')], true);
        }
        else
        {
            $data = [];
            
            $class = '\ContentPromoter\Core\Helpers\\' . Helpers\WPHelper::getHelperClassName($post_type) . 'Helper';
            
            if (!class_exists($class))
            {
                $error = true;
            }

            // parse the post type
            $post_type = Helpers\WPHelper::parsePostType($post_type);

            if (!$data = $class::searchItems($q, $no_ids, $post_type))
            {
                $error = true;
            }

            if ($error)
            {
                $response = contentpromoter()->renderer->render('ajax/wpitemselector_result_item', ['label' => contentpromoter()->_('CP_NO_RESULTS_FOUND')], true);
            }

            if (count($data))
            {
                $parsedData = Helpers\WPHelper::parseData($data, $post_type);

                foreach ($parsedData as $key => $item)
                {
                    $item['name'] = $name;
                    $response .= contentpromoter()->renderer->render('ajax/wpitemselector_result_item', $item, true);
                }
            }
        }

        echo json_encode([
            'data' => $response,
            'error' => $error
        ]);
        wp_die();
    }
}