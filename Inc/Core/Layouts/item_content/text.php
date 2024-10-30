<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$text = $this->data->get('text.value', '');
$allowed_tags = [];

$allowed_tags = [
    'h1' => ['class' => []],
    'h2' => ['class' => []],
    'h3' => ['class' => []],
    'h4' => ['class' => []],
    'h5' => ['class' => []],
    'h6' => ['class' => []],
    'b' => ['class' => []],
    'strong' => ['class' => []],
    'i' => ['class' => []],
    'u' => ['class' => []],
    'ul' => ['class' => []],
    'ol' => ['class' => []],
    'li' => ['class' => []],
    'hr' => ['class' => []],
    'a' => [
        'href' => [],
        'class' => [],
        'target' => []
    ],
    'p' => ['class' => []]
];



$promoting_content_id = $this->data->get('promoting_content_id', '');
?>
<div class="ctpr-item-<?php echo esc_attr($promoting_content_id); ?> ctpr-promoting-item text">
    <?php echo wp_kses($text, $allowed_tags); ?>
</div>