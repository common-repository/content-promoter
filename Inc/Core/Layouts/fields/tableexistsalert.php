<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$exists = isset($data['exists']) ? $data['exists'] : '';
if ($exists)
{
    return;
}

$title = isset($data['title']) ? $data['title'] : '';
if (!$title)
{
    return;
}
$plugin_title = isset($data['plugin_title']) ? $data['plugin_title'] : '';
?>
<div class="ctpr-alert danger">
    <?php echo wp_kses(sprintf(contentpromoter()->_($title), contentpromoter()->_($plugin_title), contentpromoter()->_($plugin_title)), ['strong' => []]); ?>
</div>