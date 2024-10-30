<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
if (!$items = $this->data->get('items', []))
{
	return;
}
?>
<table class="ctpr-table">
	<thead>
		<th><?php echo esc_html(contentpromoter()->_('CP_NAME')); ?></th>
		<th class="item-status"><?php echo esc_html(contentpromoter()->_('CP_STATUS')); ?></th>
	</thead>
	<tbody>
		<?php
		foreach ($items as $key => $item)
		{
			$status = get_post_status($item);
			$status = $status == 'publish' ? 'published' : $status;
			$title = !empty($item->post_title) ? mb_substr($item->post_title, 0, 130) : '-';
			?>
			<tr>
				<td class="item-title">
					<a href="<?php echo admin_url('post.php?post=' . $item->ID . '&action=edit') ?>">
						<?php echo esc_html($title); ?>
					</a>
				</td>
				<td class="item-status">
					<?php echo esc_html(ucfirst($status)); ?>
					<a href="<?php echo admin_url('post.php?post=' . $item->ID . '&action=edit') ?>">
						<span class="dashicons dashicons-admin-generic icon"></span>
					</a>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>