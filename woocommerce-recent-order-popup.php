<?php

/**
 * Plugin Name: woocommmerce recent order popup
 * Plugin URI: https://woocommercerecentorderpopup.com
 * Descrition: shows the recent store orders on frontend.
 * Version: 1.0
 * Author: Huzaifa
 * Author URI: Huzaifa_Murtaza.com
 * Text Domain: woocommerce-recent-order-popup
 */

if (!defined('ABSPATH')) exit;

define('WCROP_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WCROP_PLUGIN_PATH', plugin_dir_path(__FILE__));

require_once WCROP_PLUGIN_PATH . 'includes/class-wcrop-woocommerce-check.php';
require_once WCROP_PLUGIN_PATH . 'includes/class-wcrop-bootstrap.php';

// new WCROP_Woocommerce_Check();

// error_log('printing WCROP_Woocommerce_Check');

// if (class_exists('WooCommerce')) {
//     $WCROP = new WCROP_Bootstrap();

//     error_log("WCROP_Bootstrap object created: " . print_r($WCROP, true));
//     $WCROP->run();
//     error_log('$WCROP-> run()');
// }

add_action('plugins_loaded', function () {
    new WCROP_Woocommerce_Check();
    error_log('printing WCROP_Woocommerce_Check');

    if (class_exists('WooCommerce')) {
        $WCROP = new WCROP_Bootstrap();
        error_log("WCROP_Bootstrap object created: " . print_r($WCROP, true));
        $WCROP->run();
        error_log('$WCROP-> run()');
    }
});


function wcrop_add_action_links(array $links){

    $settings_url = admin_url('admin.php?page=wc-settings&tab=wcrop_settings');
    $settings_link = sprintf(
        '<a href="%s">%s</a>',
        esc_url($settings_url),
        __('Settings','woocommerce-recent-order-popup'),
    );

    array_unshift($links,$settings_link);

    return $links;
}

add_filter('plugin_action_links_'.plugin_basename(__FILE__),'wcrop_add_action_links');
