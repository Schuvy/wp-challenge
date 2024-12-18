<?php

namespace CustomShippingDiscounts\Classes;

use Exception;
use WC_Shipping_Free_Shipping;
use WC_Shipping_Rate;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class Shipping_Discount_Handler
 *
 * Interacts with WooCommerce hooks, retrieves data, and uses Shipping_Discount_Calculator
 * and User_Role_Checker to adjust shipping rates accordingly.
 */
class Shipping_Discount_Handler {

    protected Shipping_Discount_Calculator $calculator;
    protected User_Role_Checker $role_checker;

    /**
     * Shipping_Discount_Handler constructor.
     *
     * @param Shipping_Discount_Calculator $calculator
     * @param User_Role_Checker $role_checker
     */
    public function __construct(Shipping_Discount_Calculator $calculator, User_Role_Checker $role_checker) {
        $this->calculator = $calculator;
        $this->role_checker = $role_checker;
    }

    /**
     * Initialize the handler.
     *
     * @return void
     */
    public function init(): void {
        add_filter('woocommerce_package_rates', [$this, 'adjust_shipping_rates']);
    }

    /**
     * Adjust the shipping rates based on cart total and user role.
     *
     * @param array $rates Array of shipping rates.
     *
     * @return array Modified array of shipping rates.
     */
    public function adjust_shipping_rates(array $rates): array {
        try {
            if (!WC()->cart) {
                return $rates;
            }

            // If user has free shipping role, return free shipping rate
            if ($this->role_checker->user_has_free_shipping_role()) {
                return $this->get_free_shipping_rate();
            }

            $cart_total = WC()->cart->get_subtotal();

            foreach ($rates as $rate) {
                $original_cost = (float) $rate->cost;
                $rate->cost = $this->calculator->calculate_discounted_shipping($original_cost, $cart_total);
            }

            return $rates;
        } catch (Exception $e) {
            error_log('Custom shipping discounts error: ' . $e->getMessage());

            return $rates;
        }
    }

    /**
     * Return a free shipping rate array.
     *
     * @return array
     */
    protected function get_free_shipping_rate(): array {
        $free_shipping_method = new WC_Shipping_Free_Shipping();

        return [
            new WC_Shipping_Rate(
                $free_shipping_method->get_rate_id(),
                $free_shipping_method->get_method_title(),
                0,
                [],
            )
        ];
    }
}
