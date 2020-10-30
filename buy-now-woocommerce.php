<?php

use Testcorp\BuyNow\BuyNowPlugin;

/**
 * Buy Now for WooCommerce
 *
 * @package           BuyNowForWooCommerce
 * @author            Anatolii S.
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Buy Now for WooCommerce
 * Plugin URI:        https://premmerce.com
 * Description:       Test task: add Buy Now button to product page (buy in one click)
 * Version:           1.0.0
 * Requires at least: 5.0
 * Requires PHP:      7.2
 * Author:            Anatolii S.
 * Author URI:        https://premmerce.com
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       buy-now-woocommerce
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) {
    exit; // Don't access directly.
};


if (defined('BN_VERSION')) {
    // The user is attempting to activate a second plugin instance.
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    require_once ABSPATH . 'wp-includes/pluggable.php';
    if (is_plugin_active(plugin_basename(__FILE__))) {
        deactivate_plugins(plugin_basename(__FILE__)); // Deactivate this plugin.
        // Inform that the plugin is deactivated.
        wp_safe_redirect(add_query_arg('deactivate', 'true', remove_query_arg('activate')));
        exit;
    }
}

define('BN_VERSION', '1.0.0');

define('BN_REQUIRED_WP_VERSION', '5.0');

define('BN_REQUIRED_PHP_VERSION', '7.2');

define('BN_WC_REQUIRED_VERSION', '4.5');

define('BN_PLUGIN_DIR', plugin_dir_path(__FILE__));

/**
 * Check for required PHP version
 */
if (version_compare(PHP_VERSION, BN_REQUIRED_PHP_VERSION, '<')) {
    exit(esc_html(sprintf('Buy Now for WooCommerce requires PHP ' . BN_REQUIRED_PHP_VERSION . ' or higher. You’re still on %s.', PHP_VERSION)));
}

/**
 * Check for required Wordpress version
 */
if (version_compare(get_bloginfo('version'), BN_REQUIRED_WP_VERSION, '<')) {
    exit(esc_html(sprintf('Buy Now for WooCommerce requires Wordpress ' . BN_REQUIRED_WP_VERSION . ' or higher. You’re still on %s.', get_bloginfo('version'))));
}

/**
 * Check if WooCommerce is installed and active && current version >=
 * according to https://docs.woocommerce.com/document/create-a-plugin/
 **/
if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    exit('WooCommerce must be installed and activated!');
}

if (defined('WC_VERSION') && version_compare(WC_VERSION, BN_WC_REQUIRED_VERSION, '<')) {
    exit(esc_html(sprintf('Buy Now for WooCommerce requires WooCommerce ' . BN_WC_REQUIRED_VERSION . ' or higher. You’re still on %s.', WC_VERSION)));
}

call_user_func(function () {

    if (file_exists(BN_PLUGIN_DIR . 'vendor/autoload.php')) {
        require_once BN_PLUGIN_DIR . 'vendor/autoload.php';
    }

    if (class_exists('Testcorp\\BuyNow\\BuyNowPlugin')) {

        $main = new BuyNowPlugin(__FILE__);

        register_activation_hook(__FILE__, [$main, 'activate']);

        register_deactivation_hook(__FILE__, [$main, 'deactivate']);

        register_uninstall_hook(__FILE__, [BuyNowPlugin::class, 'uninstall']);

        $main->run();
    }

});
