<?php

if (!defined('ABSPATH')) {
    exit;
}

class WCROP_Admin
{

    public function wcrop_add_admin_settings(): array
    {
        $wcrop_settings_array = array();

        $wcrop_settings_array[] = array(
            'title' => __('WooCommerce Recent Order Notification', 'wcrop'),
            'type' => 'title',
            'id' => 'wcrop_settings_title'
        );

        $wcrop_settings_array[] = array(
            'title' => __('Show notifications popup', 'wcrop'),
            'desc' => __('Show recent order', 'wcrop'),
            'type' => 'checkbox',
            'default' => 'no',
            'id' => 'wcrop_show_popup'
        );


        $wcrop_settings_array[] = array(
            'type' => 'sectionend',
            'id' => 'wcrop_settings_end'
        );
        error_log("WCROP: wcrop_add_admin_settings() fired\n");

        return $wcrop_settings_array;
    }

    public function wcrop_add_settings_tab($tabs): array
    {
        error_log('WCROP: wcrop_add_settings_tab() fired');

        $tabs['wcrop_settings'] = __('Recent-Orders', 'wcrop');

        error_log('WCROP: Tab added to settings array');

        return $tabs;
    }

    public function wcrop_display_setttings_tab_content(): void
    {
        error_log("WCROP: wcrop_display_setttings_tab_content() fired\n");
        woocommerce_admin_fields($this->wcrop_add_admin_settings());
    }

    public function wcrop_save_settings(): void
    {
        error_log("WCROP: wcrop_save_settings() fired\n");
        woocommerce_update_options($this->wcrop_add_admin_settings());
    }
}
