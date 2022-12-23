<?php
/**
 * @author      Wployalty (Alagesan)
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
 * @link        https://www.wployalty.net
 * */
defined('ABSPATH') or die;
?>
<div id="wlt-main">
    <div class="wlt-main-header">
        <h1><?php echo WLT_PLUGIN_NAME; ?> </h1>
        <div><b><?php echo "v" . WLT_PLUGIN_VERSION; ?></b></div>
    </div>
    <div class="wlt_content">
        <div class="wlt-sections">
            <div class="title">
                <h3><?php _e('Loco translate', 'wp-loyalty-translate'); ?></h3>
            </div>
            <div class="content">
                <p><?php _e('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet cumque eaque, facilis laboriosam mollitia natus nobis perferendis possimus quas totam? Asperiores in ipsam omnis provident? Ad adipisci animi minus tempora.', 'wp-loyalty-translate'); ?></p>
            </div>
        </div>
        <div class="wlt-sections">
            <div class="title">
                <h3><?php _e('WPML translate', 'wp-loyalty-translate'); ?></h3>
            </div>
            <div class="content">
                <p><?php _e('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet cumque eaque, facilis laboriosam mollitia natus nobis perferendis possimus quas totam? Asperiores in ipsam omnis provident? Ad adipisci animi minus tempora.', 'wp-loyalty-translate'); ?></p>
                <?php if (isset($is_wpml_translate_string_available) && $is_wpml_translate_string_available): ?>
                   <div class="wlt_button">
                    <a class="wlt_wpml_button" id="wlt_update_wpml_string"
                       onclick="wlt.updateWPMLTranslation()"><?php _e('Update Dynamic String for WPML', 'wp-loyalty-translate'); ?></a>
                   </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>