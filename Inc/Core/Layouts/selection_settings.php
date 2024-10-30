<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

$first_item_at_start = $last_item_at_end = '';


?>
<!-- Settings -->
<div class="settings">
    <?php
    
    
    ?>
    <div class="setting">
        <label class="text"><?php echo wp_kses(contentpromoter()->_('CP_WIZARD_FIRST_ITEM_START'), ['strong' => []]); ?></label>
        <a href="#" class="ctpr-button pro" data-ctpr-pro-feature="<?php echo esc_attr(strip_tags(contentpromoter()->_('CP_WIZARD_FIRST_ITEM_START'))); ?>"><span class="icon dashicons dashicons-lock"></span><?php echo esc_html(contentpromoter()->_('CP_UNLOCK_PRO_FEATURE')); ?></a>
    </div>
    <div class="setting">
        <label class="text"><?php echo wp_kses(contentpromoter()->_('CP_WIZARD_LAST_ITEM_END'), ['strong' => []]); ?></label>
        <a href="#" class="ctpr-button pro" data-ctpr-pro-feature="<?php echo esc_attr(strip_tags(contentpromoter()->_('CP_WIZARD_LAST_ITEM_END'))); ?>"><span class="icon dashicons dashicons-lock"></span><?php echo esc_html(contentpromoter()->_('CP_UNLOCK_PRO_FEATURE')); ?></a>
    </div>
    <?php
    
    ?>
</div>
<!-- /Settings -->