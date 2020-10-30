<?php
/**
 * Copyright (c) 2020 Anatolii S.
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace Testcorp\BuyNow\Frontend;

use Testcorp\BuyNow\Models\CreateOrder;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Class AjaxHandlers
 * @package Testcorp\BuyNow\Frontend
 */
class AjaxHandlers
{
    /**
     * AjaxHandlers constructor.
     */
    public function __construct()
    {
        if (wp_doing_ajax()) {
            add_action(
                'wp_ajax_doFastOrder',
                [$this, 'doFastOrder']
            );

            add_action(
                'wp_ajax_nopriv_doFastOrder',
                [$this, 'doFastOrder']
            );
        }
    }

    /**
     * Ajax Handler
     * @throws \WC_Data_Exception
     */
    public function doFastOrder()
    {
        /**
         * Security check of ajax nonce code
         */
        check_ajax_referer('buy-now-ajax-nonce', 'nonce_code');

        $helpers = new BuyNowHelpers();

        /**
         * Get current user object
         */
        $current_user = $helpers->getCustomerInfo();

        /**
         * Ajax Handler
         */
        if (!empty($_POST)) {
            /**
             * Get order info from ajax request
             *
             * @var  $product_id
             * @var  $customerEmail
             * @var  $productQty
             */
            $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
            $customerEmail = filter_input(INPUT_POST, 'customer_email', FILTER_SANITIZE_EMAIL);
            $productQty = filter_input(INPUT_POST, 'qty', FILTER_SANITIZE_NUMBER_INT);

            /**
             * Check is $current_user contain user object
             */
            if (!empty($current_user)) {

                /**
                 * Get customer address array
                 */
                $address = $helpers->createAddressArray($current_user->first_name, $current_user->last_name, $current_user->user_email);

                /**
                 *  Programmatically create a new order
                 */
                new CreateOrder($product_id, $current_user->ID, $address, $productQty);

                /**
                 * Sending response
                 */
                wp_send_json_success(
                    wp_json_encode(
                        ['User' => 'Exist and logged in', 'ID' => $current_user->ID, 'email' => $current_user->user_email]
                    )
                );

                wp_die();
            }

            /**
             * Get user object by specified email
             */
            $user = get_user_by('email', $customerEmail);
            /**
             * Check is user with this email exists & $user contain user object
             */
            if (!empty($user)) {

                /**
                 * Get customer address array
                 */
                $address = $helpers->createAddressArray($user->first_name, $user->last_name, $user->user_email);

                /**
                 *  Programmatically create a new order
                 */
                new CreateOrder($product_id, $user->ID, $address, $productQty);

                /**
                 * Sending response
                 */
                wp_send_json_success(
                    wp_json_encode(
                        ['User' => 'Exist but not logged in', 'ID' => $user->ID, 'email' => $user->user_email]
                    )
                );
            } else {

                /**
                 * It's a new customer then create account & get new user ID
                 * @var  $result
                 */
                $result = wc_create_new_customer($customerEmail);

                /**
                 * Get user full name from ajax request
                 * @var  $first_name
                 * @var  $last_name
                 */
                $first_name = filter_input(INPUT_POST, 'customer_name', FILTER_SANITIZE_STRING);
                $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);

                /**
                 * Updating new user account by adding first name & last name to profile
                 * @var  $user_id
                 */
                $user_id = wp_update_user([
                    'ID' => $result,
                    'first_name' => $first_name,
                    'last_name' => $last_name
                ]);

                /**
                 * Check is new user account update successfully
                 * Terminate if error
                 */
                if (is_wp_error($user_id))
                    wp_die();
                /**
                 * Updating new user billing info by adding first name & last name
                 */
                update_user_meta($user_id, "billing_first_name", $first_name);
                update_user_meta($user_id, "billing_last_name", $last_name);

                /**
                 * Get user object by new user ID
                 * @var  $user
                 */
                $user = get_user_by('ID', $result);

                /**
                 * Get customer address array
                 */
                $address = $helpers->createAddressArray($user->first_name, $user->last_name, $user->user_email);

                /**
                 *  Programmatically create a new order
                 */
                new CreateOrder($product_id, $user->ID, $address, $productQty);

                /**
                 * Sending response
                 */
                wp_send_json_success(
                    wp_json_encode(
                        ['User' => 'Not registered - New customer will be created', 'ID' => $user->ID, 'email' => $user->user_email]
                    )
                );
            }

        }
        wp_die();

    }


}