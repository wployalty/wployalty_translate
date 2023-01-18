<?php
/**
 * Plugin Name: WPLoyalty - dynamic string translation
 * Plugin URI: https://www.wployalty.net
 * Description: This add-on used to translate dynamic string for WPLoyalty and related add-on
 * Version: 1.0.0
 * Author: Wployalty
 * Slug: wp-loyalty-translate
 * Text Domain: wp-loyalty-translate
 * Domain Path: /i18n/languages/
 * Requires at least: 4.9.0
 * WC requires at least: 3.0.9
 * WC tested up to: 7.1
 * Contributors: Wployalty, Alagesan
 * Author URI: https://wployalty.net/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * WPLoyalty: 1.1.9
 */
defined('ABSPATH') or die;
defined('WLT_PLUGIN_NAME') or define('WLT_PLUGIN_NAME', 'WPLoyalty - Dynamic string translation');
defined('WLT_PLUGIN_VERSION') or define('WLT_PLUGIN_VERSION', '1.0.0');
defined('WLT_PLUGIN_SLUG') or define('WLT_PLUGIN_SLUG', 'wp-loyalty-translate');
defined('WLT_PLUGIN_URL') or define('WLT_PLUGIN_URL', plugin_dir_url(__FILE__));
// Define plugin path
defined('WLT_PLUGIN_PATH') or define('WLT_PLUGIN_PATH', __DIR__ . '/');
if (!function_exists('isWoocommerceActive')) {
    function isWoocommerceActive()
    {
        $active_plugins = apply_filters('active_plugins', get_option('active_plugins', array()));
        if (is_multisite()) {
            $active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
        }
        return in_array('woocommerce/woocommerce.php', $active_plugins, false) || array_key_exists('woocommerce/woocommerce.php', $active_plugins);
    }
}
if (!isWoocommerceActive()) return;
if (!function_exists('isWployaltyActiveOrNot')) {
    function isWployaltyActiveOrNot()
    {
        $active_plugins = apply_filters('active_plugins', get_option('active_plugins', array()));
        if (is_multisite()) {
            $active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
        }
        return in_array('wp-loyalty-rules/wp-loyalty-rules.php', $active_plugins, false) || array_key_exists('wp-loyalty-rules/wp-loyalty-rules.php', $active_plugins);
    }
}
if (isWployaltyActiveOrNot()) {
    if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
        return;
    } else {
        require __DIR__ . '/vendor/autoload.php';
    }
    if (class_exists(\Wlt\App\Router::class)) {
        $plugin = new \Wlt\App\Router();
        if (method_exists($plugin, 'initHooks')) $plugin->initHooks();
    }
}