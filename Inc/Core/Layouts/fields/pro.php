<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$label = isset($data['label']) ? $data['label'] : '';
?>
<a href="<?php echo esc_url(CTPR_UPGRADE_URL); ?>" class="ctpr-button pro" data-ctpr-pro-feature="<?php echo esc_attr(contentpromoter()->_($label)); ?>"><span class="icon dashicons dashicons-lock"></span><?php echo esc_html(contentpromoter()->_('CP_UNLOCK_PRO_FEATURE')); ?></a>