<?php
namespace ContentPromoter\Core\Fields;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class TableExistsAlert extends \ContentPromoter\Core\Field
{
    public function getProps()
    {
		$table = $this->options->get('table', '');

        return [
			'table' => $table,
			'plugin_folders' => $this->options->get('plugin_folders', []),
			'plugin_name' => $this->options->get('plugin_name', ''),
			'plugin_title' => $this->options->get('plugin_title', ''),
			'check_plugin_table_exists' => $this->options->get('check_plugin_table_exists', false),
			'title' => $this->options->get('title', 'CP_ENSURE_PLUGIN_INSTALLED_ALERT'),
			'exists' => \ContentPromoter\Core\Helpers\WPHelper::isPluginActive($this->options)
        ];
	}
}