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

if (!defined('ABSPATH')) {
    exit; // Don't access directly.
};

use WP_User;

/**
 * Class BuyNowHelpers
 * @package Testcorp\BuyNow\Frontend
 */
class BuyNowHelpers
{
    /**
     * @return \WP_User|null
     */
    public function getCustomerInfo()
    {
        $current_user = null;

        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
        }

        return $current_user;
    }

    /**
     * Return User fullname or first name or system (display_name) name
     * if User ID not set current logged in user will return
     *
     * @param null $user_id
     * @return string
     */
    public function getCustomerFullName($user_id = null)
    {
        $user_info = !empty($user_id) ? new WP_User($user_id) : wp_get_current_user();

        if ($user_info->first_name) {

            if ($user_info->last_name) {
                return $user_info->first_name . ' ' . $user_info->last_name;
            }

            return $user_info->first_name;
        }

        return $user_info->display_name;
    }

    /**
     * Create Array of required Customer Address data for order
     *
     * @param $fname
     * @param $lname
     * @param $email
     * @return array
     */
    public function createAddressArray($fname, $lname, $email)
    {
        $address = [];

        if ($fname && $lname && $email)
            $address = [
                'first_name' => $fname,
                'last_name' => $lname,
                'email' => $email,
            ];

        return $address;
    }
}
