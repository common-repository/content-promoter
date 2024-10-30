<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$name = $this->data->get('name');
$version = $this->data->get('version');
?>
<div class="ctpr-update-notice-wrapper">
	<div class="update-notice">
		<div class="title"><?php echo esc_html(sprintf(contentpromoter()->_('CP_VERSION_X_IS_AVAILABLE'), $name . ' ' . $version)); ?></div>
		<div class="subtitle"><?php echo esc_html(sprintf(contentpromoter()->_('CP_YOUR_CURRENT_VERSION_IS_X'), CTPR_VERSION)); ?> <a href="<?php echo esc_url(CTPR_CHANGELOG_URL); ?>" target="_blank" title="<?php echo esc_attr(contentpromoter()->_('CP_VIEW_CHANGELOG')); ?>"><?php echo esc_html(contentpromoter()->_('CP_VIEW_CHANGELOG')); ?></a></div>
		<a href="<?php echo admin_url('plugins.php'); ?>" class="ctpr-button small green" title="<?php echo esc_attr(contentpromoter()->_('CP_UPDATE')); ?>"><i class="icon dashicons dashicons-download"></i><?php echo esc_html(contentpromoter()->_('CP_UPDATE')); ?></a>
	</div>
</div>