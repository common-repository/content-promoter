<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$name = isset($data['name']) ? $data['name'] : '';
if (empty($name))
{
    return;
}
$choices = isset($data['choices']) ? $data['choices'] : [];

if (empty($choices))
{
    return;
}

$default = isset($data['default']) ? $data['default'] : [];
$value = isset($data['value']) && !empty($data['value']) ? $data['value'] : $default;

$class = count($this->data->get('input_class')) ? ' ' . implode(' ', $this->data->get('input_class')) : '';
?>
<div class="ctpr-dropdown-field">
    <select id="<?php echo esc_attr($name); ?>" name="<?php echo esc_attr($name); ?>" class="<?php echo esc_attr($class); ?>">
    <?php
    foreach ($choices as $key => $_value)
    {
        ?>
        <option value="<?php echo esc_attr($key); ?>"<?php echo ($value == $key) ? ' selected="selected"' : ''; ?>><?php echo esc_html(contentpromoter()->_($_value)); ?></option>
        <?php
    }
    ?>
    </select>
</div>