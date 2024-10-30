<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$type = $this->data->get('type', '');
?>
<div class="ctpr-publish-settings-item<?php echo (!empty($type) && $type != 'none') ? ' ' . esc_attr($type) : ''; ?>">
    <div class="type-selector-box">
        <?php echo $this->data->get('type_selector'); ?>
    </div>
    <div class="item-content">
        <?php echo $this->data->get('content'); ?>
    </div>
</div>