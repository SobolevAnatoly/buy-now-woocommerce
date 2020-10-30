<?php namespace Testcorp\BuyNow\Admin;

use Premmerce\SDK\V2\FileManager\FileManager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Class Admin
 *
 * @package Testcorp\BuyNow\Admin
 */
class Admin
{

    /**
     * @var FileManager
     */
    private $fileManager;

    /**
     * Admin constructor.
     *
     * Register menu items and handlers
     *
     * @param FileManager $fileManager
     */
    public function __construct(FileManager $fileManager)
    {
        $this->setFileManager($fileManager);

        add_filter('product_type_options', [$this, 'addBuyNowCheckbox'], 10, 1);
        add_action('woocommerce_process_product_meta', [$this, 'saveBuyNowCheckboxData'], 10, 3);

        new BuyNowOrdersPage($fileManager);

    }

    /**
     * Adding checkbox to product edit page
     *
     * @param $tabs
     * @return mixed
     */
    public function addBuyNowCheckbox($tabs)
    {
        $tabs['buy_now'] = [
            'id' => '_buy_now',
            'wrapper_class' => '',
            'label' => __('Buy Now', 'buy-now-woocommerce'),
            'description' => __('Add Button to by in one click', 'buy-now-woocommerce'),
            "default" => "no"
        ];

        return $tabs;
    }

    /**
     * Saving checkbox condition
     *
     * @param $post_id
     */
    public function saveBuyNowCheckboxData($post_id)
    {
        $buy_now_option = isset($_POST['_buy_now']) ? 'yes' : 'no';
        update_post_meta($post_id, '_buy_now', $buy_now_option);
    }

    /**
     * @return FileManager
     */
    public function getFileManager()
    {
        return $this->fileManager;
    }

    /**
     * @param FileManager $fileManager
     */
    public function setFileManager($fileManager)
    {
        $this->fileManager = $fileManager;
    }

}