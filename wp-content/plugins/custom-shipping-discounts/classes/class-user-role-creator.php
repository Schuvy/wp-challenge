<?php

namespace CustomShippingDiscounts\Classes;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class User_Role_Creator
 *
 * Responsible for ensuring the 'free_shipping' user role exists.
 */
class User_Role_Creator {

    /**
     * Ensure the free_shipping role is created if it doesn't exist.
     *
     * @return void
     */
    public static function register_vip_role(): void {
        if (!get_role('vip_customer')) {
            add_role(
                'vip_customer',
                __('VIP Customer', 'custom-shipping-discounts'),
                [
                    'read' => true,
                ]
            );
        }
    }
}