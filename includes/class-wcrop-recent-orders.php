<?php

if (!defined('ABSPATH')) {
    exit;
}

class WCROP_Recent_Orders
{


    public function check_new_orders()
    {
        error_log('WCROP: wcrop_check_new_orders() fired');

        check_ajax_referer('wcrop_recent_order_nonce', 'nonce');

        $last_order_id = isset($_POST['last_order_id']) ? intval($_POST['last_order_id']) : 0;

        $order_args = array(
            'limit' => 10,
            'order_by' => 'date',
            'order' => 'DESC'
        );

        $orders = wc_get_orders($order_args);


        $new_orders = array();

        $wc_orders_session = wc()->session->get('wcrop_orders', false);
        if ($wc_orders_session === false) {
            wc()->session->set('wcrop_orders', array());
        }


        foreach ($orders as $order) {
            if ($order->get_id() > $last_order_id) {
                $order_items = array();
                foreach ($order->get_items() as $order_item) {
                    $order_items[] = array(
                        'name' => $order_item->get_name(),
                        'quantity' => $order_item->get_quantity()
                    );
                }
                $new_orders[] = array(
                    'id' => $order->get_id(),
                    'customer' => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(),
                    'order_items' => $order_items,
                    'order_date' => $order->get_date_created()->date('Y-m-d H:i:s')
                );
            }
        }

        $new_orders = array_slice($new_orders, 0, 10, true);

        wc()->session->set('wcrop_orders', $new_orders);


        wp_send_json_success(
            array(
                'new_orders' => $new_orders,
                'last_order_id' => !empty($orders) ? $orders[0]->get_id() : $last_order_id
            )
        );
    }
}
