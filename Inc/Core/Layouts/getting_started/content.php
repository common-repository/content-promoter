<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$allowed_tags = [
	'strong' => true
];
?>
<div class="ctpr-promo-page">
	<div class="section">
		<h2 class="title"><?php echo esc_html(contentpromoter()->_('CP_WELCOME_TO_CP')); ?></h2>
		<div class="description"><?php echo wp_kses(contentpromoter()->_('CP_WELCOME_TO_CP_DESC'), $allowed_tags); ?></div>
	</div>
	<div class="section">
		<h3 class="title t2"><?php echo esc_html(contentpromoter()->_('CP_WELCOME_TO_CP_STEPS')); ?></h3>
	</div>
	<div class="steps">
		<div class="step">
			<span class="number">1</span>
			<div class="content">
				<h3 class="title"><?php echo esc_html(contentpromoter()->_('CP_WELCOME_TO_CP_STEPS_1_TITLE')); ?></h3>
				<div class="description"><?php echo esc_html(contentpromoter()->_('CP_WELCOME_TO_CP_STEPS_1_DESC_1')); ?></div>
				<div class="description"><?php echo esc_html(contentpromoter()->_('CP_WELCOME_TO_CP_STEPS_1_DESC_2')); ?></div>
				<div class="actions">
					<a href="<?php echo admin_url('post-new.php?post_type=content-promoter'); ?>" class="ctpr-button"><?php echo esc_html(contentpromoter()->_('CP_CREATE_YOUR_FIRST_PROMOTING_ITEM')); ?></a>
				</div>
			</div>
		</div>
		<div class="step">
			<span class="number">2</span>
			<div class="content">
				<h3 class="title"><?php echo esc_html(contentpromoter()->_('CP_SELECTION')); ?></h3>
				<div class="description"><?php echo esc_html(contentpromoter()->_('CP_WELCOME_TO_CP_STEPS_2_DESC_1')); ?></div>
				<div class="description"><?php echo esc_html(contentpromoter()->_('CP_WELCOME_TO_CP_STEPS_2_DESC_2')); ?></div>
				<img class="preview_image" src="<?php echo CTPR_ADMIN_MEDIA_URL . 'img/welcome/selection.png' ?>" alt="new promoting item selection page" />
			</div>
		</div>
		<div class="step">
			<span class="number">3</span>
			<div class="content">
				<h3 class="title"><?php echo esc_html(contentpromoter()->_('CP_CONFIGURE')); ?></h3>
				<div class="description"><?php echo esc_html(contentpromoter()->_('CP_WELCOME_TO_CP_STEPS_3_DESC_1')); ?></div>
				<div class="description"><?php echo esc_html(contentpromoter()->_('CP_WELCOME_TO_CP_STEPS_3_DESC_2')); ?></div>
				<div class="description"><?php echo esc_html(contentpromoter()->_('CP_WELCOME_TO_CP_STEPS_3_DESC_3')); ?></div>
				<img class="preview_image" src="<?php echo CTPR_ADMIN_MEDIA_URL . 'img/welcome/configure.png' ?>" alt="new promoting item configure page" />
			</div>
		</div>
		<div class="step">
			<span class="number">4</span>
			<div class="content">
				<h3 class="title"><?php echo esc_html(contentpromoter()->_('CP_PUBLISH_SETTINGS')); ?></h3>
				<div class="description"><?php echo esc_html(contentpromoter()->_('CP_WELCOME_TO_CP_STEPS_4_DESC_1')); ?></div>
				<div class="description"><?php echo esc_html(contentpromoter()->_('CP_WELCOME_TO_CP_STEPS_4_DESC_2')); ?></div>
				<div class="description"><?php echo esc_html(contentpromoter()->_('CP_WELCOME_TO_CP_STEPS_4_DESC_3')); ?></div>
				<div class="description"><?php echo esc_html(contentpromoter()->_('CP_WELCOME_TO_CP_STEPS_4_DESC_4')); ?></div>
				<img class="preview_image" src="<?php echo CTPR_ADMIN_MEDIA_URL . 'img/welcome/publish_settings.png' ?>" alt="new promoting item publish settings page" />
			</div>
		</div>
		<div class="step">
			<span class="number">5</span>
			<div class="content">
				<h3 class="title"><?php echo esc_html(contentpromoter()->_('CP_PREVIEW')); ?></h3>
				<div class="description"><?php echo wp_kses(contentpromoter()->_('CP_WELCOME_TO_CP_STEPS_5_DESC'), $allowed_tags); ?></div>
				<img class="preview_image" src="<?php echo CTPR_ADMIN_MEDIA_URL . 'img/welcome/preview.png' ?>" alt="new promoting item preview page" />
			</div>
		</div>
		<div class="step">
			<span class="number">6</span>
			<div class="content">
				<h3 class="title"><?php echo esc_html(contentpromoter()->_('CP_SAVE')); ?></h3>
				<div class="description"><?php echo esc_html(contentpromoter()->_('CP_WELCOME_TO_CP_STEPS_6_DESC')); ?></div>
				<img class="preview_image" src="<?php echo CTPR_ADMIN_MEDIA_URL . 'img/welcome/save.png' ?>" alt="new promoting item save page" />
			</div>
		</div>
	</div>
</div>