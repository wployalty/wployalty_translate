<?php

namespace Wlt\App;

use Wlt\App\Controllers\Controller;

defined( 'ABSPATH' ) or die();

class Router {
	private static $controller;

	public function initHooks() {
		self::$controller = empty( self::$controller ) ? new Controller() : self::$controller;
		add_filter( 'wlr_loyalty_apps', array( self::$controller, 'getAppDetails' ) );
		if ( is_admin() && ( self::$controller->isPluginIsActive( 'wployalty/wp-loyalty-rules-lite.php' ) || self::$controller->isPluginIsActive( 'wp-loyalty-rules/wp-loyalty-rules.php' ) || self::$controller->isPluginIsActive( 'wp-loyalty-rules-lite/wp-loyalty-rules-lite.php' ) ) ) {
			add_action( 'admin_menu', array( self::$controller, 'adminMenu' ) );
			add_action( 'admin_footer', array( self::$controller, 'menuHide' ) );
			add_action( 'admin_enqueue_scripts', array( self::$controller, 'adminScripts' ), 100 );

			if ( self::$controller->isPluginIsActive( 'loco-translate/loco.php' ) ) {
				add_filter( 'loco_extracted_template', array( self::$controller, 'addCustomString' ), 10, 2 );
			}
			if ( self::$controller->isPluginIsActive( 'wpml-string-translation/plugin.php' ) ) {
				add_action( 'wp_ajax_wlt_add_dynamic_string', array( self::$controller, 'addWPMLCustomString' ) );
			}
		}
	}
}