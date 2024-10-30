<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
global $pagenow;
$preview_text_label = 'CP_PREVIEW_TEXT';
$is_new = false;
// show a different label for new promoting items
if (in_array($pagenow, ['post-new.php']))
{
    $is_new = true;
    $preview_text_label .= '_NEW';
}
?>
<a href="<?php echo $is_new ? '#' : \ContentPromoter\Core\Helpers\WPHelper::ctpr_get_item_preview_url(get_the_ID()); ?>" title="<?php echo esc_attr(contentpromoter()->_($preview_text_label)); ?>" target="_blank" class="ctpr-button<?php echo $is_new ? ' is-disabled' : ''; ?> small"><?php echo esc_html(contentpromoter()->_('CP_PREVIEW')); ?></a>