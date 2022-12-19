<?php

namespace Wlt\App;

use Wlt\App\Controllers\Controller;

defined('ABSPATH') or die();

class Router
{
    private static $controller;
    protected static $active_plugin_list = array();

    public function initHooks()
    {
        if (is_admin() && $this->isPluginIsActive('wp-loyalty-rules/wp-loyalty-rules.php')) {
            self::$controller = empty(self::$controller) ? new Controller() : self::$controller;
            add_action('admin_menu', array(self::$controller, 'adminMenu'));
            if ($this->isPluginIsActive('loco-translate/loco.php')) {
                add_filter('loco_extracted_template', array(self::$controller, 'addCustomString'), 10, 2);
            }
        }
    }

    protected function getActivePlugins()
    {
        if (empty(self::$active_plugin_list)) {
            $active_plugins = apply_filters('active_plugins', get_option('active_plugins', array()));
            if (is_multisite()) {
                $active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
            }
            self::$active_plugin_list = $active_plugins;
        }
        return self::$active_plugin_list;
    }

    protected function isPluginIsActive($plugin = '')
    {
        if (empty($plugin) || !is_string($plugin)) {
            return false;
        }
        $active_plugins = $this->getActivePlugins();
        if (in_array($plugin, $active_plugins, false) || array_key_exists($plugin, $active_plugins)) {
            return true;
        }
        return false;
    }

}