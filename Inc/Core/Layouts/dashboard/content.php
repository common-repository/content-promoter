<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$items = $this->data->get('items', []);
?>
<div class="ctpr-dashboard">
	<div class="ctpr-row">
		<div class="ctpr-col-6">
			<!-- Promoting Items -->
			<div class="dashboard-item">
				<div class="item-header">
					<span class="dashicons dashicons-groups icon"></span>
					<?php echo esc_html(contentpromoter()->_('CP_PROMOTING_ITEMS')); ?>
				</div>
				<div class="item-content">
					<p class="content-title"><?php echo esc_html(contentpromoter()->_('CP_DASHBOARD_ITEM_PROMOTING_CONTENTS_DESC')); ?></p>
					<?php contentpromoter()->renderer->render('dashboard/items', ['items' => $items]); ?>
				</div>
				<div class="item-actions">
					<a href="<?php echo admin_url('post-new.php?post_type=content-promoter'); ?>" class="ctpr-button small">
						<span class="dashicons dashicons-plus-alt2 icon"></span>
						<span class="text"><?php echo esc_html(contentpromoter()->_('CP_CREATE_UC')); ?></span>
					</a>
					<?php if (count($items)) { ?>
						<a href="<?php echo esc_url(admin_url('edit.php?post_type=content-promoter')) ?>" class="last-item"><?php echo esc_html(contentpromoter()->_('CP_VIEW_ALL_PROMOTING_ITEMS')); ?></a>
					<?php } ?>
				</div>
			</div>
			<!-- /Promoting Items -->
		</div>
		<div class="ctpr-col-6">
			<div class="dashboard-item auto-height">
				<div class="item-header">
					<span class="dashicons dashicons-thumbs-up icon"></span>
					<?php echo esc_html(contentpromoter()->_('CP_LIKE_CP')); ?>
				</div>
				<div class="item-content">
					<p class="content-title"><?php echo esc_html(contentpromoter()->_('CP_LIKE_CP_DESC')); ?></p>
					<div class="rate-icons">
						<i class="dashicons dashicons-star-filled"></i>
						<i class="dashicons dashicons-star-filled"></i>
						<i class="dashicons dashicons-star-filled"></i>
						<i class="dashicons dashicons-star-filled"></i>
						<i class="dashicons dashicons-star-filled"></i>
						<a href="https://wordpress.org/support/plugin/content-promoter/reviews/#new-post"><?php echo esc_html(contentpromoter()->_('CP_WRITE_A_REVIEW')); ?></a>
					</div>
				</div>
			</div>
			<div class="dashboard-item auto-height">
				<div class="item-header">
					<span class="dashicons dashicons-email icon"></span>
					<?php echo esc_html(contentpromoter()->_('CP_HAVE_FEEDBACK_FEATURE_REQUEST')); ?>
				</div>
				<div class="item-content">
					<p class="content-title"><?php echo esc_html(contentpromoter()->_('CP_DASHBOARD_ITEM_PROMOTING_CONTENTS_DESC')); ?></p>
					<a href="<?php echo esc_url(CTPR_SUPPORT_URL); ?>" class="ctpr-button small" target="_blank"><?php echo esc_html(contentpromoter()->_('CP_CONTACT')) ?></a>
				</div>
			</div>
		</div>
	</div>
	<?php  ?>
	<div class="ctpr-row">
		<div class="ctpr-col-12">
			<!-- Content Promoter Pro -->
			<?php
			$pro_items = [
				'QUOTE' => [
					'suffix' => true
				],
				'WP_POST' => [
					'suffix' => true
				],
				'WP_PAGE' => [
					'suffix' => true
				],
				'WP_MENU' => [
					'suffix' => true
				],
				'COMING_SOON' => [
					'suffix' => true
				],
				'SALE' => [
					'suffix' => true
				],
				'BF_SALE' => [
					'suffix' => true
				],
				'CM_SALE' => [
					'suffix' => true
				],
				'FACEBOOK_POST' => [
					'suffix' => true
				],
				'FACEBOOK_PAGE' => [
					'suffix' => true
				],
				'FACEBOOK_VIDEO' => [
					'suffix' => true
				],
				'FACEBOOK_COMMENT' => [
					'suffix' => true
				],
				'FACEBOOK_LIKE' => [
					'suffix' => true
				],
				'FACEBOOK_SHARE' => [
					'suffix' => true
				],
				'TWITTER_BUTTON' => [
					'suffix' => true
				],
				'TWITTER_FOLLOW_BUTTON' => [
					'suffix' => true
				],
				'EMBED_TWEETS' => [
					'suffix' => true
				],
				'YT_VIDEO' => [
					'suffix' => true
				],
				'CTA' => [
					'suffix' => true
				],
				'WPFORMS' => [
					'suffix' => true
				],
				'GF_FORMS' => [
					'suffix' => true
				],
				'WOOCOMMERCE_PRODUCT' => [
					'suffix' => true
				],
				'PUBLISH_ITEMS_ON_SPECIFIC_CPTS' => [
					'suffix' => false
				],
				'CUSTOM_CSS_JS' => [
					'suffix' => false
				],
				'PREMIUM_SUPPORT' => [
					'suffix' => false
				]
			]
			?>
			<div class="dashboard-item pro">
				<div class="item-header">
					<span class="dashicons dashicons-megaphone icon"></span>
					<?php echo esc_html(contentpromoter()->_('CP_PLUGIN_NAME_PRO')); ?>
					<span class="ctpr-label pro sm ctpr-t-t-u"><?php echo esc_html(contentpromoter()->_('CP_PRO')); ?></span>
				</div>
				<div class="item-content">
					<p class="content-title"><?php echo esc_html(contentpromoter()->_('CP_DASHBOARD_ITEM_CONTENT_PROMOTER_PRO_DESC')); ?></p>
					<ul class="col-3">
						<?php
						foreach ($pro_items as $item => $data)
						{
							$suffix = isset($data['suffix']) ? $data['suffix'] : true;
							$suffix = $suffix ? ' ' . contentpromoter()->_('CP_PROMOTING_ITEMS') : '';
							?>
							<li>
								<span class="dashicons dashicons-yes"></span>
								<?php echo esc_html(contentpromoter()->_('CP_' . $item) . $suffix); ?>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
				<div class="item-actions ctpr-p-t-0">
					<a href="<?php echo esc_url(CTPR_UPGRADE_URL); ?>" class="ctpr-button small uc pro fn">
						<span class="text"><?php echo esc_html(contentpromoter()->_('CP_UPGRADE_TO_PRO_TODAY')); ?></span>
					</a>
				</div>
			</div>
			<!-- /Content Promoter Pro -->
		</div>
	</div>
	<?php  ?>
</div>