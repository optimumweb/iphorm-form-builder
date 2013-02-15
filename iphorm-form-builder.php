<?php
/*
 * Plugin Name: Quform Form Builder
 * Plugin URI: http://www.quform.com/
 * Description: The Quform form builder makes it easy to build forms in WordPress. Previously known as iPhorm.
 * Version: 1.3.5
 * Author: ThemeCatcher
 * Author URI: http://www.themecatcher.net/
 * Text Domain: iphorm
 */

defined('IPHORM_VERSION')
    || define('IPHORM_VERSION', '1.3.5');

defined('IPHORM_DB_VERSION')
    || define('IPHORM_DB_VERSION', 4);

defined('IPHORM_PLUGIN_FILE')
    || define('IPHORM_PLUGIN_FILE', __FILE__);

defined('IPHORM_PLUGIN_BASENAME')
    || define('IPHORM_PLUGIN_BASENAME', plugin_basename(__FILE__));

defined('IPHORM_PLUGIN_NAME')
    || define('IPHORM_PLUGIN_NAME', untrailingslashit(dirname(IPHORM_PLUGIN_BASENAME)));

defined('IPHORM_PLUGIN_DIR')
    || define('IPHORM_PLUGIN_DIR', untrailingslashit(dirname(IPHORM_PLUGIN_FILE)));

defined('IPHORM_PLUGIN_URL')
    || define('IPHORM_PLUGIN_URL', untrailingslashit(plugins_url('', IPHORM_PLUGIN_FILE)));

defined('IPHORM_INCLUDES_DIR')
    || define('IPHORM_INCLUDES_DIR', IPHORM_PLUGIN_DIR . '/includes');

defined('IPHORM_ADMIN_DIR')
    || define('IPHORM_ADMIN_DIR', IPHORM_PLUGIN_DIR . '/admin');

defined('IPHORM_ADMIN_URL')
    || define('IPHORM_ADMIN_URL', IPHORM_PLUGIN_URL . '/admin');

defined('IPHORM_ADMIN_INCLUDES_DIR')
    || define('IPHORM_ADMIN_INCLUDES_DIR', IPHORM_ADMIN_DIR . '/includes');

defined('IPHORM_EMAIL_NEWLINE')
    || define('IPHORM_EMAIL_NEWLINE', apply_filters('iphorm_email_newline', "\r\n"));

defined('IPHORM_API_URL')
    || define('IPHORM_API_URL', 'http://www.themecatcher.net/iphorm-form-builder/api/');

defined('IPHORM_LANGUAGE_FILES') || define('IPHORM_LANGUAGE_FILES', serialize(array(
    'iphorm-nl_NL.mo',
    'iphorm-nl_NL.po',
    'iphorm-de_DE.mo',
    'iphorm-de_DE.po',
    'iphorm-ru_RU.mo',
    'iphorm-ru_RU.po',
    'iphorm-ua_UA.mo',
    'iphorm-ua_UA.po'
)));

require_once IPHORM_INCLUDES_DIR . '/common.php';