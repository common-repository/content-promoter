<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$allowed_tags = [
    'strong' => [],
    'a' => [
        'href' => [],
        'target' => []
    ],
    'br' => [],
    'em' => [
        'class' => [],
        'title' => []
    ],
    'span' => [
        'class' => []
    ]
];
$label = isset($data['label']) ? $data['label'] : '';
$description = isset($data['description']) ? $data['description'] : '';
$description_pos = isset($data['description_pos']) ? $data['description_pos'] : 'start';
$content = isset($data['content']) ? $data['content'] : '';
$base_name = isset($data['base_name']) ? $data['base_name'] : '';
$name = isset($data['name']) ? $data['name'] : '';
$type = isset($data['type']) ? strtolower($data['type']) : '';
$class = isset($data['class']) && is_array($data['class']) ? ' ' . implode(' ', $data['class']) : [];
?>
<div class="ctpr-field-control-group<?php echo esc_attr($class); ?>">
    <?php if (!empty($label)): ?>
    <label for="<?php echo esc_attr($name); ?>" class="label"><?php echo esc_html(contentpromoter()->_($label)); ?></label>
    <?php endif; ?>
    <?php if (!empty($description) && $description_pos == 'start'): ?>
    <div class="description start"><?php echo wp_kses(contentpromoter()->_($description), $allowed_tags); ?></div>
    <?php endif; ?>
    <div class="control">
        <?php echo $content; ?>
    </div>
    <?php if (!empty($description) && $description_pos == 'end'): ?>
    <div class="description end"><?php echo wp_kses(contentpromoter()->_($description), $allowed_tags); ?></div>
    <?php endif; ?>
    <input type="hidden" name="<?php echo esc_attr($base_name); ?>[type]" value="<?php echo esc_attr($type); ?>" />
</div>