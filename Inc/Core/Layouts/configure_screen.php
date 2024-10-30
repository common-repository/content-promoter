<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$defaultItem = [
    0 => [
        'title' => contentpromoter()->_('CP_PROMOTING_CONTENT'),
        'type' => 'text'
    ]
];
$items = isset($data['items']) && is_array($data['items']) && count($data['items']) ? $data['items'] : $defaultItem;
$types = isset($data['types']) ? $data['types'] : [];
?>
<div class="ctpr-configure-screen">
    <!-- Promoting Items Wrapper -->
    <div class="ctpr-promoting-items-wrapper">
        <?php
        $count = 1;
        foreach ($items as $key => $item_data)
        {
            $title = isset($item_data['title']) ? $item_data['title'] : contentpromoter()->_('CP_DEFAULT_ITEM_TITLE');
            $type = isset($item_data['type']) ? $item_data['type'] : '';
            $content = isset($item_data['content']) ? $item_data['content'] : '';
            $isActive = (($count == 1 && !empty($content)) || !empty($content)) ? ' is-active' : '';
            ?>
            <div class="ctpr-promoting-item-editor<?php echo esc_attr($isActive); ?>" data-item-id="<?php echo esc_attr($count); ?>">
                <span class="number">#<span><?php echo esc_html($count); ?></span></span>
                <div class="top">
                    <input type="text" name="ctpr_meta_settings[items][<?php echo esc_attr($count); ?>][title]" data-default_title="<?php echo contentpromoter()->_('CP_DEFAULT_ITEM_TITLE'); ?>" value="<?php echo esc_attr($title); ?>" class="ctpr-item-title" value="<?php echo contentpromoter()->_('CP_PROMOTING_CONTENT'); ?>" />
                    <span class="actions">
                        <div class="ctpr-item-loader"></div>
                        <a href="#" class="dashicons dashicons-edit ctpr-change-type-promoting-item" title="<?php echo contentpromoter()->_('CP_CHANGE_TYPE_BTN'); ?>"></a>
                        <a href="#" class="dashicons dashicons-arrow-up-alt2 ctpr-toggle-promoting-item" title="<?php echo contentpromoter()->_('CP_TOGGLE_BTN'); ?>"></a>
                        <a href="#" class="dashicons dashicons-move ctpr-move-promoting-item" title="<?php echo contentpromoter()->_('CP_MOVE_ITEM'); ?>"></a>
                    </span>
                </div>
                <div class="body">
                    <div class="content"><?php echo $content; ?></div>
                    <div class="ctpr-content-chooser">
                        <?php
                        foreach ($types as $key => $item_type)
                        {
                            $extra_atts = [];
                            $extra_classes = [];
                            $isPro = isset($item_type['pro']) && $item_type['pro'] == true ? true : false;
                            
                            if ($isPro)
                            {
                                $extra_atts[] = 'data-ctpr-pro-feature="' . esc_attr($item_type['label']) . '"';
                                $extra_classes[] = '';
                                $extra_classes[] = 'pro';
                            }
                            
                            ?>
                            <div data-type="<?php echo esc_attr($item_type['name']); ?>"<?php echo implode(' ', $extra_atts); ?> class="item<?php echo implode(' ', $extra_classes); ?><?php echo ($type == $item_type['name'] && $isActive) ? ' is-active' : ''; ?>" title="<?php echo esc_attr($item_type['label']); ?>">
                                <?php
                                echo esc_html($item_type['label']);
                                if ($isPro)
                                {
                                    ?><span class="pro-label"><?php echo esc_html(contentpromoter()->_('CP_PRO')); ?></span><?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <input type="hidden" data-id="<?php echo esc_attr($count); ?>" value="<?php echo esc_attr($type); ?>" name="ctpr_meta_settings[items][<?php echo esc_attr($count); ?>][type]" class="item_type" />
                </div>
            </div>
            <?php
            $count++;
        }
        ?>
    </div>
    <!-- /Promoting Items Wrapper -->
    <!-- Promoting Item Template -->
    <div class="ctpr-promoting-item-editor template" data-item-id="">
        <span class="number">#<span></span></span>
        <div class="top">
            <input type="text"name="ctpr_meta_settings[items][ITEM_ID][title]" data-default_title="<?php echo contentpromoter()->_('CP_DEFAULT_ITEM_TITLE'); ?>" class="ctpr-item-title" value="<?php echo contentpromoter()->_('CP_PROMOTING_CONTENT'); ?>" />
            <span class="actions">
                <div class="ctpr-item-loader"></div>
                <a href="#" class="dashicons dashicons-edit ctpr-change-type-promoting-item" title="<?php echo contentpromoter()->_('CP_CHANGE_TYPE_BTN'); ?>"></a>
                <a href="#" class="dashicons dashicons-arrow-down-alt2 ctpr-toggle-promoting-item" title="<?php echo contentpromoter()->_('CP_TOGGLE_BTN'); ?>"></a>
                <a href="#" class="dashicons dashicons-move ctpr-move-promoting-item" title="<?php echo contentpromoter()->_('CP_MOVE_ITEM'); ?>"></a>
            </span>
        </div>
        <div class="body">
            <div class="content is-hidden"></div>
            <div class="ctpr-content-chooser">
                <?php
                foreach ($types as $key => $item_type)
                {
                    $extra_atts = [];
                    $extra_classes = [];
                    
                    $isPro = isset($item_type['pro']) && $item_type['pro'] == true ? true : false;
                    if ($isPro)
                    {
                        $extra_atts[] = 'data-ctpr-pro-feature="' . esc_attr($item_type['label']) . '"';
                        $extra_classes[] = '';
                        $extra_classes[] = 'pro';
                    }
                    
                    ?>
                    <div data-type="<?php echo esc_attr($item_type['name']); ?>"<?php echo implode(' ', $extra_atts); ?> class="item<?php echo implode(' ', $extra_classes); ?>" title="<?php echo esc_attr($item_type['label']); ?>">
                        <?php
                        echo esc_html($item_type['label']);
                        if ($isPro)
                        {
                            ?><span class="pro-label"><?php echo esc_html(contentpromoter()->_('CP_PRO')); ?></span><?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
            <input type="hidden" value="" name="ctpr_meta_settings[items][ITEM_ID][type]" class="item_type" />
        </div>
    </div>
    <!-- /Promoting Item Template -->
</div>