<?php

namespace Wlt\App\Controllers;

use Wlr\App\Helpers\Input;
use Wlr\App\Helpers\Template;
use Wlr\App\Helpers\Woocommerce;
use Wlr\App\Models\EarnCampaign;
use Wlr\App\Models\Levels;
use Wlr\App\Models\Rewards;

class Controller
{
    protected static $active_plugin_list = array();

    function adminMenu()
    {
        if (Woocommerce::hasAdminPrivilege()) {
            add_menu_page(__('WPLoyalty: Translate', 'wp-loyalty-translate'), __('WPLoyalty: Translate', 'wp-loyalty-translate'), 'manage_woocommerce', WLT_PLUGIN_SLUG, array($this, 'addMenu'), 'dashicons-megaphone', 57);
        }
    }

    function removeAdminNotice()
    {
        remove_all_actions('admin_notices');
    }

    function adminScripts()
    {
        if (!Woocommerce::hasAdminPrivilege()) {
            return;
        }
        $input_helper = new Input();
        if ($input_helper->get('page', NULL) != WLT_PLUGIN_SLUG) {
            return;
        }
        $this->removeAdminNotice();
        wp_register_style(WLR_PLUGIN_SLUG . '-alertify', WLR_PLUGIN_URL . 'Assets/Admin/Css/alertify.min.css', array(), WLR_PLUGIN_VERSION . '&t=' . time());
        wp_enqueue_style(WLR_PLUGIN_SLUG . '-alertify');
        wp_register_script(WLR_PLUGIN_SLUG . '-alertify', WLR_PLUGIN_URL . 'Assets/Admin/Js/alertify.min.js', array(), WLR_PLUGIN_VERSION . '&t=' . time());
        wp_enqueue_script(WLR_PLUGIN_SLUG . '-alertify');
        wp_register_style(WLT_PLUGIN_SLUG . '-wlt-style', WLT_PLUGIN_URL . 'Assets/Css/wlt_admin.css', array(), WLT_PLUGIN_VERSION . '&t=' . time());
        wp_enqueue_style(WLT_PLUGIN_SLUG . '-wlt-style');
        wp_register_script(WLT_PLUGIN_SLUG . '-wlt-admin', WLT_PLUGIN_URL . 'Assets/Js/wlt_admin.js', array(), WLT_PLUGIN_VERSION . '&t=' . time());
        wp_enqueue_script(WLT_PLUGIN_SLUG . '-wlt-admin');
        $localize = array(
            'admin_url' => admin_url(),
            'common_nonce' => Woocommerce::create_nonce('wlt_common_nonce'),
            'ajax_url' => admin_url('admin-ajax.php'),
        );
        wp_localize_script(WLT_PLUGIN_SLUG . '-wlt-admin', 'wlt_localize_data', $localize);
    }

    function addMenu()
    {
        if (!Woocommerce::hasAdminPrivilege()) {
            wp_die(__("Don't have access permission", 'wp-loyalty-translate'));
        }
        $input_helper = new Input();
        if ($input_helper->get('page', NULL) != WLT_PLUGIN_SLUG) {
            wp_die(__('Unable to process', 'wp-loyalty-translate'));
        }
        if (class_exists(Template::class)) {
            $template = new Template();
            $data = array(
                'is_wpml_translate_string_available' => $this->isPluginIsActive('wpml-string-translation/plugin.php')
            );
            $template->setData(WLT_PLUGIN_PATH . 'App/Views/main.php', $data);
            $template->display();
        }
    }

    protected function getPointRule($campaign, $translate_strings, &$new_custom_strings)
    {
        if (!is_object($campaign)) {
            return new \stdClass();
        }
        $point_rule = isset($campaign->point_rule) && Woocommerce::getInstance()->isJson($campaign->point_rule) ? json_decode($campaign->point_rule) : new \stdClass();
        foreach ($translate_strings as $point_rule_key) {
            if (is_object($point_rule) && isset($point_rule->$point_rule_key) && !empty($point_rule->$point_rule_key)) {
                $new_custom_strings[] = $point_rule->$point_rule_key;
            }
        }
    }

    protected function getBasicTranslation($object, $allowed_strings, &$new_custom_strings)
    {
        if (!is_object($object) || !is_array($allowed_strings)) {
            return new \stdClass();
        }
        foreach ($allowed_strings as $key) {
            if (!in_array($key, $new_custom_strings) && isset($object->$key) && !empty($object->$key)) {
                $new_custom_strings[] = $object->$key;
            }
        }
    }

