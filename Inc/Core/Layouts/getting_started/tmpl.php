<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
?>
<?php echo contentpromoter()->renderer->render('template/sidebar', ['page' => 'getting-started']); ?>
<?php echo contentpromoter()->renderer->render('template/content.start'); ?>
<?php echo contentpromoter()->renderer->render('getting_started/content'); ?>
<?php echo contentpromoter()->renderer->render('template/content.end'); ?>