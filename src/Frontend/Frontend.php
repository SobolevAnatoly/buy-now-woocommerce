<?php namespace Testcorp\BuyNow\Frontend;

use Premmerce\SDK\V2\FileManager\FileManager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class Frontend
 *
 * @package Testcorp\BuyNow\Frontend
 */
class Frontend
{

    /**
     * @var FileManager
     */
    private $fileManager;

    /**
     * Frontend constructor.
     *
     * @param FileManager $fileManager
     */
    public function __construct(FileManager $fileManager)
    {
        $this->setFileManager($fileManager);

        add_action(
            'woocommerce_after_add_to_cart_button',
            [$this, 'addBuyNowButton'],
            20
        );
        add_action(
            'woocommerce_before_add_to_cart_form',
            [$this, 'customerInfo']
        );

        new EnqueueScripts($fileManager);
    }

    /**
     * Adding Buy Now button to frontend product page next to add to cart button
     */
    public function addBuyNowButton()
    {
        global $product;

        $state = $this->buttonActivationState($product->get_id());

        if (is_product() && $state === 'yes')
            $this->getFileManager()->includeTemplate('frontend/buy-now-btn.php', [
                'addUrl' => 'url-product-data-' . $product->get_id(),
                'product_id' => $product->get_id(),
                'product' => $product,
            ]);
    }

    /**
     * Adding User Info fields before add to cart form
     *
     * @template frontend/buy-now-customer-info.php
     */
    public function customerInfo()
    {

        global $product;
        $helpers = new BuyNowHelpers();

        $state = $this->buttonActivationState($product->get_id());

        if (is_product() && $state === 'yes') {
            $current_user = $helpers->getCustomerInfo();
            $customer_name = !empty($current_user) ? $helpers->getCustomerFullName($current_user->ID) : '';
            $customer_email = !empty($current_user) ? $current_user->user_email : '';
            $readonly = !empty($current_user) ? ['readonly' => 'readonly'] : [];

            $this->getFileManager()->includeTemplate('frontend/buy-now-customer-info.php', [
                'customer_name' => $customer_name,
                'customer_email' => $customer_email,
                'readonly' => $readonly,
            ]);
        }


    }

    /**
     * Check is Buy Now checkbox activated for current product
     * @param $product_id
     * @return mixed|string
     */
    public function buttonActivationState($product_id)
    {
        $product_attr = get_post_meta($product_id, '_buy_now', true);
        $product_attr = !empty($product_attr) ? $product_attr : 'no';

        return $product_attr;

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
