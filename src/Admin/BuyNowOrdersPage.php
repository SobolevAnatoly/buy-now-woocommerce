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

if (!defined('ABSPATH')) exit; // Exit if accessed directly;

use Testcorp\BuyNow\BuyNowPlugin;

/**
 * Class BuyNowOrdersPage
 * @package Testcorp\BuyNow\Admin
 */
class BuyNowOrdersPage
{

    /**
     * @var FileManager
     */
    private $fileManager;

    /**
     * @var Contain Table Data Object
     */
    public $orders_obj;

    /**
     * BuyNowOrdersPage constructor.
     * @param $fileManager
     */
    public function __construct($fileManager)
    {
        $this->setFileManager($fileManager);

        add_filter('set-screen-option', [__CLASS__, 'setScreen'], 10, 3);
        add_action('admin_menu', [$this, 'regBuyNowOrdersPage'], 99);
    }

    /**
     * @param $status
     * @param $option
     * @param $value
     * @return mixed
     */
    public static function setScreen($status, $option, $value)
    {
        return $value;
    }

    /**
     * Register WooCommerce sub menu page && hook screen options for orders table
     */
    public function regBuyNowOrdersPage()
    {
        $hook = add_submenu_page(
            'woocommerce',
            __('Buy Now Requests', BuyNowPlugin::DOMAIN),
            __('Buy Now', BuyNowPlugin::DOMAIN),
            'view_woocommerce_reports',
            'buy-now-reports-page',
            [$this, 'reportPageBuyNow']
        );
        add_action("load-$hook", [$this, 'screenOption']);
    }

    /**
     * Include template for plugin settings page
     * @template admin/buy-now-report-page.php
     */
    public function reportPageBuyNow()
    {
        $this->getFileManager()->includeTemplate('admin/buy-now-report-page.php', [
            'orders_obj' => $this->getOrdersObj(),
        ]);
    }

    /**
     * Screen options
     */
    public function screenOption()
    {
        $option = 'per_page';
        $args = [
            'label' => __('Orders', BuyNowPlugin::DOMAIN),
            'default' => 5,
            'option' => 'orders_per_page'
        ];
        add_screen_option($option, $args);

        $orders_obj = new OrdersListTable();
        $this->setOrdersObj($orders_obj);
    }

    /**
     * @return mixed
     */
    public function getOrdersObj()
    {
        return $this->orders_obj;
    }

    /**
     * @param mixed $orders_obj
     */
    public function setOrdersObj($orders_obj)
    {
        $this->orders_obj = $orders_obj;
    }

    /**
     * @param FileManager $fileManager
     */
    public function setFileManager($fileManager)
    {
        $this->fileManager = $fileManager;
    }

    /**
     * @return FileManager
     */
    public function getFileManager()
    {
        return $this->fileManager;
    }

}
