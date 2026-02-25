<?php

if (!defined('ABSPATH')) {
    exit;
}


class WCROP_Bootstrap
{

    private WCROP_Loader $loader;

    public function __construct()
    {
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_woocomerce_hooks();
    }

    public function load_dependencies(): void
    {
        require_once WCROP_PLUGIN_PATH . 'includes/class-wcrop-loader.php';
        require_once WCROP_PLUGIN_PATH . 'includes/class-wcrop-recent-orders.php';
        require_once WCROP_PLUGIN_PATH . 'includes/class-wcrop-assets.php';
        require_once WCROP_PLUGIN_PATH .  'includes/admin/class-wcrop-admin.php';
        error_log('WCROP_Loaders : start');

        $this->loader = new WCROP_Loader();

        error_log('WCROP_Loaders : end');
    }


    private function define_admin_hooks(): void
    {
        $wcrop_admin = new WCROP_Admin();

        error_log('define admin hooks start');
        $this->loader->add_filters(
            'woocommerce_settings_tabs_array',
            $wcrop_admin,
            'wcrop_add_settings_tab',
            50
        );



        $this->loader->add_actions(
            'woocommerce_settings_tabs_wcrop_settings',
            $wcrop_admin,
            'wcrop_display_setttings_tab_content'
        );

        $this->loader->add_actions(
            'woocommerce_update_options_wcrop_settings',
            $wcrop_admin,
            'wcrop_save_settings'
        );

        error_log('define admin hooks end');
    }

    private function define_woocomerce_hooks(): void
    {
        $recent_orders = new WCROP_Recent_Orders();

        $this->loader->add_actions(
            'wp_ajax_wcrop_check_new_orders',
            $recent_orders,
            'check_new_orders',
        );

        $this->loader->add_actions(
            'wp_ajax_nopriv_wcrop_check_new_orders',
            $recent_orders,
            'check_new_orders',
        );

        $wcrop_assets = new  WCROP_Assets();

        $this->loader->add_actions(
            'wp_enqueue_scripts',
            $wcrop_assets,
            'wcrop_enqueue_scripts',
        );
    }

    public function run(): void
    {
        $this->loader->run();
    }
}
