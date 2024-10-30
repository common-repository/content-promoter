<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$items = $this->data->get('items');
?>
<?php echo contentpromoter()->renderer->render('template/sidebar', ['page' => 'dashboard']); ?>
<?php echo contentpromoter()->renderer->render('template/content.start'); ?>
<?php echo contentpromoter()->renderer->render('dashboard/content', ['items' => $items]); ?>
<?php echo contentpromoter()->renderer->render('template/content.end'); ?>