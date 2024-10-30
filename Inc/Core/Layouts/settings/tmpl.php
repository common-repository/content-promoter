<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
?>
<?php echo contentpromoter()->renderer->render('template/sidebar', ['page' => 'settings']); ?>
<?php echo contentpromoter()->renderer->render('template/content.start'); ?>
<div class="ctpr-settings-page">
    <form method="post" action="options.php">
        <?php
            settings_fields( 'contentpromoter_settings_page' );
            do_action('contentpromoter/settings_page');
        ?>
        <div class="ctpr-settings-actions">
            <?php submit_button(); ?>
        </div>
    </form>
</div>
<?php echo contentpromoter()->renderer->render('template/content.end'); ?>