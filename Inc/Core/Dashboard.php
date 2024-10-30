<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

class Dashboard {
    public function render()
    {
        $post_status = array_diff(get_post_stati(), ['inherit', 'auto-draft', 'trash']);
        $items = Helpers\PromotingContentsHelper::getAll(4, $post_status);

        contentpromoter()->renderer->render('dashboard/tmpl', ['items' => $items]);
    }
}