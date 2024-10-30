<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$settings = $this->data->get('settings', []);
$settings = new \ContentPromoter\Core\Libs\Registry($settings);

$keep_data_on_uninstall = (bool) $settings->get('keep_data_on_uninstall', '');
$global_replacement_elem = $settings->get('global_default_replacement_element', 'div');

$allowed_tags = [
    'img' => [
        'draggable' => true,
        'role' => true,
        'class' => true,
        'alt' => true,
        'src' => true
    ],
    'strong' => [
        'class' => true
    ]
];


$license_status = 'invalid';
$status = 'You\'re using Content Promoter Free - No license needed. Enjoy! <img draggable="false" role="img" class="emoji" alt="🙂" src="https://s.w.org/images/core/emoji/13.0.0/svg/1f642.svg">';
$license_key = '';



$allowed_actions = [
    'general',
    'license'
];
$action = isset($_GET['action']) && in_array($_GET['action'], $allowed_actions) ? sanitize_text_field($_GET['action']) : 'general';
?>
<div class="ctpr-tabs">
    <ul class="tabs-menu">
        <li class="<?php echo $action == 'general' ? 'active' : ''; ?>">
            <a href="<?php echo admin_url('admin.php?page=content-promoter-settings&action=general') ?>"><?php echo contentpromoter()->_('CP_GENERAL'); ?></a>
        </li>
        <li class="<?php echo $action == 'license' ? 'active' : ''; ?>">
            <a href="<?php echo admin_url('admin.php?page=content-promoter-settings&action=license') ?>"><?php echo contentpromoter()->_('CP_LICENSE'); ?></a>
        </li>
    </ul>
    <div class="tabs-content">
        <div class="tab <?php echo $action == 'general' ? 'active' : ''; ?>">
            <table class="form-table">
                <tr>
                    <th><label for="keep_data_on_uninstall"><?php echo contentpromoter()->_('CP_KEEP_DATA_ON_UNINSTALL'); ?></label></th>
                    <td>
                        <input id="keep_data_on_uninstall" name="ctpr_settings_page_data[keep_data_on_uninstall]" type="checkbox"<?php echo ($keep_data_on_uninstall) ? ' checked="checked"' : ''; ?> value="true" />
                        <p class="description">
                            <?php echo contentpromoter()->_('CP_KEEP_DATA_ON_UNINSTALL_DESC'); ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th><label for="global_default_replacement_element"><?php echo contentpromoter()->_('CP_GLOBAL_DEFAULT_REPLACEMENT_ELEMENT'); ?></label></th>
                    <td>
                        <select name="ctpr_settings_page_data[global_default_replacement_element]" id="global_default_replacement_element">
                            <option value="div"<?php echo ($global_replacement_elem == 'div') ? 'selected="selected"' : ''; ?>><?php echo contentpromoter()->_('CP_DIV'); ?></option>
                            <option value="span"<?php echo ($global_replacement_elem == 'span') ? 'selected="selected"' : ''; ?>><?php echo contentpromoter()->_('CP_SPAN'); ?></option>
                            <option value="p"<?php echo ($global_replacement_elem == 'p') ? 'selected="selected"' : ''; ?>><?php echo contentpromoter()->_('CP_P'); ?></option>
                            <?php
                            
                            ?>
                        </select>
                        <p class="description">
                            <?php echo contentpromoter()->_('CP_GLOBAL_DEFAULT_REPLACEMENT_ELEMENT_DESC'); ?>
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="tab <?php echo $action == 'license' ? 'active' : ''; ?>">
            <?php
            ?>
            <table class="form-table">
                <tr>
                    <th><label for="license_key"><?php echo contentpromoter()->_('CP_LICENSE_KEY'); ?></label></th>
                    <td>
                        <?php
                        
                        echo '<div class="license-key-pro-promo">' . \ContentPromoter\Core\Helpers\HTML::renderProButton([
                            'label' => 'CP_LICENSE_KEY'
                        ]) . '</div>';
                        
                        ?>
                        <div class="ctpr-field-control-group">
                            <div class="control">
                                <input id="license_key" class="input-large" placeholder="<?php echo esc_attr(contentpromoter()->_('CP_ENTER_LICENSE_KEY')); ?>" name="ctpr_settings_page_data[license_key]" type="text" value="<?php echo esc_attr($license_key); ?>" />
                                <p class="description">
                                    <?php echo contentpromoter()->_('CP_LICENSE_KEY_DESC'); ?>
                                </p>
                                <div class="license-status-wrapper">
                                    <?php
                                    wp_nonce_field( 'ctpr_settings_page_nonce', 'ctpr_settings_page_nonce' );
                                    
                                    ?>
                                    <div class="license-status">
                                        <div class="label"><?php echo esc_html(contentpromoter()->_('CP_STATUS')); ?>:</div>
                                        <div class="status"><?php echo wp_kses($status, $allowed_tags); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>