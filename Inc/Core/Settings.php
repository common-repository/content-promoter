<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

class Settings {
    public function __construct()
    {
        add_action('contentpromoter/settings_page', [$this, 'render_settings_page']);
        
        
        
        add_action('admin_init', [$this, 'registerSettings']);
    }

    

    public function registerSettings()
    {
        register_setting( 'contentpromoter_settings_page', 'ctpr_settings_page_data', [$this, 'ctpr_settings_callback'] );
    }

    /**
     * Callback that runs when we submit the settings form
     * 
     * @param   array  $input
     * 
     * @return  array
     */
    public function ctpr_settings_callback($input)
    {
        

        return $input;
    }

    
    
    public function render()
    {
        contentpromoter()->renderer->render('settings/tmpl');
    }
    
    public function render_settings_page()
    {
        $settings = get_option('ctpr_settings_page_data', $this->getDefaultSettings());

        contentpromoter()->renderer->render('settings/form', ['settings' => $settings]);
    }

    public function getDefaultSettings()
    {
        return [
            'keep_data_on_uninstall' => true,
            'global_default_replacement_element' => 'div'
        ];
    }
}