<?php

namespace CustomShippingDiscounts\Classes;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class User_Role_Checker
 *
 * Responsible for determining if a user has a specific role.
 */
class User_Role_Checker {

    /**
     * Check if the current user has a free shipping role.
     *
     * @return bool True if user has the role, false otherwise.
     */
    public function user_has_free_shipping_role(): bool {
        $user = wp_get_current_user();
        $roles = $user->roles;

        return !empty(array_intersect($roles, $this->get_free_shipping_roles()));
    }

    /**
     * Get the roles that qualify for free shipping.
     *
     * @return array
     */
    private function get_free_shipping_roles(): array {
        return apply_filters('custom_shipping_discounts_free_shipping_roles', ['vip_customer']);
    }
}