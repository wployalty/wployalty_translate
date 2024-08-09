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
    wlt_jquery(document).on('click', '#wlt_update_wpml_string', function (e) {
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
                    createToast(json.message, 'wlr-success');
                } else {
                    createToast(json.message, 'wlr-error');
                }
                wlt_jquery('#wlt_update_wpml_string').removeAttr('disabled');
            }
        });
    });
})(wlt_jquery);