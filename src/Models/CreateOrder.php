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

namespace Testcorp\BuyNow\Models;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Class CreateOrder
 * @package Testcorp\BuyNow\Models
 */
class CreateOrder
{
    /**
     * CreateOrder constructor.
     * @param $product_id
     * @param $customer_id
     * @param $address
     * @param $qty
     * @throws \WC_Data_Exception
     */
    public function __construct($product_id, $customer_id, $address, $qty)
    {
        $order = wc_create_order();
        $product = wc_get_product($product_id);

        $order->add_product($product, $qty);
        $order->set_customer_id($customer_id);
        $order->set_created_via('buy-now');
        $order->set_address($address, 'billing');
        $order->set_address($address, 'shipping');
        $order->set_payment_method('check');
        $order->calculate_totals();
        $order->update_status("on-hold", 'Buy Now BTN', TRUE);
        $order->save();
    }

}
