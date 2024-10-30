<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$item_id = isset($data['item_id']) ? $data['item_id'] : 1;
$field_id = isset($data['field_id']) ? $data['field_id'] : 1;
$id = $item_id . '_' . $field_id;
$name = isset($data['name']) ? $data['name'] : '';
$value = isset($data['value']) ? $data['value'] : '';
$rows = isset($data['rows']) ? $data['rows'] : 5;


$allowed_tags = [
    'b' => [],
    'strong' => [],
    'i' => [],
    'u' => [],
    'ul' => ['class' => []],
    'ol' => ['class' => []],
    'li' => ['class' => []],
    'hr' => ['class' => []],
    'a' => [
        'href' => [],
        'class' => [],
        'target' => []
    ]
];

if (empty($name))
{
    return;
}

$options = [
    'textarea_name' => $name,
    'textarea_rows' => $rows
];


$options = [
    'tinymce' => [
        'toolbar1' => 'bold,italic,underline,alignleft,aligncenter,alignright,link,unlink'
    ],
    'quicktags' => [
        'buttons' => 'strong,underline,em,link,ul,li,code'
    ]
];



?>
<textarea name="<?php echo esc_attr($name); ?>" data-tinymce-configs="<?php echo esc_attr(json_encode($options)); ?>" class="ctpr-wpeditor-area" id="ctpr_promoting_item_<?php echo esc_attr($id); ?>" rows="<?php echo esc_attr($rows); ?>"><?php echo esc_textarea($value); ?></textarea>