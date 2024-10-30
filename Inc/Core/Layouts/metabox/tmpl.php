<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
?>
<div id="ctpr-metabox-settings">
    <div class="row">
        <div class="col-md-7 p-r-0">
            <?php contentpromoter()->renderer->render('wizard', $data); ?>
        </div>
        <div class="col-md-5">
            <?php contentpromoter()->renderer->render('previewer', $data); ?>
        </div>
    </div>
</div>