<?php
/**
 * @author      Wployalty (Alagesan)
 * @license     http://www.gnu.org/licenses/gpl-2.0.html
 * @link        https://www.wployalty.net
 * */

namespace Wlt\App\Helpers;

defined( 'ABSPATH' ) or die();

class Woocommerce {
	public static $instance = null;
	protected static $options = array();

	public static function hasAdminPrivilege() {
		if ( current_user_can( 'manage_woocommerce' ) ) {
			return true;
		} else {
			return false;
		}
	}

	public static function create_nonce( $action = - 1 ) {
		return wp_create_nonce( $action );
	}

	public static function verify_nonce( $nonce, $action = - 1 ) {
		if ( wp_verify_nonce( $nonce, $action ) ) {
			return true;
		} else {
			return false;
		}
	}

	public static function getInstance( array $config = array() ) {
		if ( ! self::$instance ) {
			self::$instance = new self( $config );
		}

		return self::$instance;
	}

	function isJson( $string ) {
		json_decode( $string );

		return ( json_last_error() == JSON_ERROR_NONE );
	}

	function getOptions( $key = '', $default = '' ) {
		if ( empty( $key ) ) {
			return array();
		}
		if ( ! isset( self::$options[ $key ] ) || empty( self::$options[ $key ] ) ) {
			self::$options[ $key ] = get_option( $key, $default );
		}

		return self::$options[ $key ];
	}
}