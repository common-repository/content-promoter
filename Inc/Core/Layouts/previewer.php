<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$allowed_tags = [
    'span' => [
        'class' => true
    ]
];

// saved promoting items
$items = isset($data['items']) ? $data['items'] : [];
$items = array_values($items);

$total_items = isset($data['total_items']) ? $data['total_items'] : 1;



// min and max items to render

$min = 8;
$max = 20;




// get randomly the total items
$total_random_items = mt_rand($min,$max);

$promoting_item_pos = round($total_random_items / ($total_items + 1));
$firstPos = $promoting_item_pos;
$added = 0;
?>
<!-- Content Promoter Previewer -->
<div class="ctpr-previewer-wraper">
    <!-- Browser Header -->
    <div class="previewer-header">
        <!-- Browser Buttons -->
        <div class="previewer-btns">
            <span class="previewer-btn close"></span>
            <span class="previewer-btn retract"></span>
            <span class="previewer-btn expand"></span>
        </div>
        <!-- /Browser Buttons -->
        <!-- Browser Title -->
        <div class="previewer-title"><?php echo esc_html(contentpromoter()->_('CP_LIVE_PREVIEW')); ?></div>
        <!-- /Browser Title -->
        <!-- Browser Actions -->
        <div class="previewer-actions">
            <?php contentpromoter()->renderer->render('preview_button'); ?>
        </div>
        <!-- /Browser Actions -->
    </div>
    <!-- /Browser Header -->
    <div class="ctpr-previewer">
    <?php
    for ($i=0; $i<$total_random_items; $i++)
    {
        $item_class = '';
        
        if ($firstPos == $i && $added != $total_items)
        {
            

            ?>
            <div class="promoting-item<?php echo esc_attr($item_class); ?>">
                <?php
                if (!count($items))
                {
                    echo wp_kses(sprintf(contentpromoter()->_('CP_PROMOTING_CONTENT_PREVIEW'), contentpromoter()->_('CP_PROMOTING_CONTENT'), ($added + 1)), $allowed_tags);
                }
                else
                {
                    echo wp_kses(sprintf(contentpromoter()->_('CP_PROMOTING_CONTENT_PREVIEW'), $items[$added]['title'], ($added + 1)), $allowed_tags);
                }
                ?>
            </div>
            <?php
            $firstPos += $promoting_item_pos;
            $added++;
        }
        // calculate width and height of each item
        $random_width = mt_rand(5, 100);
        $random_height = mt_rand(15, 25);
        ?>
        <div class="item" style="width:<?php echo esc_attr($random_width); ?>%;height:<?php echo esc_attr($random_height); ?>px;"></div>
        <?php
    }
    ?>
    </div>
</div>
<!-- /Content Promoter Previewer -->
<!-- Content Promoter Previewer Template Promoting Item -->
<div class="promoting-item-template promoting-item">
    <?php echo wp_kses(sprintf(contentpromoter()->_('CP_PROMOTING_CONTENT_PREVIEW'), contentpromoter()->_('CP_PROMOTING_CONTENT'), 1), $allowed_tags); ?>
</div>
<!-- /Content Promoter Previewer Template Promoting Item -->
<?php contentpromoter()->renderer->render('previewer_navigator', ['items' => $items]); ?>