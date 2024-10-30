<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$total_items = isset($data['total_items']) ? $data['total_items'] : 1;
?>
<div class="ctpr-wizard">
    <!-- Wizard Pages -->
    <div class="wizard-pages">
        <div class="page is-active" data-page="selection">
            <div class="select-desc"><?php echo esc_html(contentpromoter()->_('CP_SELECT_CONTENT_ITEM')); ?></div>
            <!-- Selector -->
            <div class="selector">
                <input type="range" min="1" max="<?php echo esc_attr(contentpromoter()->container['Wizard']->getTotalItems()); ?>" value="<?php echo esc_attr($total_items); ?>" name="ctpr_meta_settings[total_items]" class="ctpr-promoting-content-items-selector" />
                <div class="ctpr-promoting-content-items-number"><?php echo esc_attr($total_items); ?></div>
            </div>
            <!-- /Selector -->
            <?php contentpromoter()->renderer->render('selection_settings', $data); ?>
        </div>
        <div class="page" data-page="configure">
            <div class="select-desc"><?php echo esc_html(contentpromoter()->_('CP_CONFIGURE_ITEMS')); ?></div>
            <?php contentpromoter()->renderer->render('configure_screen', $data); ?>
        </div>
        <div class="page" data-page="publish">
            <?php contentpromoter()->container['PublishSettings']->render(); ?>
        </div>
    </div>
    <!-- /Wizard Pages -->
    <!-- Wizard Actions -->
    <div class="wizard-actions">
        <button class="ctpr-button step-button is-disabled" data-button="prev" data-page="selection"><?php echo esc_html(contentpromoter()->_('CP_SELECTION')); ?></button>
        <ul class="wizard-nav">
            <li class="is-active" data-page="selection"></li>
            <li data-page="configure"></li>
            <li data-page="publish"></li>
        </ul>
        <button class="ctpr-button step-button" data-button="next" data-page="configure"><?php echo esc_html(contentpromoter()->_('CP_CONFIGURE')); ?></button>
    </div>
    <!-- /Wizard Actions -->
</div>