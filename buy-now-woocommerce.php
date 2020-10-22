<?php

use Testcorp\BuyNow\BuyNowPlugin;

/**
 *
 * Plugin Name:       Buy Now for WooCommerce
 * Plugin URI:        https://premmerce.com
 * Description:       Test task: add Buy Now button to product page (buy in one click)
 * Version:           1.0
 * Author:            Anatolii S.
 * Author URI:        https://premmerce.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       buy-now-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

call_user_func( function () {

	require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

	$main = new BuyNowPlugin( __FILE__ );

	register_activation_hook( __FILE__, [ $main, 'activate' ] );

	register_deactivation_hook( __FILE__, [ $main, 'deactivate' ] );

	register_uninstall_hook( __FILE__, [ BuyNowPlugin::class, 'uninstall' ] );

	$main->run();
} );