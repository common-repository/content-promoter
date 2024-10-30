<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$name = isset($data['name']) ? $data['name'] : '';
$label = isset($data['label']) ? $data['label'] : '';
$id = isset($data['id']) ? $data['id'] : '';
$lang = isset($data['lang']) ? $data['lang'] : '';
?>
<div class="item"<?php echo (!empty($id)) ? ' data-id="' . esc_attr($id) . '"' : ''; ?>>
    <?php echo esc_html($label); ?>
    <?php if (!empty($lang)) { ?>
    <?php echo \ContentPromoter\Core\Helpers\WPHelper::getWPMLFlagUrlFromCode($lang); ?>
    <?php } ?>
    <?php if (!empty($name)) { ?>
        <input type="hidden" value="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($name); ?>[]" />
        <a href="#" class="dashicons dashicons-no-alt ctpr-wp-item-selector-remove-selected-item"></a>
    <?php } ?>
</div>