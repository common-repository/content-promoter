<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
?>
<!-- Content Promoter Previewer Navigator -->
<div class="ctpr-previewer-navigator">
    <h4 class="title"><?php echo contentpromoter()->_('CP_NAVIGATE_PROMOTING_ITEMS'); ?></h4>
    <div class="items">
        <?php
        if ($items = $this->data->get('items', []))
        {
            foreach ($items as $key => $item)
            {
                ?>
                <div class="ctpr-previewer-navigator-item">
                    <i class="dashicons dashicons-arrow-right"></i>
                    <span class="title"><?php echo esc_html($item['title']); ?></span>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>
<!-- /Content Promoter Previewer Navigator -->
<!-- Content Promoter Previewer Navigator Template -->
<div class="ctpr-previewer-navigator-item template">
    <i class="dashicons dashicons-arrow-right"></i>
    <span class="title"><?php echo contentpromoter()->_('CP_PROMOTING_CONTENT'); ?></span>
</div>
<!-- /Content Promoter Previewer Navigator Template -->