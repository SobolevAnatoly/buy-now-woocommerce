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

namespace Testcorp\BuyNow\Admin;

use Testcorp\BuyNow\BuyNowPlugin;

if (!class_exists('WP_List_Table'))
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

class OrdersListTable extends \WP_List_Table
{
    public function __construct()
    {
        parent::__construct([
            'singular' => __('Order from Buy Now BTN', BuyNowPlugin::DOMAIN),
            'plural' => __('Orders from Buy Now BTN', BuyNowPlugin::DOMAIN),
            'ajax' => false,
        ]);
    }

    /**
     * Get all orders data created via 'buy-now' action
     *
     * @param int $per_page
     * @param int $page_number
     * @return \stdClass|\WC_Order[]
     */
    public function getOrders($per_page = 5, $page_number = 1)
    {
        $args = [
            'numberposts' => $per_page,
            'created_via' => 'buy-now',
            'paginate' => true,
            'limit' => $per_page,
            'offset' => ($page_number - 1) * $per_page,
            'orderby' => !empty($_REQUEST['orderby']) ? esc_sql($_REQUEST['orderby']) : 'date',
            'order' => !empty($_REQUEST['order']) ? esc_sql($_REQUEST['order']) : 'ASC',
            'return' => 'ids',
        ];
        $orders = wc_get_orders($args);


        return $orders;
    }

    /**
     * Create table data array from order data
     *
     * @param int $per_page
     * @param int $page_number
     * @return array
     */
    public function createOrdersArray($per_page = 5, $page_number = 1)
    {
        $orders = $this->getOrders($per_page, $page_number);
        $tableDataArray = [];

        foreach ($orders->orders as $order_id) {

            $order = wc_get_order($order_id);
            $customer = $order->get_user();

            if ($order->get_billing_first_name() && $order->get_billing_last_name()) {
                $fname = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
            } else {
                $fname = $customer->user_login;
            }

            $tableDataArray[] = [
                'product' => $this->getOrderItemName($order->get_items()),
                'email' => $order->get_billing_email(),
                'name' => $fname,
                'date' => $order->get_date_created()->date('d-m-Y H:i:s'),
                'order_number' => $order->get_order_number(),
                'order_url' => $order->get_edit_order_url(),
            ];
        }

        return $tableDataArray;
    }

    /**
     * Get product name from an order
     *
     * @param $items
     * @return string
     */
    public function getOrderItemName($items)
    {
        $product_name = '';
        foreach ($items as $item) {

            $product_name = $item->get_name();
        }

        return $product_name;
    }

    /**
     * Text displayed when no customer data is available
     */
    public function no_items()
    {
        _e('No orders created.', BuyNowPlugin::DOMAIN);
    }

    /**
     * Render Product column data
     * @param $item
     * @return string
     */
    function column_product($item)
    {

        $title = '<a href="' . $item['order_url'] . '">#' . $item['order_number'] . ' - ' . $item['product'] . '</a>';

        return $title;

    }

    /**
     * Render a column when no column specific method exist.
     *
     * @param array $item
     * @param string $column_name
     *
     * @return mixed
     */
    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'product':
            case 'email':
            case 'name':
            case 'date':
                return $item[$column_name];
            default:
                return print_r($item, true);
        }
    }

    /**
     *  Associative array of columns
     *
     * @return array
     */
    function get_columns()
    {
        $columns = [
            'product' => __('Product', BuyNowPlugin::DOMAIN),
            'email' => __('User Email', BuyNowPlugin::DOMAIN),
            'name' => __('User Name', BuyNowPlugin::DOMAIN),
            'date' => __('Date', BuyNowPlugin::DOMAIN)
        ];

        return $columns;
    }

    /**
     * Columns to make sortable.
     *
     * @return array
     */
    public function get_sortable_columns()
    {
        $sortable_columns = [
            'product' => ['product', false],
            'name' => ['name', false],
            'date' => ['date', true]
        ];

        return $sortable_columns;
    }

    /**
     * Handles data query and filter, sorting, and pagination.
     */
    public function prepare_items()
    {

        $this->_column_headers = $this->get_column_info();

        $per_page = $this->get_items_per_page('orders_per_page', 5);
        $current_page = $this->get_pagenum();
        $total_items = $this->getOrders()->total;

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page' => $per_page
        ]);

        $this->items = $this->createOrdersArray($per_page, $current_page);
    }

}
