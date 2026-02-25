<?php

if (!defined('ABSPATH')) {
    exit;
}

class WCROP_Woocommerce_Check
{

    // checks if woocommerce is active
    private function wcrop_woocommerce_active(): bool
    {
        return class_exists('WooCommerce');
    }

    // show notice to the admin if WC is not active
    public function wcrop_wc_missing_notice(): void
    {
        if (! $this->wcrop_woocommerce_active()) {
            deactivate_plugins(plugin_basename(__FILE__));
            echo '<div class="notice notice-error">
                <p><strong>woocommerce-recent-order-popup:</strong> has been deactivated because WooCommerce is not active.</p>
              </div>';
        }
    }
}
