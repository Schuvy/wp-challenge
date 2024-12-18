<?php

namespace CustomShippingDiscounts\Classes;

if (!defined('ABSPATH')) {
    exit;
}

class Shipping_Discount_Calculator {

    /**
     * Calculate the shipping discount based on cart totals.
     *
     * @param float $shipping_cost Original shipping cost.
     * @param float $cart_total    Cart total amount.
     *
     * @return float Modified shipping cost.
     */
    public function calculate_discounted_shipping(float $shipping_cost, float $cart_total): float {
        $final_shipping_cost = $shipping_cost;

        if ($cart_total > 200) {
            $final_shipping_cost -= $shipping_cost * 0.025;
        } elseif ($cart_total > 150) {
            $final_shipping_cost -= $shipping_cost * 0.05;
        } elseif ($cart_total > 100) {
            $final_shipping_cost -= $shipping_cost * 0.1;
        }

        return apply_filters('custom_shipping_discounts_calculate_discounted_shipping', $final_shipping_cost, $shipping_cost, $cart_total);
    }
}