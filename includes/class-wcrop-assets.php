<?php

if (!defined('ABSPATH')) {
    exit;
}

class WCROP_Assets
{

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

        wp_localize_script(
            'wcrop_recent_orders_popup',
            'wcrop_recent_orders',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('wcrop_recent_order_nonce'),
                'interval' => 10000,
                'last_order_id' => $this->get_last_order_id()
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
