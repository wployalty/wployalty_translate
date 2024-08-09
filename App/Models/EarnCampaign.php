<?php
/**
 * @author      Wployalty (Alagesan)
 * @license     http://www.gnu.org/licenses/gpl-2.0.html
 * @link        https://www.wployalty.net
 * */

namespace Wlt\App\Models;

defined( 'ABSPATH' ) or die();

class EarnCampaign extends Base {
	function __construct() {
		parent::__construct();
		$this->table = self::$db->prefix . 'wlr_earn_campaign';
	}
}