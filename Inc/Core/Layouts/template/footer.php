<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
?>
<div class="ctpr-page-footer">
    <img class="logo" src="<?php echo esc_url(CTPR_ADMIN_MEDIA_URL . 'img/logo.svg'); ?>" alt="content promoter feataholic logo">
    <p class="line"><?php echo html_entity_decode(contentpromoter()->_('CP_MADE_BY_FEATAHOLIC')); ?></p>    
    <ul class="ctpr-footer-nav">
        <?php
        
        ?>
            <li><a href="https://www.feataholic.com/wordpress-plugins/content-promoter/" target="_blank"><?php echo esc_html(contentpromoter()->_('CP_GET_PRO_FEATURES')); ?></a></li>
        <?php
        
        ?>
		<li><a href="https://www.feataholic.com/wordpress-plugins/content-promoter/roadmap/" target="_blank"><?php echo esc_html(contentpromoter()->_('CP_ROADMAP')); ?></a></li>
		<li><a href="https://www.feataholic.com/contact/" target="_blank"><?php echo esc_html(contentpromoter()->_('CP_SUPPORT')); ?></a></li>
		<li><a href="https://www.feataholic.com/docs/content-promoter/" target="_blank"><?php echo esc_html(contentpromoter()->_('CP_DOCS')); ?></a></li>
		<li><a href="https://www.feataholic.com/terms-of-use/" target="_blank"><?php echo esc_html(contentpromoter()->_('CP_TERMS_OF_USE')); ?></a></li>
		<li><a href="https://www.feataholic.com/privacy-policy/" target="_blank"><?php echo esc_html(contentpromoter()->_('CP_PRIVACY_POLICY')); ?></a></li>
	</ul>
    <ul class="ctpr-footer-social">
        <li>
            <a href="https://www.facebook.com/feataholic" target="_blank">
                <span class="dashicons dashicons-facebook-alt"></span>
            </a>
        </li>
        <li>
            <a href="https://twitter.com/feataholic" target="_blank">
                <span class="dashicons dashicons-twitter"></span>
            </a>
        </li>
    </ul>
</div>