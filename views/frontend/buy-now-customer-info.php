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

use Testcorp\BuyNow\BuyNowPlugin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

?>

    <div class="wrapper-user-info">
        <fieldset>
            <?php
            woocommerce_form_field('_customer_name', [
                'type' => 'text',
                'class' => ['customer-name'],
                'input_class' => ['customer-name-input'],
                'label' => '',
                'placeholder' => __('Enter your First Name.', BuyNowPlugin::DOMAIN),
                'required' => true,
                'autocomplete' => true,
                'custom_attributes' => $readonly,
            ], $customer_name);

            if (empty($customer_name)) {
                woocommerce_form_field('_customer_surname', [
                    'type' => 'text',
                    'class' => ['customer-surname'],
                    'input_class' => ['customer-surname-input'],
                    'label' => '',
                    'placeholder' => __('Enter your Last Name.', BuyNowPlugin::DOMAIN),
                    'required' => true,
                    'autocomplete' => true
                ]);
            }

            woocommerce_form_field('_customer_email', [
                'type' => 'email',
                'class' => ['customer-email'],
                'input_class' => ['customer-email-input'],
                'label' => '',
                'placeholder' => __('Enter yur email.', BuyNowPlugin::DOMAIN),
                'required' => true,
                'autocomplete' => true,
                'validate' => ['validate-email'],
                'custom_attributes' => $readonly,
            ], $customer_email);
            ?>
        </fieldset>
    </div>
    <div id="order-response"></div>
    <style>.entry-summary .quantity {
            display: inline-block
        }

        #order-response {
            display: none;
            position: absolute;
            width: inherit;
            padding: 1em;
            text-align: center;
            color: #fff
        }</style>

<?php
