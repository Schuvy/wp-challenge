<?php

namespace CustomShippingDiscounts;

use CustomShippingDiscounts\Classes\Shipping_Discount_Handler;
use CustomShippingDiscounts\Classes\Shipping_Discount_Calculator;
use CustomShippingDiscounts\Classes\User_Role_Creator;
use CustomShippingDiscounts\Classes\User_Role_Checker;
use Exception;

/**
 * Plugin Name: Custom Shipping Discounts
 * Plugin URI:  https://example.com
 * Description: Applies custom shipping discounts based on cart total and user roles.
 * Version:     1.0.0
 * Author:      Farid Torres
 * Author URI:  https://example.com
 * License:     GPL2
 * Text Domain: custom-shipping-discounts
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Check WooCommerce dependency
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    require_once plugin_dir_path(__FILE__) . 'classes/class-shipping-discount-calculator.php';
    require_once plugin_dir_path(__FILE__) . 'classes/class-shipping-discount-handler.php';
    require_once plugin_dir_path(__FILE__) . 'classes/class-user-role-creator.php';
    require_once plugin_dir_path(__FILE__) . 'classes/class-user-role-checker.php';

    register_activation_hook(__FILE__, static function() {
        User_Role_Creator::register_vip_role();
    });

    /**
     *  Initialize the plugin.
     */
    add_action('woocommerce_init', function() {
        try {
            $calculator = new Shipping_Discount_Calculator();
            $role_checker = new User_Role_Checker();
            $handler = new Shipping_Discount_Handler($calculator, $role_checker);

            $handler->init();
        } catch (Exception $e) {
            error_log('Custom shipping discounts error: ' . $e->getMessage());
        }
    });
}