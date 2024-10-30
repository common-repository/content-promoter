<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
?>
<div class="ctpr-publish-settings-wrapper">
    <div class="select-desc"><?php echo esc_html(contentpromoter()->_('CP_PUBLISH_SETTINGS')); ?></div>
    <div class="content">
        <?php echo $this->data->get('content'); ?>
    </div>
</div>