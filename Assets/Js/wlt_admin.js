/**
 * @author      Flycart (Alagesan)
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
 * @link        https://www.flycart.org
 * */

if (typeof (wlt_jquery) == 'undefined') {
    wlt_jquery = jQuery.noConflict();
}
wlt = window.wlt || {};

(function (wlt) {
    wlt.updateWPMLTranslation = function () {
        alertify.set('notifier', 'position', 'top-right');
        let data = {
            action: 'wlt_add_dynamic_string',
            wlt_nonce: wlt_localize_data.common_nonce
        };
        wlt_jquery('#wlt_update_wpml_string').attr('disabled', true);
        wlt_jquery.ajax({
            type: "POST",
            url: wlt_localize_data.ajax_url,
            data: data,
            dataType: "json",
            before: function () {

            },
            success: function (json) {
                if (json.success) {
                    alertify.success(json.message);
                } else {
                    alertify.error(json.message);
                }
                wlt_jquery('#wlt_update_wpml_string').removeAttr('disabled');
            }
        });
    };
})(wlt_jquery);