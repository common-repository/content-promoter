<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
?>
<div class="ctpr-pro-modal-wrapper">
    <div class="ctpr-pro-modal">
        <a href="#" class="ctpr-pro-modal-close dashicons dashicons-no-alt"></a>
        <div class="top">
            <span class="icon dashicons dashicons-lock"></span>
            <h3 class="title"><?php echo esc_html(contentpromoter()->_('CP_PRO_MODAL_POPUP')); ?></h3>
        </div>
        <div class="main">
            <div class="item"><span class="feature-name"></span> <?php echo esc_html(contentpromoter()->_('CP_PRO_MODAL_IS_A_PRO_FEATURE')); ?></div>
            <div class="item"><?php echo esc_html(contentpromoter()->_('CP_PRO_MODAL_UPGRADE_MSG')); ?></div>
        </div>
        <div class="upgrade-button">
            <a href="<?php echo esc_url(CTPR_UPGRADE_URL); ?>" class="ctpr-button large pro"><?php echo esc_html(contentpromoter()->_('CP_UPGRADE_TO_PRO')); ?></a>
        </div>
        <div class="offer"><?php echo wp_kses(contentpromoter()->_('CP_PRO_MODAL_OFFER'), ['span' => true, 'br' => true]); ?></div>
        <div class="bot">
            <a href="<?php echo esc_url(CTPR_UPGRADE_READ_MORE_URL); ?>"><?php echo esc_html(contentpromoter()->_('CP_VIEW_ALL_FEATURES')); ?></a>
        </div>
    </div>
</div>