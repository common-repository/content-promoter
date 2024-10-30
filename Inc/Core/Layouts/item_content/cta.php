<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

$promoting_content_id = $this->data->get('promoting_content_id', '');
$title_element = $this->data->get('title_element.value', 'h2');
$title = $this->data->get('title.value', '');
$title_font_size = $this->data->get('title_font_size.value', 36);
$subtitle = $this->data->get('subtitle.value', '');
$subtitle_font_size = $this->data->get('subtitle_font_size.value', 16);
$width = $this->data->get('width.value', 'auto');
$width_fixed = $this->data->get('width_fixed.value', '');
$button_enable = $this->data->get('button_enable.value', 'no');
$button_label = $this->data->get('button_label.value', '');
$button_classes = $this->data->get('button_classes.value', '');
$button_link = $this->data->get('button_link.value', '');
$text_color = $this->data->get('text_color.value', '#fff');
$button_text_color = $this->data->get('button_text_color.value', '#fff');
$button_background_color = $this->data->get('button_bg_color.value', '#3994ff');
$border_enable = $this->data->get('border_enable.value', 'no');
$border_color = $this->data->get('border_color.value', '#dedede');
$background_color = $this->data->get('background_color.value', '');
$padding = $this->data->get('padding.value', '30px');
$open_in = $this->data->get('open_in.value', '_self');

$btnStyles[] = 'color: ' . esc_attr($button_text_color) . ';';
$btnStyles[] = 'background-color: ' . esc_attr($button_background_color) . ';';
$btnStyleAtt = count($btnStyles) ? ' style="' . implode('', $btnStyles) . '"' : '';

$borderAtt = $border_enable == 'yes' ? ' border: 1px solid ' . esc_attr($border_color) . ';' : '';
$bgAtt = !empty($background_color) ? ' background: ' . esc_attr($background_color) . ';' : '';
$paddingAtt = !empty($padding) ? ' padding: ' . esc_attr($padding) . ';' : '';
?>
<div class="ctpr-item-<?php echo esc_attr($promoting_content_id); ?> ctpr-promoting-item cta" style="color: <?php echo esc_attr($text_color); ?>;<?php echo ($width == 'fixed' ? 'width:' . esc_attr($width_fixed) . 'px;' : '') . $borderAtt . $bgAtt . $paddingAtt; ?>">
    <div class="text">
        <<?php echo esc_attr($title_element) ?> class="title" style="font-size:<?php echo esc_attr($title_font_size); ?>px;line-height:<?php echo esc_attr($title_font_size); ?>px;"><?php echo esc_html($title); ?></<?php echo esc_attr($title_element) ?>>
        <div class="subtitle" style="font-size:<?php echo esc_attr($subtitle_font_size); ?>px;line-height:<?php echo esc_attr($subtitle_font_size); ?>px;"><?php echo esc_html($subtitle); ?></div>
    </div>
    <?php if ($button_enable == 'yes'): ?>
    <a href="<?php echo esc_url($button_link); ?>" class="button action <?php echo esc_attr($button_classes); ?>"<?php echo $btnStyleAtt; ?> target="<?php echo esc_attr($open_in); ?>"><?php echo esc_html($button_label); ?></a>
    <?php endif; ?>
</div>