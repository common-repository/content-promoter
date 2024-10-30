<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$label = isset($data['label']) ? $data['label'] : '';
if (!$label)
{
    return;
}
$heading = $data['heading'];
$class = isset($data['class']) ? $data['class'] : [];
$allowed_tags = [
    'strong' => []
];
?>
<<?php echo esc_html($heading); ?> class="ctpr-heading-field <?php echo esc_attr(implode(' ', $class)); ?>"><?php echo wp_kses(contentpromoter()->_($label), $allowed_tags); ?></<?php echo esc_html($heading); ?>>