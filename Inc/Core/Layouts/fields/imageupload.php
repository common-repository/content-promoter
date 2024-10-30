<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$value = isset($data['value']) ? $data['value'] : '';
?>
<div class="ctpr-image-upload-wrapper">
    <div class="buttons">
        <a href="#" class="ctpr-image-upload-browse ctpr-button"><?php echo esc_html(contentpromoter()->_('CP_UPLOAD_IMAGE')); ?></a>
        <a href="#" class="ctpr-image-upload-reset ctpr-button"><?php echo esc_html(contentpromoter()->_('CP_RESET')); ?></a>
    </div>
    <div class="ctpr-image-upload-preview<?php echo (!empty($value)) ? ' is-visible' : ''; ?>">
        <img src="<?php echo esc_url($value); ?>" alt="preview image" />
    </div>
    <input type="hidden" value="<?php echo esc_url($value); ?>" name="<?php echo esc_attr($data['name']); ?>" />
</div>