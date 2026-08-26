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
            'title' => __('WooCommerce Recent Order Notifications Settings', 'wcrop'),
            'type' => 'title',
            'id' => 'wcrop_notifications_settings_title'
        );

        $wcrop_settings_array[] = array(
            'title' => __('Show notifications popup', 'wcrop'),
            'desc' => __('Show recent order', 'wcrop'),
            'type' => 'checkbox',
            'default' => 'no',
            'id' => 'wcrop_show_popup'
        );

        $wcrop_settings_array[] = array(
            'title' => __('Set order fetching interval', 'wcrop'),
            'desc' => __('Time to check new orders', 'wcrop'),
            'type' => 'text',
            'default' => '10000',
            'id' => 'wcrop_popup_time_to_fetch_orders'
        );
        $wcrop_settings_array[] = array(
            'title' => __('Gap between the Notifications popup', 'wcrop'),
            'desc' => __('Time between the notifications', 'wcrop'),
            'type' => 'text',
            'default' => '1000',
            'id' => 'wcrop_popup_time_to_show'
        );

        $wcrop_settings_array[] = array(
            'title' => __('Time of Notification Popup display ', 'wcrop'),
            'desc' => __('Time of notification display', 'wcrop'),
            'type' => 'text',
            'default' => '2000',
            'id' => 'wcrop_popup_display_time'
        );

        $wcrop_settings_array[] = array(
            'type' => 'sectionend',
            'id' => 'wcrop_notifications_settings_end'
        );

        $wcrop_settings_array[] = array(
            'title' => __('WooCommerce Recent Order style Settings', 'wcrop'),
            'type' => 'title',
            'id' => 'wcrop__theme_settings_title'
        );

        $wcrop_settings_array[] = array(
            'title' => __('Color scheme for notifications', 'wcrop'),
            'desc' => __('select prefer colors scheme according to the theme', 'wcrop'),
            'type' => 'select',
            'default' => 'light',
            'id' => 'wcrop_color_scheme',
            'options'  => array(
                'light'  => __('Light (Default)', 'wcrop'),
                'dark'   => __('Dark', 'wcrop'),
                'blue'   => __('Ocean Blue', 'wcrop'),
                'custom' => __('Custom Pallete', 'wcrop'),
            ),
            'desc_tip' => true,
        );

        $wcrop_settings_array[] = array(
            'title' => __('image border for notifications', 'wcrop'),
            'desc' => __('select prefer image border according to the theme', 'wcrop'),
            'type' => 'select',
            'default' => 'rounded',
            'id' => 'wcrop_image_border',
            'options'  => array(
                'rounded'  => __('Rounded Border(Default)', 'wcrop'),
                'corner'   => __('Corner Border', 'wcrop'),
            ),
            'desc_tip' => true,
        );

        $wcrop_settings_array[] = array(
            'title' => __('Custom Background color', 'wcrop'),
            'desc' => __('pick the background color from the color palette according to the theme', 'wcrop'),
            'type' => 'color',
            'default' => '#ffffff',
            'id' => 'wcrop_popup_bg_color',
            'desc_tip' => true,
        );

        $wcrop_settings_array[] = array(
            'title' => __('Custom Text color', 'wcrop'),
            'desc' => __('pick the text color from the color palette according to the theme', 'wcrop'),
            'type' => 'color',
            'default' => '#222222',
            'id' => 'wcrop_popup_text_color',
            'desc_tip' => true,
        );

        $wcrop_settings_array[] = array(
            'title' => __('Custom Border color', 'wcrop'),
            'desc' => __('pick the Border color from the color palette according to the theme', 'wcrop'),
            'type' => 'color',
            'default' => '#dddddd',
            'id' => 'wcrop_popup_border_color',
            'desc_tip' => true,
        );

        $wcrop_settings_array[] = array(
            'type' => 'sectionend',
            'id' => 'wcrop_theme_settings_end'
        );

        // error_log("WCROP: wcrop_add_admin_settings() fired\n");

        return $wcrop_settings_array;
    }

    public function wcrop_add_settings_tab(array $tabs): array
    {
        error_log('WCROP: wcrop_add_settings_tab() fired');

        $tabs['wcrop_settings'] = __('Recent-Orders', 'wcrop');

        error_log('WCROP: Tab added to settings array');

        return $tabs;
    }

    public function wcrop_display_setttings_tab_content(): void
    {
        error_log("WCROP: wcrop_display_setttings_tab_content() fired\n");
?>
        <div class="wcwm-settings-header" style="background:#fff; padding: 15px; border:1px solid #ccc; border-left:4px solid #25D366; margin: bottom 20px;">
            <h2 style="margin:0 0 5px 0; "><?php _e('Recent Order Notification', 'woocommerce-recent-order-notification'); ?></h2>
            <p style="margin:0;"><?php _e('Need assistance? Check out our <a href="#" target="_blank">Documentation</a> or submit a <a href="#" target="_blank">Support Ticket</a>.', 'woocommerce-whatsapp-message'); ?></p>
        </div>
        <?php

        woocommerce_admin_fields($this->wcrop_add_admin_settings());
    }

    public function wcrop_save_settings(): void
    {
        error_log("WCROP: wcrop_save_settings() fired\n");
        woocommerce_update_options($this->wcrop_add_admin_settings());
    }

    /** 
     * action: admin_footer
     */
    public function wcrop_enhance_footer_colors()
    {
        $screen = get_current_screen();

        if ($screen && strpos($screen->id, 'woocommerce') !== false) {
        ?>
            <script type="text/javascript">
                document.addEventListener('DOMContentLoaded', function() {

                    const colorInputs = document.getElementById('colorpicker, input[type="color"]');

                    colorInputs.forEach(function(inputs) {
                        input.addEventListener("input", function(e) {
                            input.setAttribute("value", e.target.value);
                        });
                    });
                })
            </script>
<?php
        }
    }
}
