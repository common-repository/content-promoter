<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$name = isset($data['name']) ? $data['name'] : '';
$value = isset($data['value']) ? $data['value'] : '';

if (empty($name))
{
    return;
}
?>
<input type="hidden" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($value); ?>" />