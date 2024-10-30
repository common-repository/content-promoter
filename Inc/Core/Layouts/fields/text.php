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

$value = isset($data['value']) && !empty($data['value']) ? $data['value'] : contentpromoter()->_($data['default']);
$placeholder = isset($data['placeholder']) ? $data['placeholder'] : '';
?>
<input type="text" id="<?php echo esc_attr($name); ?>" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr($placeholder); ?>" />