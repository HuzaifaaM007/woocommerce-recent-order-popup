<?php

if (!defined('ABSPATH')) {
    exit;
}

class WCROP_Assets
{

    public function wcrop_enqueue_admin_scripts(): void
    {

        wp_enqueue_script(
            'wcrop_admin',
            WCROP_PLUGIN_URL . 'assets/admin/js/wcrop-admin.js',
            array(),
            '1.0.0',
            true
        );
    }

    public function wcrop_enqueue_scripts(): void
    {

        wp_enqueue_script(
            'wcrop_recent_orders_popup',
            WCROP_PLUGIN_URL . 'assets/js/wcrop-recent-order-popup.js',
            array(),
            '1.0.0',
            true
        );

        wp_enqueue_style(
            'wcrop_recent_orders_css',
            WCROP_PLUGIN_URL . 'assets/css/wcrop-recent-order-popup.css',
            array(),
            '1.0.0',
            'all'
        );

        $color_scheme = get_option('wcrop_color_scheme', 'light');
        $border_radius = get_option('wcrop_image_border', 'rounded');
        $bg_color = get_option('wcrop_popup_bg_color', '#ffffff');
        $text_color = get_option('wcrop_popup_text_color', '#222222');

        wp_localize_script(
            'wcrop_recent_orders_popup',
            'wcrop_recent_orders',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('wcrop_recent_order_nonce'),
                'interval' => (int)get_option('wcrop_popup_time_to_fetch_orders', false),
                'last_order_id' => $this->get_last_order_id(),
                'wcrop_popup_display_time' => (int)get_option('wcrop_popup_display_time', false),
                'wcrop_popup_time_to_show' => (int)get_option('wcrop_popup_time_to_show', false),
                'wcrop_color_scheme' => sanitize_html_class($color_scheme),
                'wcrop_image_border' => sanitize_html_class($border_radius),
                'wcrop_popup_bg_color' => sanitize_hex_color($bg_color),
                'wcrop_popup_text_color' => sanitize_hex_color($text_color),
            )
        );
    }

    private function get_last_order_id(): int
    {

        $orders = wc_get_orders(
            array(
                'limit' => 1,
                'orderby' => 'date',
                'order' => 'DESC'
            )
        );

        $order_id = !empty($orders) ? $orders[0]->get_id() : 0;

        return $order_id;
    }
}
