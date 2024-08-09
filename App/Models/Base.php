<?php
/**
 * @author      Wployalty (Alagesan)
 * @license     http://www.gnu.org/licenses/gpl-2.0.html
 * @link        https://www.wployalty.net
 * */

namespace Wlt\App\Models;

defined( 'ABSPATH' ) or die();

abstract class Base {
	static protected $db;
	protected $table = null;

	function __construct() {
		global $wpdb;
		self::$db = $wpdb;
	}

	function getAll( $select = '*' ) {
		if ( is_array( $select ) || is_object( $select ) ) {
			$select = implode( ',', $select );
		}
		if ( empty( $select ) ) {
			$select = '*';
		}
		$query = "SELECT {$select} FROM {$this->table};";

		return self::$db->get_results( $query, OBJECT );
	}
}