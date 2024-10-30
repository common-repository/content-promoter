<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$items = isset($data['items']) ? $data['items'] : [];
$name = isset($data['name']) ? $data['name'] : '';
$default = isset($data['default']) ? $data['default'] : '';
$input_class = isset($data['input_class']) && is_array($data['input_class']) ? ' ' . implode(' ', $data['input_class']) : [];
$field_value = isset($data['value']) && !empty($data['value']) ? $data['value'] : '';
$field_value = !empty($field_value) ? $field_value : $default;

if (empty($name))
{
    return;
}

if (empty($items))
{
    return;
}

?>
<div class="ctpr-group-list-field">
    <?php
    $index = 1;
    foreach ($items as $key => $value)
    {
        ?>
        <div class="item<?php echo esc_attr($input_class); ?>">
            <input id="<?php echo esc_attr($name) . '_' . $index; ?>" name="<?php echo esc_attr($name); ?>" type="radio" value="<?php echo esc_attr($key); ?>"<?php echo $key == $field_value ? ' checked="checked"' : ''; ?> />
            <label for="<?php echo esc_attr($name) . '_' . $index; ?>" class="ctpr-button light">
                <?php echo esc_html(contentpromoter()->_($value)); ?>
            </label>
        </div>
        <?php
        $index++;
    }
    ?>
</div>