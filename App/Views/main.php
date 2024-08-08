<?php
/**
 * @author      Wployalty (Alagesan)
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
 * @link        https://www.wployalty.net
 * */
defined( 'ABSPATH' ) or die;
?>
<div id="wlt-main">
    <div class="wlr-toast-notification"></div>
    <div class="wlt-main-header">
        <h1><?php echo WLT_PLUGIN_NAME; ?> </h1>
        <div><b><?php echo "v" . WLT_PLUGIN_VERSION; ?></b></div>
    </div>
    <div class="wlt_content">
        <div class="wlt-sections">
            <div class="title">
                <h3><?php _e( 'Loco Translate:', 'wp-loyalty-translate' ); ?></h3>
            </div>
            <div class="content">
                <!--<p><?php /*echo sprintf(__('You can now translate the dynamic content like Campaign title, descriptions, reward title, description, content inside the Launcher widget easily. Follow this step by step guide for <a href="%s" target="_blank">translating the strings with LocoTranslate</a>', 'wp-loyalty-translate'), 'https://docs.wployalty.net/quick-start-guides/translating-wployalty-with-locotranslate'); */ ?></p>-->
                <p><?php echo __( 'You can now translate the dynamic content like Campaign title, descriptions, reward title, description, content inside the Launcher widget easily.',
						'wp-loyalty-translate' ); ?></p>
            </div>
        </div>
        <div class="wlt-sections">
            <div class="title">
                <h3><?php _e( 'WPML Translate:', 'wp-loyalty-translate' ); ?></h3>
            </div>
            <div class="content">
                <!--<p><?php /*echo sprintf(__('You can now translate the dynamic content like Campaign title, descriptions, reward title, description, content inside the Launcher widget easily. Follow this step by step guide for <a href="%s" target="_blank">translating the strings with WPML</a>', 'wp-loyalty-translate'), 'https://docs.wployalty.net/translating-wployalty/translating-wployalty-strings-using-wpml'); */ ?></p>-->
                <p><?php echo __( 'You can now translate the dynamic content like Campaign title, descriptions, reward title, description, content inside the Launcher widget easily.',
						'wp-loyalty-translate' ); ?></p>
				<?php if ( isset( $is_wpml_translate_string_available ) && $is_wpml_translate_string_available ): ?>
                    <div class="wlt_button">
                        <a class="wlt_wpml_button" id="wlt_update_wpml_string"
                           style="background-color: #4747EB;padding: 8px 12px;color: #FFF;border-radius: 6px;"
                        ><?php _e( 'Update Dynamic String for WPML', 'wp-loyalty-translate' ); ?></a>
                    </div>
				<?php endif; ?>
            </div>
        </div>
    </div>
</div>