    function getCampaignStrings(&$new_custom_strings)
    {
        if (class_exists('\Wlr\App\Models\EarnCampaign')) {
            $campaign_model = new EarnCampaign();
            $campaign_list = $campaign_model->getAll('*');
            $campaign_allowed_string = array(
                'name', 'description'
            );
            foreach ($campaign_list as $campaign) {
                if (!is_object($campaign) || !isset($campaign->action_type)) {
                    continue;
                }
                $this->getBasicTranslation($campaign, $campaign_allowed_string, $new_custom_strings);
                $campaign_strings = array();
                switch ($campaign->action_type) {
                    case 'point_for_purchase':
                        $campaign_strings = array('variable_product_message', 'single_product_message');
                        break;
                    case 'signup':
                        $campaign_strings = array('signup_message');
                        break;
                    case 'product_review':
                        $campaign_strings = array('review_message');
                        break;
                    case 'facebook_share':
                    case 'twitter_share':
                    case 'whatsapp_share':
                        $campaign_strings = array('share_message');
                        break;
                    case 'email_share':
                        $campaign_strings = array('share_body', 'share_subject');
                        break;
                }
                if (!empty($campaign_strings)) {
                    $this->getPointRule($campaign, $campaign_strings, $new_custom_strings);
                }
            }
        }
    }

    function getRewardStrings(&$new_custom_strings)
    {
        if (class_exists('\Wlr\App\Models\Rewards')) {
            $reward_model = new Rewards();
            $reward_list = $reward_model->getAll('*');
            $allowed_string = array(
                'name', 'description', 'display_name'
            );
            foreach ($reward_list as $reward) {
                if (!is_object($reward) || !isset($reward->action_type)) {
                    continue;
                }
                $this->getBasicTranslation($reward, $allowed_string, $new_custom_strings);
            }
        }

    }

    function getLevelStrings(&$new_custom_strings)
    {
        if (class_exists('\Wlr\App\Models\Levels')) {
            $level_model = new Levels();
            $levels = $level_model->getAll('*');
            $allowed_string = array(
                'name', 'description'
            );
            foreach ($levels as $level) {
                if (!is_object($level) || !isset($level->action_type)) {
                    continue;
                }
                $this->getBasicTranslation($level, $allowed_string, $new_custom_strings);
            }
        }
    }

    function getSettingsStrings(&$new_custom_strings)
    {
        if (class_exists('\Wlr\App\Helpers\Woocommerce')) {
            $woocommerce_helper = Woocommerce::getInstance();
            $options = $woocommerce_helper->getOptions('wlr_settings');
            if (!is_array($options)) {
                return;
            }
            $allowed_strings = array('wlr_point_label', 'wlr_point_singular_label', 'wlr_cart_earn_points_message',
                'wlr_cart_redeem_points_message', 'wlr_checkout_earn_points_message', 'wlr_checkout_redeem_points_message',
                'wlr_thank_you_message', 'redeem_button_text', 'apply_coupon_button_text', 'reward_plural_label', 'reward_singular_label');
            foreach ($allowed_strings as $key) {
                if (isset($options[$key]) && !empty($options[$key])) {
                    $new_custom_strings[] = $options[$key];
                }
            }
        }
    }

    function getDynamicStrings($domain)
    {
        $new_custom_strings = array();
        $new_custom_strings = apply_filters('wlt_dynamic_string_list', $new_custom_strings, $domain);
        if ('wp-loyalty-rules' === $domain) {
            // campaign label
            $this->getCampaignStrings($new_custom_strings);
            $this->getRewardStrings($new_custom_strings);
            $this->getLevelStrings($new_custom_strings);
            $this->getSettingsStrings($new_custom_strings);
        }
        return $new_custom_strings;
    }

    function addCustomString(\Loco_gettext_Extraction $extraction, $domain)
    {
        $new_custom_strings = $this->getDynamicStrings($domain);
        if (!empty($new_custom_strings)) {
            foreach ($new_custom_strings as $key) {
                $custom = new \Loco_gettext_String($key);
                $extraction->addString($custom, $domain);
            }
        }
    }

    function addWPMLCustomString()
    {
        $response = array(
            'success' => false
        );
        $input_helper = new Input();
        $wlt_nonce = (string)$input_helper->post_get('wlt_nonce', '');
        if (!Woocommerce::hasAdminPrivilege() || !Woocommerce::verify_nonce($wlt_nonce, 'wlt_common_nonce')) {
            $response['message'] = __('Security validation failed', 'wp-loyalty-translate');
            wp_send_json($response);
        }
        if (!has_action('wpml_register_single_string')) {
            $response['message'] = __('WPML translation action not found', 'wp-loyalty-translate');
            wp_send_json($response);
        }
        $domains = apply_filters('wlt_dynamic_string_domain', array('wp-loyalty-rules'));
        foreach ($domains as $domain) {
            $new_custom_strings = $this->getDynamicStrings($domain);
            if (!empty($new_custom_strings)) {
                foreach ($new_custom_strings as $key) {
                    do_action('wpml_register_single_string', $domain, md5($key), $key);
                }
            }
        }
        $response['success'] = true;
        $response['message'] = __('Update WPML translation successfully', 'wp-loyalty-translate');
        wp_send_json($response);
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

    public function isPluginIsActive($plugin = '')
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

    public function getAppDetails($plugins){
        if (is_array($plugins)) {
            foreach ($plugins as &$plugin){
                if(is_array($plugin) && isset($plugin['plugin']) && $plugin['plugin'] == 'wp-loyalty-translate/wp-loyalty-translate.php'){
                    $plugin['page_url'] = admin_url('admin.php?' . http_build_query(array('page' => WLT_PLUGIN_SLUG)));
                    break;
                }
            }
        }
        return $plugins;
    }
}