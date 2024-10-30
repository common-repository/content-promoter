<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

use \ContentPromoter\Core\Validator;

class Metabox {
    /**
     * THe metabox prefix
     * 
     * @var  String
     */
    public static $prefix = 'ctpr_meta_settings';

    /**
     * Get parameter for the error box error code
     */
    const GET_METABOX_ERROR_PARAM = 'ctpr-meta-error';

    public function __construct()
    {
        add_action('save_post', [$this, 'save_meta']);
        add_action('add_meta_boxes', [$this, 'add_meta_box']);

        // notices for metabox
        add_action('edit_form_top', [$this, 'adminNotices']);
    }

    /**
     * Metabox admin notices
     * 
     * @return  void
     */
    public function adminNotices()
    {
        if (isset($_GET[self::GET_METABOX_ERROR_PARAM]))
        {
            $screen = get_current_screen();
            // Make sure we are in the proper post type
            if (in_array($screen->post_type, ['content-promoter']))
            {
                $errorCode = (int) $_GET[self::GET_METABOX_ERROR_PARAM];
                switch($errorCode) {
                    // INVALID CSS
                    case 1:
                        $this->_showAdminNotice( __('Custom CSS entered is invalid.', 'text_domain') );
                        break;
                }
            }
        }
    }

    /**
     * Shows the admin notice for the metabox
     * 
     * @param   string  $message
     * @param   string  $type
     * 
     * @return  void
     */
    private function _showAdminNotice($message, $type='error') {
        ?><div class="<?php esc_attr_e($type); ?>"><p><?php esc_html_e($message); ?></p></div><?php
    }

    /**
     * Saves the metabox meta settings
     * 
     * @param   int  $post_id
     * 
     * @return  void
     */
    public function save_meta($post_id)
    {
        if (!current_user_can('edit_post', $post_id))
        {
            return;
        }

        $fields = isset($_POST[self::$prefix]) ? wp_unslash($_POST[self::$prefix]) : [];

		if (empty($fields))
		{
			return;
        }

        if (!isset($fields['items']))
        {
            return;
        }
        
        // remove template item
        if (isset($fields['items']['ITEM_ID']))
        {
            unset($fields['items']['ITEM_ID']);
        }

        // remove items that do not have a type(i.e. not selected any promoting content type)
        foreach ($fields['items'] as $key => $value)
        {
            if (isset($value['fields']) && isset($value['fields'][0]))
            {
                unset($fields['items'][$key]);
            }
        }

        $errors = Validator::getInstance()->run($fields);

        if ($errors)
        {
            add_filter('redirect_post_location', function($loc) {
                return add_query_arg( self::GET_METABOX_ERROR_PARAM, 1, $loc );
            });
            return $post_id; // make sure to return so we don't allow further processing
        }

		update_post_meta($post_id, self::$prefix, $fields);
    }

    /**
     * Adds the metabox section to the CPT
     * 
     * @return  void
     */
    public function add_meta_box()
    {
        add_meta_box(
            'ctpr-metabox',
            contentpromoter()->_('CP_METABOX_SETTINGS_TITLE'),
            [$this, 'metabox_callback'],
            'content-promoter'
        );
    }

    /**
     * Renders the metabox content
     * 
     * @return  void
     */
    public function metabox_callback()
    {
        $data = Item::getItemData(get_the_ID());

        contentpromoter()->renderer->render('metabox/tmpl', $data);
    }
}