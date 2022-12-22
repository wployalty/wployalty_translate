<?php
/**
 * @author      Wployalty (Alagesan)
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
 * @link        https://www.wployalty.net
 * */
defined('ABSPATH') or die;
?>
<div id="wlt-main">
    <div class="wlt_content">

        <?php if (isset($is_wpml_translate_string_available) && $is_wpml_translate_string_available): ?>
            <a class="wlt_wpml_button" id="wlt_update_wpml_string"
               onclick="wlt.updateWPMLTranslation()"><?php _e('Update Dynamic String for WPML', 'wp-loyalty-translate'); ?></a>
        <?php endif; ?>
    </div>
</div>