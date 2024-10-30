<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$image = $this->data->get('image.value', '');
if (empty($image))
{
    return;
}

$promoting_content_id = $this->data->get('promoting_content_id', '');
$image_fullwidth = $this->data->get('image_fullwidth.value', 'auto');
$image_link = $this->data->get('image_link.value', '');
$title = $this->data->get('title.value', '');
$description = $this->data->get('description.value', '');
$open_in = $this->data->get('open_in.value', 'self');

$img_class = '';
$image_lightbox = 'disabled';
$text_align = 'left';
$title_position = $description_position = 'below';


?>
<div class="ctpr-item-<?php echo esc_attr($promoting_content_id); ?> ctpr-promoting-item image<?php echo !empty($image_fullwidth) ? ' ' . esc_attr($image_fullwidth) : ''; ?>">
    <div class="ctpr-promoting-item-inner">
        <?php
        
        ?>
        <?php if (!empty($image_link) && $image_lightbox == 'disabled'): ?>
        <a href="<?php echo esc_attr($image_link); ?>" target="<?php echo esc_attr($open_in); ?>">
        <?php endif; ?>
            <img src="<?php echo esc_url($image); ?>"<?php echo $img_class; ?> alt="<?php echo esc_attr($image); ?>" />
        <?php if (!empty($image_link) && $image_lightbox == 'disabled'): ?>
        </a>
        <?php endif; ?>
        <?php if ($title_position == 'below' || $description_position == 'below'): ?>
            <div class="ctpr-meta bottom<?php echo esc_attr($text_align); ?>">
            <?php if ($title_position == 'below'): ?>
                <h3 class="ctpr-title<?php echo ($description_position != 'below') ? ' ctpr-m-b-0' : ''; ?>"><?php echo esc_html($title); ?></h3>
            <?php endif; ?>
            <?php if ($description_position == 'below'): ?>
                <p class="ctpr-description"><?php echo esc_html($description); ?></p>
            <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>