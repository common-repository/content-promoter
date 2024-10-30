<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$page = $this->data->get('page', 'dashboard');
?>
<div class="ctpr-admin-page-wrapper">
    <div class="ctpr-page-sidebar">
        <h2 class="title"><?php echo esc_html(contentpromoter()->_('CP_PLUGIN_NAME')); ?></h2>
        <ul class="navbar">
            <li<?php echo $page == 'dashboard' ? ' class="is-active"' : ''; ?>><a href="<?php echo admin_url('admin.php?page=content-promoter') ?>"><span class="icon dashicons dashicons-screenoptions"></span><span class="title"><?php echo esc_html(contentpromoter()->_('CP_DASHBOARD')); ?></span></a></li>
            <li><a href="<?php echo admin_url('post-new.php?post_type=content-promoter'); ?>"><span class="icon dashicons dashicons-welcome-add-page"></span><span class="title"><?php echo esc_html(contentpromoter()->_('CP_NEW_ITEM')); ?></span></a></li>
            <li><a href="<?php echo admin_url('edit.php?post_type=content-promoter'); ?>"><span class="icon dashicons dashicons-welcome-write-blog"></span><span class="title"><?php echo esc_html(contentpromoter()->_('CP_ITEMS')); ?></span></a></li>
            <li class="bottom-border<?php echo $page == 'settings' ? ' is-active' : ''; ?>"><a href="<?php echo admin_url('admin.php?page=content-promoter-settings') ?>"><span class="icon dashicons dashicons-admin-generic"></span><span class="title"><?php echo esc_html(contentpromoter()->_('CP_SETTINGS')); ?></span></a></li>
            <li class="bottom-border<?php echo $page == 'getting-started' ? ' is-active' : ''; ?>"><a href="<?php echo admin_url('admin.php?page=content-promoter-getting-started') ?>"><span class="icon dashicons dashicons-welcome-add-page"></span><span class="title"><?php echo esc_html(contentpromoter()->_('CP_GETTING_STARTED')); ?></span></a></li>
            <li><a href="<?php echo esc_url(CTPR_DOC_URL); ?>" target="_blank"><span class="icon dashicons dashicons-editor-help"></span><span class="title"><?php echo esc_html(contentpromoter()->_('CP_DOCUMENTATION')); ?></span></a></li>
            <li><a href="<?php echo esc_url(CTPR_SUPPORT_URL); ?>" target="_blank"><span class="icon dashicons dashicons-megaphone"></span><span class="title"><?php echo esc_html(contentpromoter()->_('CP_SUPPORT')); ?></span></a></li>
        </ul>
        <div class="bottom">
            <?php  ?>
            <div class="item upgrade">
                <span class="dashicons dashicons-arrow-right-alt icon"></span>
                <span class="title"><?php echo esc_html(contentpromoter()->_('CP_UPGRADE_TO_PRO_SIDEBAR_TEXT')); ?></span>
                <a href="<?php echo esc_url(CTPR_UPGRADE_URL); ?>" class="ctpr-button pro" target="_blank"><?php echo esc_html(contentpromoter()->_('CP_UPGRADE_TO_PRO')); ?></a>
                <a href="<?php echo esc_url(CTPR_UPGRADE_READ_MORE_URL); ?>" class="text">
                    <?php echo esc_html(contentpromoter()->_('CP_READ_MORE')); ?>
                </a>
            </div>
            <?php  ?>
            <div class="item version"><?php echo esc_html(contentpromoter()->_('CP_VERSION') . ' ' . CTPR_VERSION); ?></div>
        </div>
    </div>