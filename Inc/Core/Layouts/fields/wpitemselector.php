<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$name = isset($data['name']) ? $data['name'] : '';
$items = isset($data['items']) ? $data['items'] : [];
$item_type = isset($data['item_type']) ? $data['item_type'] : 'post';
$parsed_item_type = \ContentPromoter\Core\Helpers\ItemHelper::parseItemTypeForPlaceholder($item_type);

if (empty($name))
{
    return;
}
?>
<div class="ctpr-wp-item-selector-wrapper">
    <div class="input">
        <div class="ctpr-item-loader"></div>
        <input type="text" id="<?php echo esc_attr($name); ?>" data-name="<?php echo esc_attr($name); ?>" placeholder="<?php echo esc_attr(sprintf(contentpromoter()->_('CP_START_SEARCHING_WP_ITEM'), contentpromoter()->_($parsed_item_type))); ?>" class="ctpr-wp-item-selector-input" data-type="<?php echo esc_attr($item_type); ?>" />
        <div class="ctpr-wp-item-selector-results"></div>
    </div>
    <div class="selected-items<?php echo count($items) ? ' is-visible' : ''; ?>">
    <?php
    foreach ($items as $key => $item)
    {
        $item['name'] = $name;
        contentpromoter()->renderer->render('ajax/wpitemselector_result_item', (array) $item);
    }
    ?>
    </div>
</div>