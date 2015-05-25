<?php

if (!defined('IPHORM_VERSION')) exit;

register_activation_hook(IPHORM_PLUGIN_FILE, 'iphorm_activate');

/**
 * Plugin activation hook
 */
function iphorm_activate()
{
    // Create the database table
    global $wpdb;

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $formsTable = iphorm_get_form_table_name();
    $formEntriesTable = iphorm_get_form_entries_table_name();
    $formEntryDataTable = iphorm_get_form_entry_data_table_name();

    $charset = '';
    if (!empty($wpdb->charset)) {
        $charset .= "DEFAULT CHARACTER SET $wpdb->charset";
    }

    if (!empty($wpdb->collate)) {
        $charset .= " COLLATE $wpdb->collate";
    }

    $sql = "CREATE TABLE $formsTable (
        id int UNSIGNED NOT NULL AUTO_INCREMENT,
        config longtext NOT NULL,
        active boolean NOT NULL DEFAULT 1,
        PRIMARY KEY  (id)
    ) " . $charset . ";";

    dbDelta($sql);

    $sql = "CREATE TABLE $formEntriesTable (
        id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        form_id int(11) UNSIGNED NOT NULL,
        unread tinyint (1) UNSIGNED NOT NULL DEFAULT 1,
        date_added datetime NOT NULL,
        ip varchar(32) NOT NULL,
        form_url varchar(512) NOT NULL,
        referring_url varchar(512) NOT NULL,
        post_id varchar(32) NOT NULL,
        post_title varchar(128) NOT NULL,
        user_display_name varchar(128) NOT NULL,
        user_email varchar(128) NOT NULL,
        user_login varchar(128) NOT NULL,
        PRIMARY KEY  (id),
        KEY form_id (form_id)
    ) " . $charset . ";";

    dbDelta($sql);

    $sql = "CREATE TABLE $formEntryDataTable (
        entry_id int(11) UNSIGNED NOT NULL,
        element_id int(11) UNSIGNED NOT NULL,
        value text,
        KEY entry_id (entry_id),
        KEY element_id (element_id)
    ) " . $charset . ";";

    dbDelta($sql);

    // Give the administrator capabilities to manage forms
    $role =& get_role('administrator');

    if (!empty($role)) {
        $allCaps = iphorm_get_all_capabilities();
        foreach ($allCaps as $cap) {
            $role->add_cap($cap);
        }
    }

    // Schedule the upload cleanup cron job
    if (!wp_next_scheduled('iphorm_upload_cleanup')) {
        wp_schedule_event(time(), 'twicedaily', 'iphorm_upload_cleanup');
    }

    // Create the options
    add_option('iphorm_recaptcha_public_key', '');
    add_option('iphorm_recaptcha_private_key', '');
    add_option('iphorm_active_themes', array());
    add_option('iphorm_active_uniform_themes', array());
    add_option('iphorm_active_datepickers', array());
    add_option('iphorm_hide_nag_message', 0);
    add_option('iphorm_licence_key', '');
    add_option('iphorm_email_sending_method', 'mail');
    add_option('iphorm_smtp_settings', array(
        'host' => '',
        'port' => 25,
        'encryption' => '',
        'username' => '',
        'password' => ''
    ));
    add_option('iphorm_disable_fancybox_output', 0);
    add_option('iphorm_fancybox_requested', 0);
    add_option('iphorm_disable_uniform_ouput', 0);
    add_option('iphorm_disable_qtip_output', 0);
    add_option('iphorm_disable_infieldlabels_output', 0);
    add_option('iphorm_disable_smoothscroll_output', 0);
    add_option('iphorm_disable_jqueryui_output', 0);

    $dbVersion = get_option('iphorm_db_version');
    if ($dbVersion !== false) {
        // This isn't a first install, so process any upgrades if required
        if ($dbVersion < 4) {
            iphorm_upgrade_4();
        }

        // Save the new DB version
        update_option('iphorm_db_version', IPHORM_DB_VERSION);
    } else {
        // This is a first install, add the DB version option
        add_option('iphorm_db_version', IPHORM_DB_VERSION);
    }

    iphorm_update_active_themes();
}

register_deactivation_hook(IPHORM_PLUGIN_FILE, 'iphorm_deactivate');

/**
 * Plugin deactivation hook
 */
function iphorm_deactivate()
{
    // Unschedule the upload cleanup cron job
    if ($timestamp = wp_next_scheduled('iphorm_upload_cleanup')) {
        wp_unschedule_event($timestamp, 'iphorm_upload_cleanup');
    }
}

register_uninstall_hook(IPHORM_PLUGIN_FILE, 'iphorm_uninstall');

/**
 * Uninstall hook
 */
function iphorm_uninstall()
{
    // Remove the capabilities from the administrator role
    $role =& get_role('administrator');

    if (!empty($role)) {
        $allCaps = iphorm_get_all_capabilities();
        foreach ($allCaps as $cap) {
            $role->remove_cap($cap);
        }
    }

    // Delete options
    delete_option('iphorm_db_version');
    delete_option('iphorm_recaptcha_public_key');
    delete_option('iphorm_recaptcha_private_key');
    delete_option('iphorm_active_themes');
    delete_option('iphorm_active_uniform_themes');
    delete_option('iphorm_active_datepickers');
    delete_option('iphorm_hide_nag_message');
    delete_option('iphorm_licence_key');
    delete_option('iphorm_email_sending_method');
    delete_option('iphorm_smtp_settings');
    delete_option('iphorm_disable_fancybox_output');
    delete_option('iphorm_fancybox_requested');
    delete_option('iphorm_disable_uniform_ouput');
    delete_option('iphorm_disable_qtip_output');
    delete_option('iphorm_disable_infieldlabels_output');
    delete_option('iphorm_disable_smoothscroll_output');
    delete_option('iphorm_disable_jqueryui_output');

    // Remove the forms tables
    global $wpdb;
    $wpdb->query('DROP TABLE IF EXISTS ' . iphorm_get_form_table_name());
    $wpdb->query('DROP TABLE IF EXISTS ' . iphorm_get_form_entries_table_name());
    $wpdb->query('DROP TABLE IF EXISTS ' . iphorm_get_form_entry_data_table_name());

    // Remove the user option
    $wpdb->query("DELETE FROM `{$wpdb->prefix}usermeta` WHERE `meta_key` = 'iphorm_epp'");
}


add_action('init', 'iphorm_update_db_check');

/**
 * Check if the database needs updated
 */
function iphorm_update_db_check() {
    if (get_option('iphorm_db_version') != IPHORM_DB_VERSION) {
        iphorm_activate();
    }
}

add_action('admin_menu', 'iphorm_create_menu');

/**
 * Create the admin menu
 */
function iphorm_create_menu()
{
    add_menu_page(
        __('Quform', 'iphorm'),
        __('Quform', 'iphorm'),
        'iphorm_list_forms',
        'iphorm_forms',
        'iphorm_forms',
        IPHORM_ADMIN_URL . '/images/menu-icon.png',
        '30.249829482347'
	);

    add_submenu_page(
        'iphorm_forms',
        __('Forms', 'iphorm'),
        __('Forms', 'iphorm'),
        'iphorm_list_forms',
        'iphorm_forms',
        'iphorm_forms'
    );

    add_submenu_page(
        'iphorm_forms',
        __('Form Builder', 'iphorm'),
        __('Form Builder', 'iphorm'),
        'iphorm_build_form',
        'iphorm_form_builder',
        'iphorm_form_builder'
    );

    add_submenu_page(
        'iphorm_forms',
        __('Entries', 'iphorm'),
        __('Entries', 'iphorm'),
        'iphorm_view_entries',
        'iphorm_entries',
        'iphorm_entries'
    );

    add_submenu_page(
        'iphorm_forms',
        __('Import', 'iphorm'),
        __('Import', 'iphorm'),
        'iphorm_import',
        'iphorm_import',
        'iphorm_import'
    );

    add_submenu_page(
        'iphorm_forms',
        __('Export', 'iphorm'),
        __('Export', 'iphorm'),
        'iphorm_export',
        'iphorm_export',
        'iphorm_export'
    );

    add_submenu_page(
        'iphorm_forms',
        __('Settings', 'iphorm'),
        __('Settings', 'iphorm'),
        'iphorm_settings',
        'iphorm_settings',
        'iphorm_settings'
    );

    add_submenu_page(
        'iphorm_forms',
        __('Help', 'iphorm'),
        __('Help', 'iphorm'),
        'iphorm_help',
        'iphorm_help',
        'iphorm_help'
    );
}

add_action('admin_print_styles-toplevel_page_iphorm_forms', 'iphorm_admin_enqueue_styles');
add_action('admin_print_styles-quform_page_iphorm_form_builder', 'iphorm_admin_enqueue_styles');
add_action('admin_print_styles-quform_page_iphorm_entries', 'iphorm_admin_enqueue_styles');
add_action('admin_print_styles-quform_page_iphorm_import', 'iphorm_admin_enqueue_styles');
add_action('admin_print_styles-quform_page_iphorm_export', 'iphorm_admin_enqueue_styles');
add_action('admin_print_styles-quform_page_iphorm_settings', 'iphorm_admin_enqueue_styles');
add_action('admin_print_styles-quform_page_iphorm_help', 'iphorm_admin_enqueue_styles');

/**
 * Enqueue admin styles
 */
function iphorm_admin_enqueue_styles()
{
    wp_enqueue_style('thickbox');
    wp_enqueue_style('qtip', IPHORM_ADMIN_URL . '/js/qtip2/jquery.qtip.min.css', array(), 'nightly', 'all');
    wp_enqueue_style('jquery-colorpicker', IPHORM_ADMIN_URL . '/js/colorpicker/css/colorpicker.css', array(), '23.05.2009', 'all');
    wp_enqueue_style('iphorm-admin', IPHORM_ADMIN_URL . '/css/styles.css', array(), IPHORM_VERSION, 'all');
}

add_action('admin_head-quform_page_iphorm_form_builder', 'iphorm_admin_ie7_styles');

/**
 * Enqueue admin IE7 stylesheet
 */
function iphorm_admin_ie7_styles()
{
    ?>
<!--[if IE 7]>
<link rel="stylesheet" href="<?php echo IPHORM_ADMIN_URL; ?>/css/ie7.css" type="text/css" media="all" />
<![endif]-->
    <?php
}

add_action('admin_print_scripts-quform_page_iphorm_form_builder', 'iphorm_form_builder_enqueue_scripts');

/**
 * Enqueue form builder scripts
 */
function iphorm_form_builder_enqueue_scripts()
{
    wp_enqueue_script('base64', IPHORM_ADMIN_URL . '/js/base64.js', array(), false, true);
    wp_enqueue_script('jeditable', IPHORM_ADMIN_URL . '/js/jquery.jeditable.js', array('jquery'), '1.7.1', true);
    wp_enqueue_script('jquery-smooth-scroll', IPHORM_ADMIN_URL . '/js/jquery.smooth-scroll.min.js', array('jquery'), '1.4', true);
    wp_enqueue_script('jquery-colorpicker', IPHORM_ADMIN_URL . '/js/colorpicker/js/colorpicker.js', array('jquery'), '23.05.2009', true);
    wp_enqueue_script('qtip', IPHORM_ADMIN_URL . '/js/qtip2/jquery.qtip.min.js', array('jquery'), 'nightly', true);
    wp_enqueue_script('jquery-tools-tabs', IPHORM_ADMIN_URL . '/js/jquery.tools.tabs.min.js', array('jquery'), '1.2.6', true);
    wp_enqueue_script('jquery-input-mask', IPHORM_ADMIN_URL . '/js/jquery.inputmask.min.js', array('jquery'), '1.4.0', true);
    wp_enqueue_script('iphorm-form-builder', IPHORM_ADMIN_URL . '/js/iphorm-form-builder.js', array('jquery', 'jquery-ui-sortable', 'jquery-ui-draggable', 'jquery-color', 'json2', 'thickbox'), IPHORM_VERSION, true);

    wp_localize_script('iphorm-form-builder', 'iphormL10n', iphorm_admin_l10n());
}

add_action('admin_print_scripts-toplevel_page_iphorm_forms', 'iphorm_admin_enqueue_scripts');
add_action('admin_print_scripts-quform_page_iphorm_entries', 'iphorm_admin_enqueue_scripts');
add_action('admin_print_scripts-quform_page_iphorm_import', 'iphorm_admin_enqueue_scripts');
add_action('admin_print_scripts-quform_page_iphorm_export', 'iphorm_admin_enqueue_scripts');
add_action('admin_print_scripts-quform_page_iphorm_settings', 'iphorm_admin_enqueue_scripts');
add_action('admin_print_scripts-quform_page_iphorm_help', 'iphorm_admin_enqueue_scripts');

function iphorm_admin_enqueue_scripts()
{
    wp_enqueue_script('iphorm-admin', IPHORM_ADMIN_URL . '/js/scripts.js', array('jquery', 'jquery-color'), IPHORM_VERSION, true);

    wp_localize_script('iphorm-admin', 'iphormAdminL10n', array(
        'single_delete_message' => __('Are you sure you want to delete this form? All saved settings, elements and entries for this form will be lost and this cannot be undone.', 'iphorm'),
        'plural_delete_message' => __('Are you sure you want to delete these forms? All saved settings, elements and entries for these forms will be lost and this cannot be undone.', 'iphorm'),
        'single_delete_entry_message' => __('Are you sure you want to delete this entry? All data for this entry will be lost and this cannot be undone.', 'iphorm'),
        'plural_delete_entry_message' => __('Are you sure you want to delete these entries? All data for these entries will be lost and this cannot be undone.', 'iphorm'),
        'verify_nonce' => wp_create_nonce('iphorm_verify_purchase_code'),
        'error_verifying' => __('An error occurred verifying the license key, please try again', 'iphorm'),
        'wait_verifying' => __('Please wait, verification in progress', 'iphorm'),
        'admin_images_url' => IPHORM_ADMIN_URL . '/images',
        'generic_error_try_again' => __('An error occurred, please try again', 'iphorm')
    ));
}

/**
 * Localisation function to pass translations and other data to
 * the admin JavaScript
 *
 * @return array
 */
function iphorm_admin_l10n()
{
    $data = array(
        'captcha_url' => IPHORM_PLUGIN_URL . '/includes/captcha.php',
        'preview_url' => admin_url('?iphorm_preview=1'),
        'tmp_dir' => iphorm_get_temp_dir(),
        'admin_images_url' => IPHORM_ADMIN_URL . '/images',
        'months' => iphorm_get_all_months(),
        'date_formats' => iphorm_get_date_formats(),
        'time_formats' => iphorm_get_time_formats(),
        'error_adding_element' => __('Error adding the element', 'iphorm'),
        'confirm_delete_element' => __('Are you sure you want to delete this element? Any associated entry data for this element will also be deleted.', 'iphorm'),
        'confirm_convert_element' => __('Are you sure you want to convert this element? Most of your settings will be copied over, however you may lose some settings that are not shared between the element types.', 'iphorm'),
        'error_saving_form' => __('Error saving the form', 'iphorm'),
        'element_deleted' => __('Element deleted', 'iphorm'),
        'option_1' => __('Option 1', 'iphorm'),
        'option_2' => __('Option 2', 'iphorm'),
        'option_3' => __('Option 3', 'iphorm'),
        'at_least_one_option' => __('There must be at least one option', 'iphorm'),
        'error_adding_filter' => __('Error adding the filter', 'iphorm'),
        'error_adding_validator' => __('Error adding the validator', 'iphorm'),
        'error_adding_style' => __('Error adding the style', 'iphorm'),
        'insert_variable' => _x('Insert variable...', 'variable piece of data', 'iphorm'),
        'submitted_form_value' => __('Submitted form value', 'iphorm'),
        'user_ip_address' => __('User IP address', 'iphorm'),
        'form_post_page_id' => __('Form post/page ID', 'iphorm'),
        'form_post_page_title' => __('Form post/page title', 'iphorm'),
        'form_url' => __('Form URL', 'iphorm'),
        'user_display_name' => __('User display name', 'iphorm'),
        'user_email' => __('User email', 'iphorm'),
        'user_login' => _x('User login', 'username', 'iphorm'),
        'referring_url' => __('Referring URL', 'iphorm'),
        'date_select_format' => __('Date (select a format)', 'iphorm'),
        'time_select_format' => __('Time (select a format)', 'iphorm'),
        'send_to_email' => __('Send to', 'iphorm'),
        'conditional_if' => _x('if', 'conditional', 'iphorm'),
        'is_equal_to' => __('is equal to', 'iphorm'),
        'is_not_equal_to' => __('is not equal to', 'iphorm'),
        'day' => __('Day', 'iphorm'),
        'month' => __('Month', 'iphorm'),
        'year' => __('Year', 'iphorm'),
        'example_tooltip' => __('This is an example tooltip!', 'iphorm'),
        'more_information' => __('More information', 'iphorm'),
        'remove' => _x('Remove', 'delete', 'iphorm'),
        'am_string' => _x('am', 'time, morning', 'iphorm'),
        'pm_string' => _x('pm', 'time, evening', 'iphorm'),
        'add_bulk_options' => __('Add bulk options', 'iphorm'),
        'bulk_options' => iphorm_get_bulk_options(),
        'need_multi_element' => __('The form must have at least one Dropdown Menu, Checkboxes or Multiple Choice element to use this feature.', 'iphorm'),
        'this_group_if' => __('this group if', 'iphorm'),
        'this_field_if' => __('this field if', 'iphorm'),
        'show' => __('Show', 'iphorm'),
        'hide' => __('Hide', 'iphorm'),
        'all' => __('all', 'iphorm'),
        'any' => __('any', 'iphorm'),
        'these_rules_match' => __('of these rules match:', 'iphorm'),
        'is' => __('is', 'iphorm'),
        'is_not' => __('is not', 'iphorm')
    );

    $params = array(
        'l10n_print_after' => 'iphormL10n = ' . iphorm_json_encode($data) . ';'
        );

        return $params;
}

/**
 * The form builder add form page
 */
function iphorm_form_builder()
{
    if (current_user_can('iphorm_build_form')) {
        $allForms = iphorm_get_all_forms();
        $themes = iphorm_get_all_themes();
        $uniformThemes = iphorm_get_all_uniform_themes();
        $id = isset($_GET['id']) ? absint($_GET['id']) : 0;
        $form = iphorm_load_form($id);

        include IPHORM_ADMIN_INCLUDES_DIR . '/form-builder.php';
    }
}

/**
 * Get the form configuration for the form with the given ID.
 * If the id is 0 the default form configuration will be returned.
 *
 * @param int $id
 * @return string The config encoded in JSON
 */
function iphorm_load_form($id)
{
    if ($id > 0) {
        $config = iphorm_get_form_config($id);
    } else {
        $config = array(
            'id' => 0
        );
    }

    return $config;
}

/**
 * Generates a new form ID and saves the form
 *
 * @param array $config
 */
function iphorm_add_form($config)
{
    global $wpdb;

    $values = array(
        'config' => ''
        );

        $wpdb->insert(iphorm_get_form_table_name(), $values);

        $config['id'] = $wpdb->insert_id;

        $updateValues = array(
        'config' => serialize($config),
        'active' => $config['active']
        );

        $updateWhere = array(
        'id' => $config['id']
        );

        $wpdb->update(iphorm_get_form_table_name(), $updateValues, $updateWhere);

        iphorm_update_single_active_themes($config);

        return $config;
}

/**
 * Save the form with the given config
 *
 * @param array $config
 * @return array $config
 */
function iphorm_save_form($config)
{
    global $wpdb;

    if (iphorm_get_form_row($config['id']) == null) {
        // Form doesn't exist in the database, create it to get an ID
        $values = array(
            'config' => ''
        );

        $wpdb->insert(iphorm_get_form_table_name(), $values);

        $config['id'] = $wpdb->insert_id;
    }

    $updateValues = array(
        'config' => serialize($config),
        'active' => $config['active']
    );

    $updateWhere = array(
        'id' => $config['id']
    );

    $wpdb->update(iphorm_get_form_table_name(), $updateValues, $updateWhere);

    iphorm_update_single_active_themes($config);

    return $config;
}

add_action('wp_ajax_iphorm_save_form_ajax', 'iphorm_save_form_ajax');

/**
 * Saves the form to the database. Called via Ajax from the form builder.
 */
function iphorm_save_form_ajax()
{
    if (check_ajax_referer('iphorm_save_form', false, false) && current_user_can('iphorm_build_form')) {
        $config = iphorm_json_decode(stripslashes($_POST['form']), true);

        if ($config['id'] == 0) {
            $message = iphorm_response_message(sprintf(__('%sForm saved%s', 'iphorm'), '<span class="ifb-message-inner">', '</span>') . ' ' . sprintf(__('%sAdd to website%s', 'iphorm'), '<a class="ifb-show-first-time-save">', '</a>'), 'success', 15);
        } else {
            $message = iphorm_response_message(__('Form saved', 'iphorm'));
        }

        $config = iphorm_save_form($config);

        $response = array(
            'type' => 'success',
            'data' => array(
                'id' => $config['id']
            ),
            'message' => $message
        );

        header('Content-Type: application/json');
        echo iphorm_json_encode($response);
    }

    exit;
}

add_action('wp_ajax_iphorm_get_element', 'iphorm_get_element');

/**
 * Get the HTML for the element for the form builder including
 * the settings. Called via Ajax.
 */
function iphorm_get_element()
{
    if (current_user_can('iphorm_build_form')) {
        $element = iphorm_json_decode(stripslashes($_POST['element']), true);
        $form = iphorm_json_decode(stripslashes($_POST['form']), true);

        if (isset($element['type'])) {
            $response = array(
                'type' => 'success',
                'data' => array(),
                'message' => iphorm_response_message(sprintf(__('%sElement added%s %sSettings%s', 'iphorm'), '<span class="ifb-message-inner">', '</span>', '<a class="iphorm-more-info" onclick="iPhorm.scrollToElement(iPhorm.getElementById(' . $element['id'] . ')); return false;">', '</a>'))
            );

            ob_start();

            switch ($element['type']) {
                case 'text':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/text.php';
                    break;
                case 'textarea':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/textarea.php';
                    break;
                case 'email':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/email.php';
                    break;
                case 'select':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/select.php';
                    break;
                case 'checkbox':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/checkbox.php';
                    break;
                case 'radio':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/radio.php';
                    break;
                case 'file':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/file.php';
                    $response['message'] = iphorm_response_message(sprintf(__('%sElement added%s', 'iphorm'), '<span class="ifb-message-inner">', '</span>'), 'success', 20, sprintf(__('The maximum file upload size has been set to 10MB, you can change this value in the element configuration. %sSee the help for more information%s.', 'iphorm'), '<a onclick="window.open(this.href); return false;" href="'.iphorm_help_link('element-file#upload-maximum-size').'">', '</a>'));
                    break;
                case 'captcha':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/captcha.php';
                    break;
                case 'recaptcha':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/recaptcha.php';
                    break;
                case 'html':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/html.php';
                    break;
                case 'date':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/date.php';
                    break;
                case 'time':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/time.php';
                    break;
                case 'hidden':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/hidden.php';
                    break;
                case 'password':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/password.php';
                    break;
                case 'groupstart':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/groupstart.php';
                    break;
                case 'groupend':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/groupend.php';
                    unset($response['message']);
                    break;
                default:
                    $response['type'] = 'error';
                    $response['message'] = iphorm_response_message(__('Error adding the element', 'iphorm'), 'error', 0, 'There is no element of that type.');
            }

            $response['data']['element'] = $element;
            $response['data']['html'] = ob_get_clean();

            header('Content-Type: application/json');
            echo iphorm_json_encode($response);
        }
    }

    exit;
}

add_action('wp_ajax_iphorm_get_filter', 'iphorm_get_filter');

/**
 * Get the HTML for the filter
 */
function iphorm_get_filter()
{
    if (current_user_can('iphorm_build_form')) {
        $filter = iphorm_json_decode(stripslashes($_POST['filter']), true);

        if (isset($filter['type'])) {
            $response = array(
                'type' => 'success',
                'data' => array()
            );

            ob_start();

            switch ($filter['type']) {
                case 'alpha':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/filters/alpha.php';
                    break;
                case 'alphaNumeric':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/filters/alpha-numeric.php';
                    break;
                case 'digits':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/filters/digits.php';
                    break;
                case 'stripTags':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/filters/strip-tags.php';
                    break;
                case 'trim':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/filters/trim.php';
                    break;
                case 'regex':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/filters/regex.php';
                    break;
                default:
                    $response['type'] = 'error';
                    $response['message'] = iphorm_response_message(__('Error adding the filter', 'iphorm'), 'error', 0, 'There is no filter of that type.');
            }

            $response['data']['filter'] = $filter;
            $response['data']['html'] = ob_get_clean();

            header('Content-Type: application/json');
            echo iphorm_json_encode($response);
        }
    }

    exit;
}

add_action('wp_ajax_iphorm_get_validator', 'iphorm_get_validator');

/**
 * Get the HTML for the validator
 */
function iphorm_get_validator()
{
    if (current_user_can('iphorm_build_form')) {
        $validator = iphorm_json_decode(stripslashes($_POST['validator']), true);

        if (isset($validator['type'])) {
            $response = array(
                'type' => 'success',
                'data' => array()
            );

            ob_start();

            switch ($validator['type']) {
                case 'alpha':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/validators/alpha.php';
                    break;
                case 'alphaNumeric':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/validators/alpha-numeric.php';
                    break;
                case 'digits':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/validators/digits.php';
                    break;
                case 'email':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/validators/email.php';
                    break;
                case 'greaterThan':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/validators/greater-than.php';
                    break;
                case 'identical':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/validators/identical.php';
                    break;
                case 'length':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/validators/length.php';
                    break;
                case 'lessThan':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/validators/less-than.php';
                    break;
                case 'regex':
                    include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/validators/regex.php';
                    break;
                default:
                    $response['type'] = 'error';
                    $response['message'] = iphorm_response_message(__('Error adding the validator', 'iphorm'), 'error', 0, 'There is no validator of that type.');
            }

            $response['data']['validator'] = $validator;
            $response['data']['html'] = ob_get_clean();

            header('Content-Type: application/json');
            echo iphorm_json_encode($response);
        }
    }

    exit;
}

/**
 * Get the list of invalid filters for the given element type
 *
 * @param array $element
 * @return array
 */
function iphorm_get_invalid_filter_types($element)
{
    $invalid = array();

    switch ($element['type']) {
        case 'select':
        case 'checkbox':
        case 'radio':
        case 'file':
        case 'html':
        case 'date':
        case 'time':
        case 'hidden':
            $invalid = array('alpha', 'alphaNumeric', 'digits', 'stripTags', 'trim', 'regex');
            break;
        case 'email':
            $invalid = array('alpha', 'alphaNumeric', 'digits', 'stripTags', 'regex');
            break;
    }

    return $invalid;
}

/**
 * Get the list of invalid validators for the given element type
 *
 * @param array $element
 * @return array
 */
function iphorm_get_invalid_validator_types($element)
{
    $invalid = array();

    switch ($element['type']) {
        case 'select':
        case 'checkbox':
        case 'radio':
        case 'file':
        case 'captcha':
        case 'recaptcha':
        case 'html':
        case 'date':
        case 'time':
        case 'hidden':
            $invalid = array('alpha', 'alphaNumeric', 'digits', 'email', 'greaterThan', 'identical', 'length', 'lessThan', 'regex');
            break;
        case 'email':
            $invalid = array('alpha', 'alphaNumeric', 'digits', 'greaterThan', 'identical', 'length', 'lessThan', 'regex');
    }

    return $invalid;
}

add_action('wp_ajax_iphorm_get_style', 'iphorm_get_style');

/**
 * Get the HTML for the style
 */
function iphorm_get_style()
{
    if (current_user_can('iphorm_build_form')) {
        $style = iphorm_json_decode(stripslashes($_POST['style']), true);

        if (isset($style['type'])) {
            $response = array(
                'type' => 'success',
                'data' => array()
            );

            ob_start();

            switch ($style['type']) {
                case 'outer':
                    if (!isset($style['name'])) $style['name'] = _x('Outer wrapper', 'outermost wrapping HTML element', 'iphorm');
                    break;
                case 'label':
                    if (!isset($style['name'])) $style['name'] = _x('Label', 'form element label to be styled', 'iphorm');
                    break;
                case 'inner':
                    if (!isset($style['name'])) $style['name'] = _x('Inner wrapper', 'innermost wrapping HTML element', 'iphorm');
                    break;
                case 'input':
                    if (!isset($style['name'])) $style['name'] = _x('Text input', 'the HTML form element input/textarea/select etc', 'iphorm');
                    break;
                case 'textarea':
                    if (!isset($style['name'])) $style['name'] = _x('Textarea input', 'the HTML form element textarea', 'iphorm');
                    break;
                case 'select':
                    if (!isset($style['name'])) $style['name'] = __('Dropdown menu', 'iphorm');
                    break;
                case 'description':
                    if (!isset($style['name'])) $style['name'] = _x('Group description', 'element group description', 'iphorm');
                    break;
                case 'elementDescription':
                    if (!isset($style['name'])) $style['name'] = _x('Description', 'element description', 'iphorm');
                    break;
                case 'optionUl':
                    if (!isset($style['name'])) $style['name'] = _x('Options outer wrapper', 'the wrapper around all of the options', 'iphorm');
                    break;
                case 'optionLi':
                    if (!isset($style['name'])) $style['name'] = _x('Option wrapper', 'the wrapper around each option', 'iphorm');
                    break;
                case 'optionLabel':
                    if (!isset($style['name'])) $style['name'] = _x('Option label', 'the label of each option', 'iphorm');
                    break;
                case 'group':
                    if (!isset($style['name'])) $style['name'] = _x('Group', 'form element group', 'iphorm');
                    break;
                case 'groupTitle':
                    if (!isset($style['name'])) $style['name'] = _x('Group title', 'form element group title', 'iphorm');
                    break;
                case 'groupElements':
                    if (!isset($style['name'])) $style['name'] = _x('Group elements wrapper', 'the HTML wrapper around the elements in the group', 'iphorm');
                    break;
                case 'dateDay':
                    if (!isset($style['name'])) $style['name'] = __('Date day dropdown', 'iphorm');
                    break;
                case 'dateMonth':
                    if (!isset($style['name'])) $style['name'] = __('Date month dropdown', 'iphorm');
                    break;
                case 'dateYear':
                    if (!isset($style['name'])) $style['name'] = __('Date year dropdown', 'iphorm');
                    break;
                case 'timeHour':
                    if (!isset($style['name'])) $style['name'] = __('Time hour dropdown', 'iphorm');
                    break;
                case 'timeMinute':
                    if (!isset($style['name'])) $style['name'] = __('Time minute dropdown', 'iphorm');
                    break;
                case 'timeAmPm':
                    if (!isset($style['name'])) $style['name'] = __('Time am/pm dropdown', 'iphorm');
                    break;
            }

            include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/style.php';

            $response['data']['style'] = $style;
            $response['data']['html'] = ob_get_clean();

            header('Content-Type: application/json');
            echo iphorm_json_encode($response);
        }
    }

    exit;
}

add_action('wp_ajax_iphorm_get_global_style', 'iphorm_get_global_style');

/**
 * Get the HTML for the global style
 */
function iphorm_get_global_style()
{
    if (current_user_can('iphorm_build_form')) {
        $style = iphorm_json_decode(stripslashes($_POST['style']), true);

        if (isset($style['type'])) {
            $response = array(
                'type' => 'success',
                'data' => array()
            );

            ob_start();

            switch ($style['type']) {
                case 'formOuter':
                    if (!isset($style['name'])) $style['name'] = _x('Form outer wrapper', 'the outermost HTML wrapper around the form', 'iphorm');
                    break;
                case 'formInner':
                    if (!isset($style['name'])) $style['name'] = _x('Form inner wrapper', 'the inner HTML wrapper around the form', 'iphorm');
                    break;
                case 'success':
                    if (!isset($style['name'])) $style['name'] = __('Success message', 'iphorm');
                    break;
                case 'title':
                    if (!isset($style['name'])) $style['name'] = __('Form title', 'iphorm');
                    break;
                case 'description':
                    if (!isset($style['name'])) $style['name'] = __('Form description', 'iphorm');
                    break;
                case 'elements':
                    if (!isset($style['name'])) $style['name'] = _x('Form elements wrapper', 'the HTML wrapper around the form elements', 'iphorm');
                    break;
                case 'outer':
                    if (!isset($style['name'])) $style['name'] = _x('Element outer wrapper', 'outermost wrapping HTML element around an element', 'iphorm');
                    break;
                case 'label':
                    if (!isset($style['name'])) $style['name'] = __('Element label', 'iphorm');
                    break;
                case 'inner':
                    if (!isset($style['name'])) $style['name'] = _x('Element inner wrapper', 'the inner HTML wrapper around the element', 'iphorm');
                    break;
                case 'input':
                    if (!isset($style['name'])) $style['name'] = __('Text input elements', 'iphorm');
                    break;
                case 'textarea':
                    if (!isset($style['name'])) $style['name'] = __('Paragraph text elements', 'iphorm');
                    break;
                case 'select':
                    if (!isset($style['name'])) $style['name'] = __('Dropdown Menu elements', 'iphorm');
                    break;
                case 'optionUl':
                    if (!isset($style['name'])) $style['name'] = _x('Options outer wrapper', 'the wrapper around the list of options for multi elements e.g. checkbox, radio', 'iphorm');
                    break;
                case 'optionLi':
                    if (!isset($style['name'])) $style['name'] = _x('Option wrappers', 'the wrapper around each option for multi elements e.g. checkbox, radio', 'iphorm');
                    break;
                case 'optionLabel':
                    if (!isset($style['name'])) $style['name'] = _x('Option labels', 'the label each option for multi elements e.g. checkbox, radio', 'iphorm');
                    break;
                case 'elementDescription':
                    if (!isset($style['name'])) $style['name'] = __('Element description', 'iphorm');
                    break;
                case 'dateDay':
                    if (!isset($style['name'])) $style['name'] = __('Date day dropdown', 'iphorm');
                    break;
                case 'dateMonth':
                    if (!isset($style['name'])) $style['name'] = __('Date month dropdown', 'iphorm');
                    break;
                case 'dateYear':
                    if (!isset($style['name'])) $style['name'] = __('Date year dropdown', 'iphorm');
                    break;
                case 'timeHour':
                    if (!isset($style['name'])) $style['name'] = __('Time hour dropdown', 'iphorm');
                    break;
                case 'timeMinute':
                    if (!isset($style['name'])) $style['name'] = __('Time minute dropdown', 'iphorm');
                    break;
                case 'timeAmPm':
                    if (!isset($style['name'])) $style['name'] = __('Time am/pm dropdown', 'iphorm');
                    break;
                case 'submitOuter':
                    if (!isset($style['name'])) $style['name'] = __('Submit button outer wrapper', 'iphorm');
                    break;
                case 'submit':
                    if (!isset($style['name'])) $style['name'] = __('Submit button inner wrapper', 'iphorm');
                    break;
                case 'submitButton':
                    if (!isset($style['name'])) $style['name'] = __('Submit button', 'iphorm');
                    break;
                case 'submitSpan':
                    if (!isset($style['name'])) $style['name'] = __('Submit button inside span', 'iphorm');
                    break;
                case 'submitEm':
                    if (!isset($style['name'])) $style['name'] = __('Submit button inside em', 'iphorm');
                    break;

            }

            include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/global-style.php';

            $response['data']['style'] = $style;
            $response['data']['html'] = ob_get_clean();

            header('Content-Type: application/json');
            echo iphorm_json_encode($response);
        }
    }

    exit;
}

/**
 * Gets the list of styles that are valid for the given
 * element
 *
 * @param array $element
 * @return array
 */
function iphorm_get_valid_styles($element)
{
    $valid = array();

    switch ($element['type']) {
        case 'text':
        case 'email':
        case 'captcha':
        case 'password':
            $valid = array('outer', 'label', 'inner', 'input', 'elementDescription');
            break;
        case 'textarea':
            $valid = array('outer', 'label', 'inner', 'textarea', 'elementDescription');
            break;
        case 'select':
            $valid = array('outer', 'label', 'inner', 'select', 'elementDescription');
            break;
        case 'file':
        case 'recaptcha':
            $valid = array('outer', 'label', 'inner', 'elementDescription');
            break;
        case 'date':
            $valid = array('outer', 'label', 'inner', 'elementDescription', 'dateDay', 'dateMonth', 'dateYear');
            break;
        case 'time':
            $valid = array('outer', 'label', 'inner', 'elementDescription', 'timeHour', 'timeMinute', 'timeAmPm');
            break;
        case 'radio':
        case 'checkbox':
            $valid = array('outer', 'label', 'inner', 'optionUl', 'optionLi', 'optionLabel', 'elementDescription');
            break;
        case 'groupstart':
            $valid = array('description', 'group', 'groupTitle', 'groupElements');
            break;
    }

    return $valid;
}

/**
 * The Quform general settings page
 */
function iphorm_settings()
{
    include IPHORM_ADMIN_INCLUDES_DIR . '/settings.php';
}

add_action('wp_ajax_iphorm_get_date_years_ajax', 'iphorm_get_date_years_ajax');

/**
 * Get the replaced start year of date element Year select,
 * with any placeholder tags replaced. Returns the default start
 * year if the year is not specified.
 */
function iphorm_get_date_years_ajax()
{
    $startYear = isset($_POST['start_year']) ? $_POST['start_year'] : '';
    $endYear = isset($_POST['end_year']) ? $_POST['end_year'] : '';

    $response = array(
        'type' => 'success',
        'data' => array(
            'start_year' => iphorm_get_start_year($startYear),
            'end_year' => iphorm_get_end_year($endYear)
    )
    );

    header('Content-Type: application/json');
    echo iphorm_json_encode($response);
    exit;
}

add_action('media_buttons', 'iphorm_add_insert_button', 20);

/**
 * Add the "Add Quform" button to the end of the media buttons above a post/page
 */
function iphorm_add_insert_button()
{
    if (current_user_can('iphorm_list_forms')) {
        $href = admin_url('admin-ajax.php?action=iphorm_insert_form');
        echo '<a href="' . $href . '" class="thickbox" title="' . esc_attr__('Insert a form', 'iphorm') . '"><img src="' . IPHORM_ADMIN_URL . '/images/insert-iphorm.png' . '" alt="' . esc_attr__('Insert Quform', 'iphorm') . '" /></a>';
    }
}

add_action('wp_ajax_iphorm_insert_form', 'iphorm_insert_form');

/**
 * The form to insert a form into a post/page, shown in thickbox
 */
function iphorm_insert_form()
{
    $forms = iphorm_get_all_forms();
    ?>
<div style="width: 450px; margin: 20px auto 0 auto;">
    <h3><?php esc_html_e('Insert a form', 'iphorm'); ?></h3>
    <?php if (count($forms)) : ?>
        <p><?php esc_html_e('Select the form you want to insert from the dropdown menu and click Insert.', 'iphorm'); ?></p>
        <select id="iphorm-insert-form" class="iphorm-insert-form">
        <?php foreach ($forms as $form) : ?>
            <option value="<?php echo $form['id']; ?>"><?php echo esc_html($form['name']); ?><?php if ($form['active'] == 0) echo ' (' . esc_html__('inactive', 'iphorm') . ')'; ?></option>
        <?php endforeach; ?>
        </select>
        <div class="iphorm-insert-popup-wrap" style="margin: 10px 0;">
            <div class="iphorm-insert-popup-cbox-wrap">
                <label for="iphorm-insert-popup"><input type="checkbox" id="iphorm-insert-popup" /> <?php esc_html_e('Display the form in a popup (using Fancybox)', 'iphorm'); ?></label>
            </div>
        </div>
        <div style="margin-top: 15px;"><button id="iphorm-insert-go" class="button-primary"><?php esc_html_e('Insert', 'iphorm'); ?></button></div>
    <?php else : ?>
        <?php printf(esc_html__('No forms found, %sclick here to create one%s.', 'iphorm'), '<a href="'.admin_url('admin.php?page=iphorm_form_builder').'">', '</a>'); ?>
    <?php endif; ?>
</div>
<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function ($) {
    $('#iphorm-insert-go').click(function () {
        var formId = $('#iphorm-insert-form').val(), formName = $('#iphorm-insert-form > option:selected').text();
        var win = window.dialogArguments || opener || parent || top;
        if ($('#iphorm-insert-popup').is(':checked')) {
            var shortcode = '[iphorm_popup id=' + formId + ' name="' + formName + '"]';
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'iphorm_set_fancybox_requested'
                }
            });

            shortcode += '<?php echo esc_js(__('Change this to the text or HTML that will trigger the popup', 'iphorm')); ?>[/iphorm_popup]';
        } else {
            var shortcode = '[iphorm id=' + formId + ' name="' + formName + '"]';
        }
        win.send_to_editor(shortcode);
    });
});
//]]>
</script>
    <?php
    exit;
}

/**
 * Format a response message
 *
 * @param string $content The message content
 * @param string $type The message type, 'error' or 'success'
 * @param int $timeout The number of seconds to display the message
 * @param string $more More information to display in an expandable area
 */
function iphorm_response_message($content, $type = 'success', $timeout = 5, $more = '')
{
    if (strlen($more) > 0) {
        $content .= ' <a href="#" class="ifb-message-more">' . esc_html__('More information', 'iphorm') . '</a>';
        $content .= '<div class="ifb-hidden ifb-message-more-content clearfix">' . $more . '</div>';
    }

    return array(
        'type' => $type,
        'content' => $content,
        'timeout' => $timeout
    );
}

/**
 * Get all the plugin capabilities
 *
 * @return array
 */
function iphorm_get_all_capabilities()
{
    return array(
        'iphorm_list_forms',
        'iphorm_build_form',
        'iphorm_preview_form',
        'iphorm_delete_form',
        'iphorm_view_entries',
        'iphorm_delete_entry',
        'iphorm_import',
        'iphorm_export',
        'iphorm_settings',
        'iphorm_help'
        );
}

add_filter('members_get_capabilities', 'iphorm_add_members_capabilities');

/**
 * Add capabilities for the members plugin
 *
 * @param array $caps
 */
function iphorm_add_members_capabilities($caps)
{
    return array_merge($caps, iphorm_get_all_capabilities());
}

/**
 * Delete forms with the given ID's
 *
 * @param array $ids
 * @return int The number of affected rows
 */
function iphorm_delete_forms($ids)
{
    global $wpdb;
    $affectedRows = 0;

    $activeUniformThemes = maybe_unserialize(get_option('iphorm_active_uniform_themes'));
    $activeThemes = maybe_unserialize(get_option('iphorm_active_themes'));
    $activeDatepickers = maybe_unserialize(get_option('iphorm_active_themes'));

    foreach ((array) $ids as $id) {
        $sql = "DELETE FROM " . iphorm_get_form_entry_data_table_name() . "
        WHERE entry_id IN (SELECT id FROM " . iphorm_get_form_entries_table_name() . "
        WHERE form_id = %d)";
        $wpdb->query($wpdb->prepare($sql, $id));

        $sql = "DELETE FROM " . iphorm_get_form_entries_table_name() . " WHERE form_id = %d";
        $wpdb->query($wpdb->prepare($sql, $id));

        $sql = "DELETE FROM " . iphorm_get_form_table_name() . " WHERE id = %d";
        $result = $wpdb->query($wpdb->prepare($sql, $id));
        $affectedRows += (int) $result;

        if (array_key_exists($id, $activeUniformThemes)) {
            unset($activeUniformThemes[$id]);
        }

        if (array_key_exists($id, $activeThemes)) {
            unset($activeThemes[$id]);
        }

        if (array_key_exists($id, $activeDatepickers)) {
            unset($activeDatepickers[$id]);
        }
    }

    update_option('iphorm_active_uniform_themes', serialize($activeUniformThemes));
    update_option('iphorm_active_themes', serialize($activeThemes));
    update_option('iphorm_active_datepickers', serialize($activeDatepickers));

    return $affectedRows;
}

/**
 * Activate forms with the given ID's
 *
 * @param array $ids
 * @return int The number of affected rows
 */
function iphorm_activate_forms($ids)
{
    global $wpdb;
    $affectedRows = 0;

    foreach ((array) $ids as $id) {
        $config = iphorm_get_form_config($id);
        $config['active'] = 1;

        $updateValues = array(
            'config' => serialize($config),
            'active' => 1
        );

        $updateWhere = array(
            'id' => $id
        );

        $result = $wpdb->update(iphorm_get_form_table_name(), $updateValues, $updateWhere);
        $affectedRows += (int) $result;

        iphorm_update_single_active_themes($config);
    }

    return $affectedRows;
}

/**
 * Dectivate forms with the given ID's
 *
 * @param array $ids
 * @return int The number of affected rows
 */
function iphorm_deactivate_forms($ids)
{
    global $wpdb;
    $affectedRows = 0;

    foreach ((array) $ids as $id) {
        $config = iphorm_get_form_config($id);
        $config['active'] = 0;

        $updateValues = array(
            'config' => serialize($config),
            'active' => 0
        );

        $updateWhere = array(
            'id' => $id
        );

        $result = $wpdb->update(iphorm_get_form_table_name(), $updateValues, $updateWhere);
        $affectedRows += (int) $result;

        iphorm_update_single_active_themes($config);
    }

    return $affectedRows;
}

/**
 * Display the list of forms
 */
function iphorm_forms()
{
    $message = '';

    if (isset($_GET['action']) && $_GET['action'] == 'delete' && current_user_can('iphorm_delete_form')) {
        $id = isset($_GET['id']) ? absint($_GET['id']) : 0;
        if ($id && wp_verify_nonce($_GET['_wpnonce'], 'iphorm_delete_form_' . $id)) {
            $deleted = iphorm_delete_forms(array($id));
            if ($deleted) {
                $message = sprintf(_n('Form deleted', '%d forms deleted', $deleted, 'iphorm'), $deleted);
            }
        }
    }

    if (isset($_GET['action']) && $_GET['action'] == 'activate' && current_user_can('iphorm_build_form')) {
        $id = isset($_GET['id']) ? absint($_GET['id']) : 0;
        if ($id && wp_verify_nonce($_GET['_wpnonce'], 'iphorm_activate_form_' . $id)) {
            $activated = iphorm_activate_forms(array($id));
            if ($activated) {
                $message = sprintf(_n('Form activated', '%d forms activated', $activated, 'iphorm'), $activated);
            }
        }
    }

    if (isset($_GET['action']) && $_GET['action'] == 'deactivate' && current_user_can('iphorm_build_form')) {
        $id = isset($_GET['id']) ? absint($_GET['id']) : 0;
        if ($id && wp_verify_nonce($_GET['_wpnonce'], 'iphorm_deactivate_form_' . $id)) {
            $deactivated = iphorm_deactivate_forms(array($id));
            if ($deactivated) {
                $message = sprintf(_n('Form deactivated', '%d forms deactivated', $deactivated, 'iphorm'), $deactivated);
            }
        }
    }

    if (isset($_GET['action']) && $_GET['action'] == 'duplicate' && current_user_can('iphorm_build_form')) {
        $id = isset($_GET['id']) ? absint($_GET['id']) : 0;
        if ($id && wp_verify_nonce($_GET['_wpnonce'], 'iphorm_duplicate_form_' . $id)) {
            $config = iphorm_get_form_config($id);
            if (is_array($config)) {
                $config['name'] .= ' (' . __('duplicate', 'iphorm') . ')';
            }

            $config = iphorm_add_form($config);

            if (is_array($config)) {
                $message = sprintf(esc_html__('Form duplicated, %sedit the form%s', 'iphorm'), '<a href="' . admin_url('admin.php?page=iphorm_form_builder&amp;id=' . $config['id']) . '">', '</a>');
            }
        }
    }

    $bulkAction = '';
    if (isset($_POST['bulk_action']) && $_POST['bulk_action'] != '-1') {
        $bulkAction = $_POST['bulk_action'];
    } elseif (isset($_POST['bulk_action2']) && $_POST['bulk_action2'] != '-1') {
        $bulkAction = $_POST['bulk_action2'];
    }

    if ($bulkAction == 'delete' && isset($_POST['form']) && current_user_can('iphorm_delete_form')) {
        $deleted = iphorm_delete_forms($_POST['form']);
        if ($deleted) {
            $message = sprintf(_n('Form deleted', '%d forms deleted', $deleted, 'iphorm'), $deleted);
        }
    } else if ($bulkAction == 'activate' && isset($_POST['form']) && current_user_can('iphorm_build_form')) {
        $activated = iphorm_activate_forms($_POST['form']);
        if ($activated) {
            $message = sprintf(_n('Form activated', '%d forms activated', $activated, 'iphorm'), $activated);
        }
    } else if ($bulkAction == 'deactivate' && isset($_POST['form']) && current_user_can('iphorm_build_form')) {
        $deactivated = iphorm_deactivate_forms($_POST['form']);
        if ($deactivated) {
            $message = sprintf(_n('Form deactivated', '%d forms deactivated', $deactivated, 'iphorm'), $deactivated);
        }
    }

    $active = isset($_GET['active']) ? absint($_GET['active']) : null;
    $forms = iphorm_get_all_form_rows($active);

    include IPHORM_ADMIN_INCLUDES_DIR . '/forms.php';
}

add_action('auth_redirect', 'iphorm_preview');

/**
 * Hook for previewing a form
 */
function iphorm_preview()
{
    if (isset($_GET['iphorm_preview']) && $_GET['iphorm_preview'] == 1 && !isset($_POST['iphorm_ajax']) && current_user_can('iphorm_preview_form')) {
        $form = null;
        if (isset($_GET['id'])) {
            $form = iphorm_get_form_config(absint($_GET['id']));
        }

        $previewL10n = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'preview_not_loaded' => __('Sorry, the form preview could not be loaded.', 'iphorm')
        );

        include IPHORM_ADMIN_INCLUDES_DIR . '/preview.php';

        exit; // Prevent the rest of WP loading
    }
}

add_action('wp_ajax_iphorm_preview_form_ajax', 'iphorm_preview_form_ajax');

/**
 * Display the form via ajax for the form preview
 */
function iphorm_preview_form_ajax()
{
    if (current_user_can('iphorm_preview_form')) {
        if (isset($_POST['form'])) {
            $response = array(
                'type' => 'success'
            );

            $config = iphorm_json_decode(stripslashes($_POST['form']), true);

            $form = new iPhorm($config);

            $response['data'] = iphorm_display_form($form);

            header('Content-Type: application/json');
            echo iphorm_json_encode($response);
        }
    }

    exit;
}

/**
 * Get all the available Uniform themes
 *
 * @return array
 */
function iphorm_get_all_uniform_themes()
{
    $uniformThemes = array();

    $defaultHeaders = array(
        'UniformTheme' => 'Uniform Theme',
        'By' => 'By'
        );

        $files = iphorm_list_files(IPHORM_PLUGIN_DIR . '/js/uniform/themes');

        foreach ($files as $file) {
            if (substr($file, -4) == '.css') {
                $theme = get_file_data($file, $defaultHeaders);

                if (isset($theme['UniformTheme'])) {
                    $theme['Folder'] = basename(dirname($file));
                    $uniformThemes[$theme['Folder']] = $theme;
                }
            }
        }

        return $uniformThemes;
}

/**
 * Get the default Uniform themes, i.e. not user-created
 *
 * @return array
 */
function iphorm_get_default_uniform_themes()
{
    return array('default', 'aristo', 'agent');
}

/**
 * Get all the installed Quform themes
 *
 * @return array
 */
function iphorm_get_all_themes()
{
    $themes = array();

    $defaultHeaders = array(
        'Name' => 'Theme Name',
        'UniformTheme' => 'Uniform Theme',
        'Description' => 'Description',
        'Version' => 'Version',
        'Author' => 'Author',
        'AuthorURI' => 'Author URI'
        );

        $files = iphorm_list_files(IPHORM_PLUGIN_DIR . '/themes');

        foreach ($files as $file) {
            if (substr($file, -4) == '.css') {
                $theme = get_file_data($file, $defaultHeaders);

                if (isset($theme['Name'])) {
                    $info = pathinfo($file);
                    $theme['Filename'] = basename($file, '.' . $info['extension']);
                    $theme['Folder'] = basename(dirname($file));
                    $themeKey = $theme['Folder'] . '|' . $theme['Filename'];
                    $themes[$themeKey] = $theme;

                }
            }
        }

        return $themes;
}

/**
 * Get all the default themes, i.e. not user-created
 *
 * @return array
 */
function iphorm_get_default_themes()
{
    return array('light', 'dark');
}

/**
 * Update the saved list of active themes
 *
 * If a form is added or deleted via direct database access this function
 * will need to be called so that the correct theme CSS is loaded on the site.
 */
function iphorm_update_active_themes()
{
    $activeUniformThemes = array();
    $uniformThemes = iphorm_get_all_uniform_themes();

    $activeThemes = array();
    $themes = iphorm_get_all_themes();

    $activeDatepickers = array();

    $forms = iphorm_get_all_forms(1);

    foreach ($forms as $config) {
        if (isset($config['use_uniformjs']) && $config['use_uniformjs'] && isset($config['uniformjs_theme']) && array_key_exists($config['uniformjs_theme'], $uniformThemes)) {
            $activeUniformThemes[$config['id']] = $config['uniformjs_theme'];
        }

        if (strlen($config['theme']) && isset($themes[$config['theme']])) {
            $activeThemes[$config['id']] = $config['theme'];
        }

        foreach ($config['elements'] as $element) {
            if ($element['type'] == 'date' && (!isset($element['show_datepicker']) || (isset($element['show_datepicker']) && $element['show_datepicker']))) {
                $activeDatepickers[$config['id']] = true;
                break;
            }
        }
    }

    update_option('iphorm_active_uniform_themes', serialize($activeUniformThemes));
    update_option('iphorm_active_themes', serialize($activeThemes));
    update_option('iphorm_active_datepickers', serialize($activeDatepickers));
}

function iphorm_update_single_active_themes($config)
{
    // Update list of uniform themes in use
    $activeUniformThemes = maybe_unserialize(get_option('iphorm_active_uniform_themes'));

    if ($config['active'] == 1 && isset($config['use_uniformjs']) && $config['use_uniformjs'] && isset($config['uniformjs_theme']) && array_key_exists($config['uniformjs_theme'], iphorm_get_all_uniform_themes())) {
        $activeUniformThemes[$config['id']] = $config['uniformjs_theme'];
    } else if (isset($activeUniformThemes[$config['id']])) {
        unset($activeUniformThemes[$config['id']]);
    }

    update_option('iphorm_active_uniform_themes', serialize($activeUniformThemes));

    // Update list of themes in use
    $activeThemes = maybe_unserialize(get_option('iphorm_active_themes'));
    if ($config['active'] == 1 && strlen($config['theme']) && array_key_exists($config['theme'], iphorm_get_all_themes())) {
        $activeThemes[$config['id']] = $config['theme'];
    } else if (isset($activeThemes[$config['id']])) {
        unset($activeThemes[$config['id']]);
    }

    update_option('iphorm_active_themes', serialize($activeThemes));

    $activeDatepickers = maybe_unserialize(get_option('iphorm_active_datepickers'));
    if ($config['active'] == 1) {
        $hasDatepicker = false;
        foreach ($config['elements'] as $element) {
            if ($element['type'] == 'date' && (!isset($element['show_datepicker']) || (isset($element['show_datepicker']) && $element['show_datepicker']))) {
                $hasDatepicker = true;
                break;
            }
        }

        if ($hasDatepicker) {
            $activeDatepickers[$config['id']] = true;
        } else if (isset($activeDatepickers[$config['id']])) {
            unset($activeDatepickers[$config['id']]);
        }
    }

    update_option('iphorm_active_datepickers', serialize($activeDatepickers));
}

/**
 * Help page
 */
function iphorm_help()
{
    if (current_user_can('iphorm_help')) {
        $section = isset($_GET['section']) ? $_GET['section'] : 'basics' ;

        include IPHORM_ADMIN_INCLUDES_DIR . '/help.php';
    }
}

/**
 * Returns the full URL to the given help section
 *
 * @param string $section
 */
function iphorm_help_link($section = '')
{
    if (strlen($section)) {
        return admin_url('admin.php?page=iphorm_help&amp;section=' . $section);
    }

    return admin_url('admin.php?page=iphorm_help');
}

add_action('wp_ajax_iphorm_hide_nag_message', 'iphorm_hide_nag_message');

/**
 * Permanently hide the nag message saying the WP uploads directory
 * is not writable
 */
function iphorm_hide_nag_message()
{
    update_option('iphorm_hide_nag_message', 1);
    exit;
}

/**
 * Import page
 */
function iphorm_import()
{
    if (current_user_can('iphorm_import')) {
        $messages = array();

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_config']) && strlen($_POST['form_config'])) {
            $config = base64_decode(trim(stripslashes($_POST['form_config'])));
            $config = maybe_unserialize($config);

            if (is_array($config)) {
                $config = iphorm_add_form($config);
                $messages[] = array(
                    'type' => 'success',
                    'message' => sprintf(esc_html__('Form imported successfully, %sedit the form%s', 'iphorm'), '<a href="admin.php?page=iphorm_form_builder&amp;id=' . $config['id'] . '">', '</a>')
                );
            } else {
                $messages[] = array(
                    'type' => 'error',
                    'message' => esc_html__('Invalid import data', 'iphorm')
                );
            }
        }

        include IPHORM_ADMIN_INCLUDES_DIR . '/import.php';
    }
}

/**
 * Export page
 */
function iphorm_export()
{
    if (current_user_can('iphorm_export')) {
        $allForms = iphorm_get_all_forms();

        if (isset($_GET['action']) && $_GET['action'] == 'form') {
            $action = 'form';
        } else {
            $action = 'entries';
        }

        $exportData = '';
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && $action === 'form' && isset($_GET['id'])) {
            $form = iphorm_get_form_row(absint($_GET['id']));
            if ($form !== null) {
                $exportData = base64_encode($form->config);
            }
        }

        include IPHORM_ADMIN_INCLUDES_DIR . '/export.php';
    }
}

/**
 * Entries list page and single entry page
 */
function iphorm_entries()
{
    if (current_user_can('iphorm_view_entries')) {
        global $wpdb;
        $message= '';

        if (isset($_GET['action']) && $_GET['action'] == 'entry') {
            $id = isset($_GET['entry_id']) ? absint($_GET['entry_id']) : 0;
            $formId = isset($_GET['id']) ? absint($_GET['id']) : 0;

            $config = iphorm_get_form_config($formId);

            if (is_array($config)) {
                $columns = array();
                $sql = "SELECT `entries`.*";

                if (isset($config['elements']) && is_array($config['elements'])) {
                    foreach ($config['elements'] as $element) {
                        if (isset($element['save_to_database']) && $element['save_to_database']) {
                            $elementId = absint($element['id']);
                            $sql .= ", GROUP_CONCAT(if (`data`.`element_id` = $elementId, value, NULL)) AS `element_$elementId`";
                            $columns['element_' . $elementId] = $element;
                        }
                    }
                }

                $sql .= " FROM `" . iphorm_get_form_entries_table_name() . "` `entries`
                LEFT JOIN `" . iphorm_get_form_entry_data_table_name() . "` `data` ON `data`.`entry_id` = `entries`.`id`
                WHERE `entries`.`id` = $id
                GROUP BY `data`.`entry_id`";

                $wpdb->query('SET @@GROUP_CONCAT_MAX_LEN = 65535');
                $entry = $wpdb->get_row($sql);

                // Mark as read
                if (isset($entry->unread) && $entry->unread == 1) {
                    iphorm_read_entries($entry->id);
                }
            }

            include IPHORM_ADMIN_INCLUDES_DIR . '/entry.php';
        } else {
            $id = isset($_GET['id']) ? absint($_GET['id']) : 0;

            if ($id == 0 || !iphorm_form_exists($id)) {
                $sql = "SELECT id FROM " . iphorm_get_form_table_name() . " LIMIT 1";

                $id = $wpdb->get_var($sql);
            }

            if ($id > 0) {
                // Deal with setting read/unread
                if (isset($_GET['action'])) {
                    if ($_GET['action'] == 'read') {
                        $entryId = isset($_GET['entry_id']) ? absint($_GET['entry_id']) : 0;
                        if ($entryId > 0 && wp_verify_nonce($_GET['_wpnonce'], 'iphorm_entry_read_' . $entryId)) {
                            iphorm_read_entries($entryId);
                        }
                    } else if ($_GET['action'] == 'unread') {
                        $entryId = isset($_GET['entry_id']) ? absint($_GET['entry_id']) : 0;
                        if ($entryId > 0 && wp_verify_nonce($_GET['_wpnonce'], 'iphorm_entry_unread_' . $entryId)) {
                            iphorm_unread_entries($entryId);
                        }
                    } else if ($_GET['action'] == 'delete') {
                        $entryId = isset($_GET['entry_id']) ? absint($_GET['entry_id']) : 0;
                        if ($entryId > 0 && wp_verify_nonce($_GET['_wpnonce'], 'iphorm_entry_delete_' . $entryId)) {
                            iphorm_delete_entries($entryId);
                        }
                    }
                }

                // Deal with bulk actions
                $bulkAction = '';
                if (isset($_GET['bulk_action']) && $_GET['bulk_action'] != '-1') {
                    $bulkAction = $_GET['bulk_action'];
                } elseif (isset($_GET['bulk_action2']) && $_GET['bulk_action2'] != '-1') {
                    $bulkAction = $_GET['bulk_action2'];
                }

                if ($bulkAction == 'delete' && isset($_GET['entry']) && current_user_can('iphorm_delete_entry')) {
                    $deleted = iphorm_delete_entries($_GET['entry']);
                    if ($deleted) {
                        $message = sprintf(_n('Entry deleted', '%d entries deleted', $deleted, 'iphorm'), $deleted);
                    }
                } else if ($bulkAction == 'read' && isset($_GET['entry']) && current_user_can('iphorm_view_entries')) {
                    iphorm_read_entries($_GET['entry']);
                } else if ($bulkAction == 'unread' && isset($_GET['entry']) && current_user_can('iphorm_view_entries')) {
                    iphorm_unread_entries($_GET['entry']);
                }

                $config = iphorm_get_form_config($id);
                $allForms = iphorm_get_all_forms();
                $columns = $config['entries_table_layout']['active'];
                array_unshift($columns, array(
                    'type' => 'column',
                    'label' => 'ID',
                    'id' => 'id'
                    ));

                    // Get entries per page
                    $currentUser = wp_get_current_user();
                    $validEPP = array('10', '20', '40', '60', '80', '100', '1000000');
                    $savedEPP = get_user_meta($currentUser->ID, 'iphorm_epp', true);
                    if (!in_array($savedEPP, $validEPP)) $savedEPP = '20';
                    $requestedEPP = isset($_GET['epp']) && in_array($_GET['epp'], $validEPP) ? $_GET['epp'] : $savedEPP;
                    if ($requestedEPP != $savedEPP) {
                        update_user_meta($currentUser->ID, 'iphorm_epp', $requestedEPP);
                        $savedEPP = $requestedEPP;
                    }

                    $limit = absint($savedEPP);
                    $offset = $limit * (iphorm_get_current_pagenum() - 1);

                    // Build the query
                    $sql = "SELECT SQL_CALC_FOUND_ROWS `entries`.*";
                    $searchColumns = array(
                    '`entries`.`date_added`',
                    '`entries`.`ip`',
                    '`entries`.`form_url`',
                    '`entries`.`referring_url`',
                    '`entries`.`post_id`',
                    '`entries`.`post_title`',
                    '`entries`.`user_display_name`',
                    '`entries`.`user_email`',
                    '`entries`.`user_login`'
                    );

                    $validOrderBy = array(
                    'id',
                    'date_added',
                    'ip',
                    'form_url',
                    'referring_url',
                    'post_id',
                    'post_title',
                    'user_display_name',
                    'user_email',
                    'user_login'
                    );

                    if (isset($config['elements']) && is_array($config['elements'])) {
                        foreach ($config['elements'] as $element) {
                            if (isset($element['save_to_database']) && $element['save_to_database']) {
                                $elementId = absint($element['id']);
                                $sql .= ", GROUP_CONCAT(if (`data`.`element_id` = $elementId, value, NULL)) AS `element_$elementId`";
                                $searchColumns[] = "`element_$elementId`";
                                $validOrderBy[] = "element_$elementId";
                            }
                        }
                    }

                    // Sorting
                    $orderby = (isset($_GET['orderby']) && in_array($_GET['orderby'], $validOrderBy)) ? $_GET['orderby'] : 'date_added';
                    $order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'asc' : 'desc';
                    $reverseOrder = $order == 'asc' ? 'desc' : 'asc';

                    $sql .= "
                FROM `" . iphorm_get_form_entries_table_name() . "` `entries`
                LEFT JOIN `" . iphorm_get_form_entry_data_table_name() . "` `data` ON `data`.`entry_id` = `entries`.`id`
                WHERE `entries`.`form_id` = $id
                GROUP BY `entries`.`id` ";

                    $search = isset($_GET['s']) && strlen($_GET['s']) ? $_GET['s'] : null;
                    if (strlen($search)) {
                        $wpdb->escape_by_ref($search);
                        $sql .= "HAVING ";
                        foreach ($searchColumns as &$searchColumn) {
                            $searchColumn = "$searchColumn LIKE '%$search%'";
                        }
                        $sql .= join(' OR ', $searchColumns);
                    }

                    $sql .= " ORDER BY `$orderby` $order
                LIMIT $limit OFFSET $offset";

                    $wpdb->query('SET @@GROUP_CONCAT_MAX_LEN = 65535');
                    $entries = $wpdb->get_results($sql);

                    $totalItems = $wpdb->get_var("SELECT FOUND_ROWS()");
                    $allItems = $wpdb->get_var("SELECT COUNT(*) FROM " . iphorm_get_form_entries_table_name() . " WHERE `form_id` = $id");
                    $topPagination = iphorm_entries_pagination($limit, $totalItems, 'top');
                    $bottomPagination = iphorm_entries_pagination($limit, $totalItems, 'bottom');
                    $currentUrl = remove_query_arg(array('bulk_action', 'bulk_action2', 'entry'));
            }

            include IPHORM_ADMIN_INCLUDES_DIR . '/entries.php';
        }
    }
}

/**
 * Get the current page number
 *
 * @return int
 */
function iphorm_get_current_pagenum()
{
    $current = isset($_GET['paged']) ? absint($_GET['paged']) : 0;
    return max(1, $current);
}

/**
 * Get the HTML for the entries pagination
 *
 * @param int $per_page How many items per page?
 * @param int $total_items How many total items?
 * @param string $which Display top or bottom
 * @return string The HTML
 */
function iphorm_entries_pagination($per_page, $total_items, $which)
{
    $total_pages = ceil( $total_items / $per_page );
    $current = iphorm_get_current_pagenum();
    $output = '<span class="displaying-num">' . sprintf( _n( '1 item', '%s items', $total_items ), number_format_i18n( $total_items ) ) . '</span>';

    $current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    $page_links = array();

    $disable_first = $disable_last = '';
    if ( $current == 1 )
    $disable_first = ' disabled';
    if ( $current == $total_pages )
    $disable_last = ' disabled';

    $page_links[] = sprintf( "<a class='%s' title='%s' href='%s'>%s</a>",
        'first-page' . $disable_first,
    esc_attr__( 'Go to the first page' ),
    esc_url( remove_query_arg( 'paged', $current_url ) ),
        '&laquo;'
        );

        $page_links[] = sprintf( "<a class='%s' title='%s' href='%s'>%s</a>",
        'prev-page' . $disable_first,
        esc_attr__( 'Go to the previous page' ),
        esc_url( add_query_arg( 'paged', max( 1, $current-1 ), $current_url ) ),
        '&lsaquo;'
        );

        if ( 'bottom' == $which )
        $html_current_page = $current;
        else
        $html_current_page = sprintf( "<input class='current-page' title='%s' type='text' name='%s' value='%s' size='%d' />",
        esc_attr__( 'Current page' ),
        esc_attr( 'paged' ),
        $current,
        strlen( $total_pages )
        );

        $html_total_pages = sprintf( "<span class='total-pages'>%s</span>", number_format_i18n( $total_pages ) );
        $page_links[] = '<span class="paging-input">' . sprintf( _x( '%1$s of %2$s', 'paging' ), $html_current_page, $html_total_pages ) . '</span>';

        $page_links[] = sprintf( "<a class='%s' title='%s' href='%s'>%s</a>",
        'next-page' . $disable_last,
        esc_attr__( 'Go to the next page' ),
        esc_url( add_query_arg( 'paged', min( $total_pages, $current+1 ), $current_url ) ),
        '&rsaquo;'
        );

        $page_links[] = sprintf( "<a class='%s' title='%s' href='%s'>%s</a>",
        'last-page' . $disable_last,
        esc_attr__( 'Go to the last page' ),
        esc_url( add_query_arg( 'paged', $total_pages, $current_url ) ),
        '&raquo;'
        );

        $output .= "\n<span class='pagination-links'>" . join( "\n", $page_links ) . '</span>';

        if ( $total_pages )
        $page_class = $total_pages < 2 ? ' one-page' : '';
        else
        $page_class = ' no-pages';

        return "<div class='tablenav-pages{$page_class}'>$output</div>";
}

/**
 * Get the admin label for an element
 *
 * @param array $element The element configuration
 * @return string
 */
function iphorm_get_element_admin_label($element)
{
    $label = $element['label'];

    if (isset($element['admin_label']) && strlen($element['admin_label'])) {
        $label = $element['admin_label'];
    }

    return $label;
}

/**
 * Delete the entries with the given IDs
 *
 * @param int|array $ids
 */
function iphorm_delete_entries($ids)
{
    global $wpdb;
    $affectedRows = 0;

    foreach ((array) $ids as $id) {
        $sql = "DELETE FROM " . iphorm_get_form_entries_table_name() . " WHERE id = %d";
        $result = $wpdb->query($wpdb->prepare($sql, $id));
        $affectedRows += (int) $result;

        $sql = "DELETE FROM " . iphorm_get_form_entry_data_table_name() . " WHERE entry_id = %d";
        $wpdb->query($wpdb->prepare($sql, $id));
    }

    return $affectedRows;
}

/**
 * Get the number of entries for the form with the given ID
 *
 * @param int $id
 * @param int $unread Count only unread entries
 */
function iphorm_get_form_entry_count($id, $unread = null)
{
    global $wpdb;

    $sql = "SELECT COUNT(*) FROM " . iphorm_get_form_entries_table_name() . " WHERE form_id = %d";

    if ($unread !== null) {
        $sql .= " AND unread = " . absint($unread);
    }

    return $wpdb->get_var($wpdb->prepare($sql, $id));
}

/**
 * Get the total number of entries
 *
 * @param $unread Count only unread entries
 */
function iphorm_get_all_entry_count($unread = null)
{
    global $wpdb;

    $sql = "SELECT COUNT(*) FROM " . iphorm_get_form_entries_table_name();

    if ($unread !== null) {
        $sql .= " WHERE unread = " . absint($unread);
    }

    //return $wpdb->get_var($wpdb->prepare($sql));
    return $wpdb->get_var($sql);
}

/**
 * Mark entries with the given IDs as read
 *
 * @param int|array $ids
 */
function iphorm_read_entries($ids)
{
    global $wpdb;
    $affectedRows = 0;

    foreach ((array) $ids as $id) {
        $sql = "UPDATE " . iphorm_get_form_entries_table_name() . " SET unread = 0 WHERE id = %d";
        $result = $wpdb->query($wpdb->prepare($sql, $id));
        $affectedRows += (int) $result;
    }

    return $affectedRows;
}

/**
 * Mark the entries with the given IDs as unread
 *
 * @param int|array $ids
 */
function iphorm_unread_entries($ids)
{
    global $wpdb;
    $affectedRows = 0;

    foreach ((array) $ids as $id) {
        $sql = "UPDATE " . iphorm_get_form_entries_table_name() . " SET unread = 1 WHERE id = %d";
        $result = $wpdb->query($wpdb->prepare($sql, $id));
        $affectedRows += (int) $result;
    }

    return $affectedRows;
}

/**
 * Get all the forms from the database with unread entries
 *
 * @return object The result object
 */
function iphorm_get_all_forms_with_unread_entries($active = null)
{
    global $wpdb;

    $sql = "SELECT f.*, (SELECT COUNT(*) FROM " . iphorm_get_form_entries_table_name() . " WHERE form_id = f.id AND unread = 1) AS entries FROM " . iphorm_get_form_table_name() . " f";

    if ($active !== null) {
        $active = absint($active);
        $sql .= " WHERE f.active = $active";
    }

    $sql .= " HAVING entries > 0";

    return $wpdb->get_results($sql);
}


/**
 * Limit the given text to the specified number of characters
 *
 * @param string $text The text to limit
 * @param int $length The maximum number of characters to show
 * @param string $after Any text to append to the string
 */
function iphorm_limit_text($text, $length = 200, $after = '&hellip;')
{
    if (strlen($text) <= $length) {
        return $text;
    } else {
        $limitedText = substr($text, 0, $length);
        return $limitedText . $after;
    }
}

add_action('wp_dashboard_setup', 'iphorm_dashboard_widget');

/**
 * Add the dashboard widget
 */
function iphorm_dashboard_widget()
{
    if (iphorm_get_all_entry_count(1) && current_user_can('iphorm_view_entries')) {
        wp_enqueue_style('iphorm-dashboard', IPHORM_ADMIN_URL . '/css/dashboard.css', array(), IPHORM_VERSION);
        wp_add_dashboard_widget('iphorm-dashboard-widget', __('Quform', 'iphorm'), 'iphorm_dashboard_widget_display');
    }
}

/**
 * Display the dashboard widget
 */
function iphorm_dashboard_widget_display()
{
    $forms = iphorm_get_all_forms_with_unread_entries(1);

    if (count($forms)) {
        include IPHORM_ADMIN_INCLUDES_DIR . '/dashboard.php';
    } else {
        echo '<p>' . esc_html__('Form information will appear here when you create a form.', 'iphorm') . '</p>';
    }
}

add_action('wp_ajax_iphorm_verify_purchase_code', 'iphorm_verify_purchase_code');

/**
 * Verify the given purchase code
 */
function iphorm_verify_purchase_code()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && check_ajax_referer('iphorm_verify_purchase_code')) {
        $purchaseCode = isset($_POST['purchase_code']) && strlen($_POST['purchase_code']) ? trim($_POST['purchase_code']) : '';
        $siteUrl = site_url();
        $response = array(
            'type' => 'error',
            'message' => __('An error occurred verifying the license key, please try again', 'iphorm')
        );

        $remoteResponse = wp_remote_post(IPHORM_API_URL . 'verify.php', array(
            'body' => array(
                'site_url' => site_url(),
                'purchase_code' => $purchaseCode
            ),
            'timeout' => 20
        ));

        if (wp_remote_retrieve_response_code($remoteResponse) == 200 && strlen($json = wp_remote_retrieve_body($remoteResponse))) {
            $data = iphorm_json_decode($json, true);

            if (isset($data['type'])) {
                if ($data['type'] == 'success') {
                    update_option('iphorm_licence_key', $data['licence_key']);

                    $response = array(
                        'type' => 'success',
                        'status' => 'valid',
                        'message' => __('License key successfully verified', 'iphorm')
                    );
                } else if ($data['type'] == 'error' && isset($data['code'])) {
                    switch ($data['code']) {
                        case 1:
                            $response['message'] = __('Invalid license key', 'iphorm');
                            $response['status'] = 'invalid';
                            update_option('iphorm_licence_key', '');
                            break;
                        case 2:
                            $response['message'] = __('Licence key verification will be available shortly, please try again later', 'iphorm');
                            break;
                    }
                }
            }
        }

        header('Content-Type: application/json');
        echo iphorm_json_encode($response);
        exit;
    }
}

add_filter('pre_set_site_transient_update_plugins', 'iphorm_update_check');

/**
 * Checks for updates
 */
function iphorm_update_check($transient)
{
    $licenceKey = get_option('iphorm_licence_key');
    if (empty($transient->checked) || !strlen($licenceKey)) {
        return $transient;
    }

    $args = array(
        'action' => 'update-check',
        'plugin_name' => IPHORM_PLUGIN_BASENAME,
        'version' => $transient->checked[IPHORM_PLUGIN_BASENAME],
        'licence_key' => $licenceKey,
        'site_url' => site_url()
    );

    $response = iphorm_api_request($args);

    if ($response !== false) {
        if ((isset($response->type, $response->code) && $response->type == 'error' && $response->code == 1)) {
            update_option('iphorm_licence_key', '');
        } else {
            $transient->response[IPHORM_PLUGIN_BASENAME] = $response;
        }
    }

    return $transient;
}

/**
 * Send a request to the Quform API
 *
 * @param array $args
 * @return object|false
 */
function iphorm_api_request($args)
{
    $request = wp_remote_post(IPHORM_API_URL, array('body' => $args, 'timeout' => 10));

    if (is_wp_error($request) || wp_remote_retrieve_response_code($request) != 200) {
        return false;
    }

    $response = unserialize(wp_remote_retrieve_body($request));

    if (is_object($response)) {
        return $response;
    } else {
        return false;
    }
}

add_filter('plugins_api', 'iphorm_plugin_information', 10, 3);

/**
 * Get plugin information
 */
function iphorm_plugin_information($false, $action, $args)
{
    if (!isset($args->slug) || $args->slug != IPHORM_PLUGIN_BASENAME) {
        return false;
    }

    $args = array(
        'action' => 'plugin_information',
        'plugin_name' => IPHORM_PLUGIN_BASENAME,
        'licence_key' => get_option('iphorm_licence_key'),
        'site_url' => site_url()
    );

    $response = iphorm_api_request($args);

    if (isset($response->type) && $response->type == 'error') {
        wp_die(__('Invalid license key', 'iphorm'));
    }

    return $response;
}

add_filter('upgrader_pre_install', 'iphorm_pre_upgrade', 10, 2);

/**
 * Pre-upgrade actions
 *
 * Copies any custom themes, uniform themes and languages files to a temporary directory
 */
function iphorm_pre_upgrade($value, $extra_args)
{
    if (isset($extra_args['plugin']) && $extra_args['plugin'] == IPHORM_PLUGIN_BASENAME) {
        global $wp_filesystem;
        $pluginPath = untrailingslashit($wp_filesystem->wp_plugins_dir());
        $iphormPluginPath = $pluginPath . '/' . IPHORM_PLUGIN_NAME;

        $allUniformThemes = iphorm_get_all_uniform_themes();
        $defaultUniformThemes = iphorm_get_default_uniform_themes();

        $uniformThemesToBackup = array();
        foreach ($allUniformThemes as $allUniformTheme) {
            if (!in_array($allUniformTheme['Folder'], $defaultUniformThemes)) {
                $uniformThemesToBackup[] = $allUniformTheme['Folder'];
            }
        }

        $allThemes = iphorm_get_all_themes();
        $defaultThemes = iphorm_get_default_themes();

        $themesToBackup = array();
        foreach ($allThemes as $allTheme) {
            if (!in_array($allTheme['Folder'], $defaultThemes)) {
                $themesToBackup[] = $allTheme['Folder'];
            }
        }

        $languageFilesToBackup = iphorm_get_custom_language_files();

        $customCSS = $wp_filesystem->is_file($iphormPluginPath . '/css/custom.css');

        if (count($uniformThemesToBackup) || count($themesToBackup) || count($languageFilesToBackup) || $customCSS) {
            if ($wp_filesystem->is_writable($pluginPath)) {
                $targetDir = $pluginPath . '/iphorm-upgrade.tmp';
                if ($wp_filesystem->exists($targetDir)) {
                    $wp_filesystem->delete($targetDir, true);
                }

                if (!$wp_filesystem->exists($targetDir)) {
                    $wp_filesystem->mkdir($targetDir);

                    // All set, start copying themes over
                    if (count($uniformThemesToBackup)) {
                        $targetUniformDir = $targetDir . '/uniform/';
                        $wp_filesystem->mkdir($targetUniformDir);
                        $sourceUniformDir = $iphormPluginPath . '/js/uniform/themes/';

                        foreach ($uniformThemesToBackup as $uniformThemeToBackup) {
                            if ($wp_filesystem->exists($sourceUniformDir . $uniformThemeToBackup)) {
                                $wp_filesystem->mkdir($targetUniformDir . $uniformThemeToBackup);
                                copy_dir($sourceUniformDir . $uniformThemeToBackup, $targetUniformDir . $uniformThemeToBackup);
                            }
                        }
                    }

                    if (count($themesToBackup)) {
                        $targetThemeDir = $targetDir . '/themes/';
                        $wp_filesystem->mkdir($targetThemeDir);
                        $sourceThemeDir = $iphormPluginPath . '/themes/';

                        foreach ($themesToBackup as $themeToBackup) {
                            if ($wp_filesystem->exists($sourceThemeDir . $themeToBackup)) {
                                $wp_filesystem->mkdir($targetThemeDir . $themeToBackup);
                                copy_dir($sourceThemeDir . $themeToBackup, $targetThemeDir . $themeToBackup);
                            }
                        }
                    }

                    if (count($languageFilesToBackup)) {
                        $targetLanguagesDir = $targetDir . '/languages/';
                        $sourceLanguagesDir = $iphormPluginPath . '/languages/';
                        $wp_filesystem->mkdir($targetLanguagesDir);

                        foreach ($languageFilesToBackup as $languageFileToBackup) {
                            if ($wp_filesystem->is_file($sourceLanguagesDir . $languageFileToBackup)) {
                                $wp_filesystem->copy($sourceLanguagesDir . $languageFileToBackup, $targetLanguagesDir . $languageFileToBackup);
                            }
                        }
                    }

                    if ($customCSS) {
                        $wp_filesystem->copy($iphormPluginPath . '/css/custom.css', $targetDir . '/custom.css');
                    }
                }
            }
        }
    }

    return $value;
}

add_filter('upgrader_post_install', 'iphorm_post_upgrade', 10, 2);

/**
 * Post-upgrade actions
 *
 * Restores any previously backed up themes and uniform themes
 */
function iphorm_post_upgrade($value, $extra_args)
{
    if (isset($extra_args['plugin']) && $extra_args['plugin'] == IPHORM_PLUGIN_BASENAME) {
        global $wp_filesystem;
        $pluginPath = untrailingslashit($wp_filesystem->wp_plugins_dir());
        $iphormPluginPath = $pluginPath . '/' . IPHORM_PLUGIN_NAME;
        $sourceDir = $pluginPath . '/iphorm-upgrade.tmp';

        if ($wp_filesystem->exists($sourceDir)) {
            $sourceUniformDir = $sourceDir . '/uniform';
            $targetUniformDir = $iphormPluginPath . '/js/uniform/themes';
            if ($wp_filesystem->exists($sourceUniformDir)) {
                copy_dir($sourceUniformDir, $targetUniformDir);
            }

            $sourceThemeDir = $sourceDir . '/themes';
            $targetThemeDir = $iphormPluginPath . '/themes';
            if ($wp_filesystem->exists($sourceThemeDir)) {
                copy_dir($sourceThemeDir, $targetThemeDir);
            }

            $sourceLanguagesDir = $sourceDir . '/languages/';
            $targetLanguagesDir = $iphormPluginPath . '/languages/';
            if ($wp_filesystem->exists($sourceLanguagesDir)) {
                $sourceLanguagesFiles = $wp_filesystem->dirlist($sourceLanguagesDir);
                foreach ($sourceLanguagesFiles as $sourceLanguagesFile) {
                    if ($wp_filesystem->is_file($sourceLanguagesDir . $sourceLanguagesFile['name'])) {
                        $wp_filesystem->copy($sourceLanguagesDir . $sourceLanguagesFile['name'], $targetLanguagesDir . $sourceLanguagesFile['name']);
                    }
                }
            }

            if ($wp_filesystem->is_file($sourceDir . '/custom.css')) {
                $wp_filesystem->copy($sourceDir . '/custom.css', $iphormPluginPath . '/css/custom.css');
            }

            $wp_filesystem->delete($sourceDir, true);
        }
    }

    return $value;
}

/**
 * Get the list of custom language files
 *
 * @return array
 */
function iphorm_get_custom_language_files()
{
    $files = iphorm_list_files(IPHORM_PLUGIN_DIR . '/languages');

    $languageFiles = array();
    $packagedLanguageFiles = unserialize(IPHORM_LANGUAGE_FILES);

    foreach ($files as $file) {
        $filename = basename($file);
        if ($filename != 'iphorm-form-builder.pot' && $filename != 'readme.txt' && !in_array($filename, $packagedLanguageFiles)) {
            $languageFiles[] = $filename;
        }
    }

    return $languageFiles;
}

/*
 * Get the predefined bulk options
 *
 * @return array
 */
function iphorm_get_bulk_options()
{
    return apply_filters('iphorm_bulk_options', array(
    __('Countries', 'iphorm') => iphorm_get_countries(),
    __('U.S. States', 'iphorm') => iphorm_get_us_states(),
    __('Canadian Provinces', 'iphorm') => iphorm_get_canadian_provinces(),
    __('UK Counties', 'iphorm') => iphorm_get_uk_counties(),
    __('German States', 'iphorm') => array(__('Baden-Wurttemberg', 'iphorm'), __('Bavaria', 'iphorm'), __('Berlin', 'iphorm'), __('Brandenburg', 'iphorm'), __('Bremen', 'iphorm'), __('Hamburg', 'iphorm'), __('Hesse', 'iphorm'), __('Mecklenburg-West Pomerania', 'iphorm'), __('Lower Saxony', 'iphorm'), __('North Rhine-Westphalia', 'iphorm'), __('Rhineland-Palatinate', 'iphorm'), __('Saarland', 'iphorm'), __('Saxony', 'iphorm'), __('Saxony-Anhalt', 'iphorm'), __('Schleswig-Holstein', 'iphorm'), __('Thuringia', 'iphorm')),
    __('Dutch Provinces', 'iphorm') => array(__('Drente', 'iphorm'), __('Flevoland', 'iphorm'), __('Friesland', 'iphorm'), __('Gelderland', 'iphorm'), __('Groningen', 'iphorm'), __('Limburg', 'iphorm'), __('North-Brabant', 'iphorm'), __('North-Holland', 'iphorm'), __('Overijssel', 'iphorm'), __('South-Holland', 'iphorm'), __('Utrecht', 'iphorm'), __('Zeeland', 'iphorm')),
    __('Continents', 'iphorm') => array(__('Africa', 'iphorm'), __('Antarctica', 'iphorm'), __('Asia', 'iphorm'), __('Australia', 'iphorm'), __('Europe', 'iphorm'), __('North America', 'iphorm'), __('South America', 'iphorm')),
    __('Gender', 'iphorm') => array(__('Male', 'iphorm'), __('Female', 'iphorm')),
    __('Age', 'iphorm') => array(__('Under 18', 'iphorm'), __('18-24', 'iphorm'), __('25-34', 'iphorm'), __('35-44', 'iphorm'), __('45-54', 'iphorm'), __('55-64', 'iphorm'), __('65 or over', 'iphorm')),
    __('Marital Status', 'iphorm') => array(__('Single', 'iphorm'), __('Married', 'iphorm'), __('Divorced', 'iphorm'), __('Widowed', 'iphorm')),
    __('Income', 'iphorm') => array(__('Under $20,000', 'iphorm'), __('$20,000 - $30,000', 'iphorm'), __('$30,000 - $40,000', 'iphorm'), __('$40,000 - $50,000', 'iphorm'), __('$50,000 - $75,000', 'iphorm'), __('$75,000 - $100,000', 'iphorm'), __('$100,000 - $150,000', 'iphorm'), __('$150,000 or more', 'iphorm')),
    __('Days', 'iphorm') => array(__('Monday'), __('Tuesday'), __('Wednesday'), __('Thursday'), __('Friday'), __('Saturday'), __('Sunday')),
    __('Months', 'iphorm') => array_values(iphorm_get_all_months())
    ));
}

/**
 * Returns an array of all countries
 *
 * @return array
 */
function iphorm_get_countries()
{
    return apply_filters('iphorm_countries', array(
    __('Afghanistan', 'iphorm'), __('Albania', 'iphorm'), __('Algeria', 'iphorm'), __('American Samoa', 'iphorm'), __('Andorra', 'iphorm'), __('Angola', 'iphorm'), __('Anguilla', 'iphorm'), __('Antarctica', 'iphorm'), __('Antigua And Barbuda', 'iphorm'), __('Argentina', 'iphorm'), __('Armenia', 'iphorm'), __('Aruba', 'iphorm'), __('Australia', 'iphorm'), __('Austria', 'iphorm'), __('Azerbaijan', 'iphorm'), __('Bahamas', 'iphorm'), __('Bahrain', 'iphorm'), __('Bangladesh', 'iphorm'), __('Barbados', 'iphorm'), __('Belarus', 'iphorm'), __('Belgium', 'iphorm'),
    __('Belize', 'iphorm'), __('Benin', 'iphorm'), __('Bermuda', 'iphorm'), __('Bhutan', 'iphorm'), __('Bolivia', 'iphorm'), __('Bosnia And Herzegovina', 'iphorm'), __('Botswana', 'iphorm'), __('Bouvet Island', 'iphorm'), __('Brazil', 'iphorm'), __('British Indian Ocean Territory', 'iphorm'), __('Brunei Darussalam', 'iphorm'), __('Bulgaria', 'iphorm'), __('Burkina Faso', 'iphorm'), __('Burundi', 'iphorm'), __('Cambodia', 'iphorm'), __('Cameroon', 'iphorm'), __('Canada', 'iphorm'), __('Cape Verde', 'iphorm'), __('Cayman Islands', 'iphorm'), __('Central African Republic', 'iphorm'), __('Chad', 'iphorm'),
    __('Chile', 'iphorm'), __('China', 'iphorm'), __('Christmas Island', 'iphorm'), __('Cocos (Keeling) Islands', 'iphorm'), __('Colombia', 'iphorm'), __('Comoros', 'iphorm'), __('Congo', 'iphorm'), __('Congo, The Democratic Republic Of The', 'iphorm'), __('Cook Islands', 'iphorm'), __('Costa Rica', 'iphorm'), __('Cote D\'Ivoire', 'iphorm'), __('Croatia (Local Name: Hrvatska)', 'iphorm'), __('Cuba', 'iphorm'), __('Cyprus', 'iphorm'), __('Czech Republic', 'iphorm'), __('Denmark', 'iphorm'), __('Djibouti', 'iphorm'), __('Dominica', 'iphorm'), __('Dominican Republic', 'iphorm'), __('East Timor', 'iphorm'), __('Ecuador', 'iphorm'),
    __('Egypt', 'iphorm'), __('El Salvador', 'iphorm'), __('Equatorial Guinea', 'iphorm'), __('Eritrea', 'iphorm'), __('Estonia', 'iphorm'), __('Ethiopia', 'iphorm'), __('Falkland Islands (Malvinas)', 'iphorm'), __('Faroe Islands', 'iphorm'), __('Fiji', 'iphorm'), __('Finland', 'iphorm'), __('France', 'iphorm'), __('France, Metropolitan', 'iphorm'), __('French Guiana', 'iphorm'), __('French Polynesia', 'iphorm'), __('French Southern Territories', 'iphorm'), __('Gabon', 'iphorm'), __('Gambia', 'iphorm'), __('Georgia', 'iphorm'), __('Germany', 'iphorm'), __('Ghana', 'iphorm'), __('Gibraltar', 'iphorm'),
    __('Greece', 'iphorm'), __('Greenland', 'iphorm'), __('Grenada', 'iphorm'), __('Guadeloupe', 'iphorm'), __('Guam', 'iphorm'), __('Guatemala', 'iphorm'), __('Guinea', 'iphorm'), __('Guinea-Bissau', 'iphorm'), __('Guyana', 'iphorm'), __('Haiti', 'iphorm'), __('Heard And Mc Donald Islands', 'iphorm'), __('Holy See (Vatican City State)', 'iphorm'), __('Honduras', 'iphorm'), __('Hong Kong', 'iphorm'), __('Hungary', 'iphorm'), __('Iceland', 'iphorm'), __('India', 'iphorm'), __('Indonesia', 'iphorm'), __('Iran (Islamic Republic Of)', 'iphorm'), __('Iraq', 'iphorm'), __('Ireland', 'iphorm'),
    __('Israel', 'iphorm'), __('Italy', 'iphorm'), __('Jamaica', 'iphorm'), __('Japan', 'iphorm'), __('Jordan', 'iphorm'), __('Kazakhstan', 'iphorm'), __('Kenya', 'iphorm'), __('Kiribati', 'iphorm'), __('Korea, Democratic People\'s Republic Of', 'iphorm'), __('Korea, Republic Of', 'iphorm'), __('Kuwait', 'iphorm'), __('Kyrgyzstan', 'iphorm'), __('Lao People\'s Democratic Republic', 'iphorm'), __('Latvia', 'iphorm'), __('Lebanon', 'iphorm'), __('Lesotho', 'iphorm'), __('Liberia', 'iphorm'), __('Libyan Arab Jamahiriya', 'iphorm'), __('Liechtenstein', 'iphorm'), __('Lithuania', 'iphorm'), __('Luxembourg', 'iphorm'),
    __('Macau', 'iphorm'), __('Macedonia, Former Yugoslav Republic Of', 'iphorm'), __('Madagascar', 'iphorm'), __('Malawi', 'iphorm'), __('Malaysia', 'iphorm'), __('Maldives', 'iphorm'), __('Mali', 'iphorm'), __('Malta', 'iphorm'), __('Marshall Islands', 'iphorm'), __('Martinique', 'iphorm'), __('Mauritania', 'iphorm'), __('Mauritius', 'iphorm'), __('Mayotte', 'iphorm'), __('Mexico', 'iphorm'), __('Micronesia, Federated States Of', 'iphorm'), __('Moldova, Republic Of', 'iphorm'), __('Monaco', 'iphorm'), __('Mongolia', 'iphorm'), __('Montserrat', 'iphorm'), __('Morocco', 'iphorm'), __('Mozambique', 'iphorm'),
    __('Myanmar', 'iphorm'), __('Namibia', 'iphorm'), __('Nauru', 'iphorm'), __('Nepal', 'iphorm'), __('Netherlands', 'iphorm'), __('Netherlands Antilles', 'iphorm'), __('New Caledonia', 'iphorm'), __('New Zealand', 'iphorm'), __('Nicaragua', 'iphorm'), __('Niger', 'iphorm'), __('Nigeria', 'iphorm'), __('Niue', 'iphorm'), __('Norfolk Island', 'iphorm'), __('Northern Mariana Islands', 'iphorm'), __('Norway', 'iphorm'), __('Oman', 'iphorm'), __('Pakistan', 'iphorm'), __('Palau', 'iphorm'), __('Panama', 'iphorm'), __('Papua New Guinea', 'iphorm'), __('Paraguay', 'iphorm'),
    __('Peru', 'iphorm'), __('Philippines', 'iphorm'), __('Pitcairn', 'iphorm'), __('Poland', 'iphorm'), __('Portugal', 'iphorm'), __('Puerto Rico', 'iphorm'), __('Qatar', 'iphorm'), __('Reunion', 'iphorm'), __('Romania', 'iphorm'), __('Russian Federation', 'iphorm'), __('Rwanda', 'iphorm'), __('Saint Kitts And Nevis', 'iphorm'), __('Saint Lucia', 'iphorm'), __('Saint Vincent And The Grenadines', 'iphorm'), __('Samoa', 'iphorm'), __('San Marino', 'iphorm'), __('Sao Tome And Principe', 'iphorm'), __('Saudi Arabia', 'iphorm'), __('Senegal', 'iphorm'), __('Seychelles', 'iphorm'), __('Sierra Leone', 'iphorm'),
    __('Singapore', 'iphorm'), __('Slovakia (Slovak Republic)', 'iphorm'), __('Slovenia', 'iphorm'), __('Solomon Islands', 'iphorm'), __('Somalia', 'iphorm'), __('South Africa', 'iphorm'), __('South Georgia, South Sandwich Islands', 'iphorm'), __('Spain', 'iphorm'), __('Sri Lanka', 'iphorm'), __('St. Helena', 'iphorm'), __('St. Pierre And Miquelon', 'iphorm'), __('Sudan', 'iphorm'), __('Suriname', 'iphorm'), __('Svalbard And Jan Mayen Islands', 'iphorm'), __('Swaziland', 'iphorm'), __('Sweden', 'iphorm'), __('Switzerland', 'iphorm'), __('Syrian Arab Republic', 'iphorm'), __('Taiwan', 'iphorm'), __('Tajikistan', 'iphorm'), __('Tanzania, United Republic Of', 'iphorm'),
    __('Thailand', 'iphorm'), __('Togo', 'iphorm'), __('Tokelau', 'iphorm'), __('Tonga', 'iphorm'), __('Trinidad And Tobago', 'iphorm'), __('Tunisia', 'iphorm'), __('Turkey', 'iphorm'), __('Turkmenistan', 'iphorm'), __('Turks And Caicos Islands', 'iphorm'), __('Tuvalu', 'iphorm'), __('Uganda', 'iphorm'), __('Ukraine', 'iphorm'), __('United Arab Emirates', 'iphorm'), __('United Kingdom', 'iphorm'), __('United States', 'iphorm'), __('United States Minor Outlying Islands', 'iphorm'), __('Uruguay', 'iphorm'), __('Uzbekistan', 'iphorm'), __('Vanuatu', 'iphorm'), __('Venezuela', 'iphorm'), __('Vietnam', 'iphorm'),
    __('Virgin Islands (British)', 'iphorm'), __('Virgin Islands (U.S.)', 'iphorm'), __('Wallis And Futuna Islands', 'iphorm'), __('Western Sahara', 'iphorm'), __('Yemen', 'iphorm'), __('Yugoslavia', 'iphorm'), __('Zambia', 'iphorm'), __('Zimbabwe', 'iphorm')
    ));
}

/**
 * Returns an array of US states
 *
 * @return array
 */
function iphorm_get_us_states()
{
    return array(
    __('Alabama', 'iphorm'), __('Alaska', 'iphorm'), __('Arizona', 'iphorm'), __('Arkansas', 'iphorm'), __('California', 'iphorm'), __('Colorado', 'iphorm'), __('Connecticut', 'iphorm'), __('Delaware', 'iphorm'), __('District Of Columbia', 'iphorm'), __('Florida', 'iphorm'), __('Georgia', 'iphorm'), __('Hawaii', 'iphorm'), __('Idaho', 'iphorm'),
    __('Illinois', 'iphorm'), __('Indiana', 'iphorm'), __('Iowa', 'iphorm'), __('Kansas', 'iphorm'), __('Kentucky', 'iphorm'), __('Louisiana', 'iphorm'), __('Maine', 'iphorm'), __('Maryland', 'iphorm'), __('Massachusetts', 'iphorm'), __('Michigan', 'iphorm'), __('Minnesota', 'iphorm'), __('Mississippi', 'iphorm'), __('Missouri', 'iphorm'), __('Montana', 'iphorm'),
    __('Nebraska', 'iphorm'), __('Nevada', 'iphorm'), __('New Hampshire', 'iphorm'), __('New Jersey', 'iphorm'), __('New Mexico', 'iphorm'), __('New York', 'iphorm'), __('North Carolina', 'iphorm'), __('North Dakota', 'iphorm'), __('Ohio', 'iphorm'), __('Oklahoma', 'iphorm'), __('Oregon', 'iphorm'), __('Pennsylvania', 'iphorm'), __('Rhode Island', 'iphorm'),
    __('South Carolina', 'iphorm'), __('South Dakota', 'iphorm'), __('Tennessee', 'iphorm'), __('Texas', 'iphorm'), __('Utah', 'iphorm'), __('Vermont', 'iphorm'), __('Virginia', 'iphorm'), __('Washington', 'iphorm'), __('West Virginia', 'iphorm'), __('Wisconsin', 'iphorm'), __('Wyoming', 'iphorm')
    );
}

/**
 * Returns an array of Canadian Provinces / Territories
 *
 * @return array
 */
function iphorm_get_canadian_provinces()
{
    return array(
    __('Alberta', 'iphorm'), __('British Columbia', 'iphorm'), __('Manitoba', 'iphorm'), __('New Brunswick', 'iphorm'),
    __('Newfoundland & Labrador', 'iphorm'), __('Northwest Territories', 'iphorm'), __('Nova Scotia', 'iphorm'), __('Nunavut', 'iphorm'), __('Ontario', 'iphorm'), __('Prince Edward Island', 'iphorm'), __('Quebec', 'iphorm'), __('Saskatchewan', 'iphorm'), __('Yukon', 'iphorm')
    );
}

/**
 * Returns an array of UK counties
 *
 * @return array
 */
function iphorm_get_uk_counties()
{
    return array(
    __('Aberdeenshire', 'iphorm'),
    __('Anglesey/Sir Fon', 'iphorm'),
    __('Angus/Forfarshire', 'iphorm'),
    __('Argyllshire', 'iphorm'),
    __('Ayrshire', 'iphorm'),
    __('Banffshire', 'iphorm'),
    __('Bedfordshire', 'iphorm'),
    __('Berkshire', 'iphorm'),
    __('Berwickshire', 'iphorm'),
    __('Brecknockshire/Sir Frycheiniog', 'iphorm'),
    __('Buckinghamshire', 'iphorm'),
    __('Buteshire', 'iphorm'),
    __('Caernarfonshire/Sir Gaernarfon', 'iphorm'),
    __('Caithness', 'iphorm'),
    __('Cambridgeshire', 'iphorm'),
    __('Cardiganshire/Ceredigion', 'iphorm'),
    __('Carmarthenshire/Sir Gaerfyrddin', 'iphorm'),
    __('Cheshire', 'iphorm'),
    __('Clackmannanshire', 'iphorm'),
    __('Cornwall', 'iphorm'),
    __('County Antrim', 'iphorm'),
    __('County Armagh', 'iphorm'),
    __('County Down', 'iphorm'),
    __('County Fermanagh', 'iphorm'),
    __('County Londonderry/Derry', 'iphorm'),
    __('County Tyrone', 'iphorm'),
    __('Cromartyshire', 'iphorm'),
    __('Cumberland', 'iphorm'),
    __('Denbighshire/Sir Ddinbych', 'iphorm'),
    __('Derbyshire', 'iphorm'),
    __('Devon', 'iphorm'),
    __('Dorset', 'iphorm'),
    __('Dumfriesshire', 'iphorm'),
    __('Dunbartonshire/Dumbartonshire', 'iphorm'),
    __('Durham', 'iphorm'),
    __('East Lothian/Haddingtonshire', 'iphorm'),
    __('East Yorkshire', 'iphorm'),
    __('Essex', 'iphorm'),
    __('Fife', 'iphorm'),
    __('Flintshire/Sir Fflint', 'iphorm'),
    __('Glamorgan/Morgannwg', 'iphorm'),
    __('Gloucestershire', 'iphorm'),
    __('Hampshire', 'iphorm'),
    __('Herefordshire', 'iphorm'),
    __('Hertfordshire', 'iphorm'),
    __('Huntingdonshire', 'iphorm'),
    __('Inverness-shire', 'iphorm'),
    __('Kent', 'iphorm'),
    __('Kincardineshire', 'iphorm'),
    __('Kinross-shire', 'iphorm'),
    __('Kirkcudbrightshire', 'iphorm'),
    __('Lanarkshire', 'iphorm'),
    __('Lancashire', 'iphorm'),
    __('Leicestershire', 'iphorm'),
    __('Lincolnshire', 'iphorm'),
    __('Merioneth/Meirionnydd', 'iphorm'),
    __('Middlesex', 'iphorm'),
    __('Midlothian/Edinburghshire', 'iphorm'),
    __('Monmouthshire/Sir Fynwy', 'iphorm'),
    __('Montgomeryshire/Sir Drefaldwyn', 'iphorm'),
    __('Morayshire', 'iphorm'),
    __('Nairnshire', 'iphorm'),
    __('Norfolk', 'iphorm'),
    __('North Yorkshire', 'iphorm'),
    __('Northamptonshire', 'iphorm'),
    __('Northumberland', 'iphorm'),
    __('Nottinghamshire', 'iphorm'),
    __('Orkney', 'iphorm'),
    __('Oxfordshire', 'iphorm'),
    __('Peeblesshire', 'iphorm'),
    __('Pembrokeshire/Sir Benfro', 'iphorm'),
    __('Perthshire', 'iphorm'),
    __('Radnorshire/Sir Faesyfed', 'iphorm'),
    __('Renfrewshire', 'iphorm'),
    __('Ross-shire', 'iphorm'),
    __('Roxburghshire', 'iphorm'),
    __('Rutland', 'iphorm'),
    __('Selkirkshire', 'iphorm'),
    __('Shetland', 'iphorm'),
    __('Shropshire', 'iphorm'),
    __('Somerset', 'iphorm'),
    __('Staffordshire', 'iphorm'),
    __('Stirlingshire', 'iphorm'),
    __('Suffolk', 'iphorm'),
    __('Surrey', 'iphorm'),
    __('Sussex', 'iphorm'),
    __('Sutherland', 'iphorm'),
    __('Warwickshire', 'iphorm'),
    __('West Lothian/Linlithgowshire', 'iphorm'),
    __('West Yorkshire', 'iphorm'),
    __('Westmorland', 'iphorm'),
    __('Wigtownshire', 'iphorm'),
    __('Wiltshire', 'iphorm'),
    __('Worcestershire', 'iphorm')
    );
}

add_action('wp_ajax_iphorm_get_export_field_list_ajax', 'iphorm_get_export_field_list_ajax');

/**
 * Get the list of available fields to export
 */
function iphorm_get_export_field_list_ajax()
{
    $id = isset($_POST['form_id']) ? absint($_POST['form_id']) : 0;

    if (iphorm_form_exists($id)) {
        $form = iphorm_get_form_config($id);
        $response = array(
            'type' => 'success',
            'data' => array()
        );

        foreach ($form['elements'] as $element) {
            if (isset($element['save_to_database']) && $element['save_to_database']) {
                $response['data'][] = array(
                    'value' => 'element_' . $element['id'],
                    'label' => iphorm_get_element_admin_label($element)
                );
            }
        }

        $defaultFields = iphorm_get_valid_entry_fields();
        foreach ($defaultFields as $key => $label) {
            $response['data'][] = array(
                'value' => $key,
                'label' => $label
            );
        }

        header('Content-Type: application/json');
        echo iphorm_json_encode($response);
        exit;
    }
}

add_action('admin_print_styles-quform_page_iphorm_export', 'iphorm_admin_enqueue_datepicker');

/**
 * Enqueue the datepicker on the admin page
 */
function iphorm_admin_enqueue_datepicker()
{
    wp_enqueue_style('iphorm-jquery-ui-theme', IPHORM_PLUGIN_URL . '/js/jqueryui/themes/smoothness/jquery-ui-1.8.16.custom.css');

    wp_enqueue_script('iphorm-jquery-ui-core', IPHORM_PLUGIN_URL . '/js/jqueryui/jquery.ui.core.min.js', array('jquery'), '1.8.16', true);
    wp_enqueue_script('iphorm-jquery-ui-datepicker', IPHORM_PLUGIN_URL . '/js/jqueryui/jquery.ui.datepicker.min.js', array('jquery', 'iphorm-jquery-ui-core'), '1.8.16', true);
}

add_action('auth_redirect', 'iphorm_export_entries');

/**
 * Export form entries
 */
function iphorm_export_entries()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['iphorm_do_entries_export']) && $_POST['iphorm_do_entries_export'] == 1) {
        if (isset($_POST['form_id']) && iphorm_form_exists($_POST['form_id'])) {
            $config = iphorm_get_form_config($_POST['form_id']);
            $id = $config['id'];
            $filenameFilter = new iPhorm_Filter_Filename();
            $filename = $filenameFilter->filter($config['name']);

            // Send headers
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=' . $filename . '-' . date('Y-m-d') . '.csv');

            global $wpdb;
            $elementsCache = array();
            // Build the query
            $sql = "SELECT `entries`.*";

            if (isset($config['elements']) && is_array($config['elements'])) {
                foreach ($config['elements'] as $element) {
                    if (isset($element['save_to_database']) && $element['save_to_database']) {
                        $elementId = absint($element['id']);
                        $sql .= ", GROUP_CONCAT(if (`data`.`element_id` = $elementId, value, NULL)) AS `element_$elementId`";
                        $elementsCache[$elementId] = iphorm_get_element_config($elementId, $config);
                    }
                }
            }

            if (isset($_POST['from'], $_POST['to'])) {
                $pattern = '/^\d{4}-\d{2}-\d{2}$/';
                if (preg_match($pattern, $_POST['from']) && preg_match($pattern, $_POST['to'])) {
                    $from = iphorm_local_to_utc($_POST['from'] . ' 00:00:00');
                    $to = iphorm_local_to_utc($_POST['to'] . ' 23:59:59');
                    $dateSql = $wpdb->prepare(' AND (`entries`.`date_added` >= %s AND `entries`.`date_added` <= %s)', array($from, $to));
                }
            }

            $sql .= "
            FROM `" . iphorm_get_form_entries_table_name() . "` `entries`
            LEFT JOIN `" . iphorm_get_form_entry_data_table_name() . "` `data` ON `data`.`entry_id` = `entries`.`id`
            WHERE `entries`.`form_id` = $id";

            if (isset($dateSql)) {
                $sql .= $dateSql;
            }

            $sql .= "
            GROUP BY `entries`.`id`;";

            $wpdb->query('SET @@GROUP_CONCAT_MAX_LEN = 65535');
            $entries = $wpdb->get_results($sql, ARRAY_A);

            $validFields = array(
                'id' => 'Entry ID',
                'date_added' => 'Date',
                'ip' => 'IP address',
                'form_url' => 'Form URL',
                'referring_url' => 'Referring URL',
                'post_id' => 'Post / page ID',
                'post_title' => 'Post / page title',
                'user_display_name' => 'User WordPress display name',
                'user_email' => 'User WordPress email',
                'user_login' => 'User WordPress login'
            );

            // Sanitize chosen fields
            $validFields = iphorm_get_valid_entry_fields();
            $fields = array();
            if (isset($_POST['export_fields']) && is_array($_POST['export_fields'])) {
                // Check which fields have been chosen for export and get their labels
                foreach ($_POST['export_fields'] as $field) {
                    if (array_key_exists($field, $validFields)) {
                        // It's a default column, get the label
                        $fields[$field] = $validFields[$field];
                    } elseif (preg_match('/element_(\d+)/', $field, $matches)) {
                        // It's an element column, so get the element label
                        $elementId = absint($matches[1]);
                        if (isset($elementsCache[$elementId])) {
                            $label = iphorm_get_element_admin_label($elementsCache[$elementId]);
                        } else {
                            $label = '';
                        }
                        $fields[$field] = $label;
                    }
                }
            }

            $fh = fopen('php://output', 'w');
            // Write column headings row
            fputcsv($fh, $fields);

            // Write each entry
            if (is_array($entries)) {
                foreach ($entries as $entry) {
                    $row = array();

                    foreach ($fields as $field => $label) {
                        $row[$field] = isset($entry[$field]) ? $entry[$field] : '';

                        if (strlen($row[$field]) && strpos($field, 'element_') !== false) {
                            $elementId = absint(str_replace('element_', '', $field));
                            if (isset($elementsCache[$elementId])) {
                                // Per element modifications to the output
                                if (isset($elementsCache[$elementId]['type'])) {
                                    switch ($elementsCache[$elementId]['type']) {
                                        case 'email':
                                            // Email elements: remove <a> tag
                                            $row[$field] = trim(strip_tags($row[$field]));
                                            break;
                                        case 'checkbox':
                                        case 'radio':
                                            // Multiple elements: replace <br /> with new line
                                            $row[$field] = trim(preg_replace('/<br\s*?\/>/', "\n", $row[$field]));
                                            break;
                                        case 'file':
                                            // File uploads: replace <br /> with newline, remove anchor tag, use href attr as value
                                            $result = preg_match_all('/href=([\'"])?((?(1).+?|[^\s>]+))(?(1)\1)/is', $row[$field], $uploads);
                                            if ($result > 0) {
                                                $row[$field] = join("\n", $uploads[2]);
                                            } else {
                                                $row[$field] = trim(preg_replace('/<br\s*?\/>/', "\n", $row[$field]));
                                            }
                                            break;
                                    }
                                }
                            }
                        }

                        // Format the date to include the WordPress Timezone offset
                        if ($field === 'date_added') {
                            $row[$field] = iphorm_format_date($row[$field]);
                        }
                    }

                    fputcsv($fh, $row);
                }
            }

            fclose($fh);
            exit;
        }
    }
}

/**
 * Get the list of default valid entry fields
 *
 * @return array
 */
function iphorm_get_valid_entry_fields()
{
    return array(
        'id' => __('Entry ID', 'iphorm'),
        'date_added' => __('Date', 'iphorm'),
        'ip' => __('IP address', 'iphorm'),
        'form_url' => __('Form URL', 'iphorm'),
        'referring_url' => __('Referring URL', 'iphorm'),
        'post_id' => __('Post / page ID', 'iphorm'),
        'post_title' => __('Post / page title', 'iphorm'),
        'user_display_name' => __('User WordPress display name', 'iphorm'),
        'user_email' => __('User WordPress email', 'iphorm'),
        'user_login' => __('User WordPress login', 'iphorm')
    );
}

/**
 * Alternative fputcsv function if it doesn't exist
 */
if (!function_exists('fputcsv')) {
    function fputcsv(&$handle, $fields = array(), $delimiter = ',', $enclosure = '"') {

        // Sanity Check
        if (!is_resource($handle)) {
            trigger_error('fputcsv() expects parameter 1 to be resource, ' .
            gettype($handle) . ' given', E_USER_WARNING);
            return false;
        }

        if ($delimiter!=NULL) {
            if( strlen($delimiter) < 1 ) {
                trigger_error('delimiter must be a character', E_USER_WARNING);
                return false;
            }elseif( strlen($delimiter) > 1 ) {
                trigger_error('delimiter must be a single character', E_USER_NOTICE);
            }

            /* use first character from string */
            $delimiter = $delimiter[0];
        }

        if( $enclosure!=NULL ) {
            if( strlen($enclosure) < 1 ) {
                trigger_error('enclosure must be a character', E_USER_WARNING);
                return false;
            }elseif( strlen($enclosure) > 1 ) {
                trigger_error('enclosure must be a single character', E_USER_NOTICE);
            }

            /* use first character from string */
            $enclosure = $enclosure[0];
        }

        $i = 0;
        $csvline = '';
        $escape_char = '\\';
        $field_cnt = count($fields);
        $enc_is_quote = in_array($enclosure, array('"',"'"));
        reset($fields);

        foreach( $fields AS $field ) {

            /* enclose a field that contains a delimiter, an enclosure character, or a newline */
            if( is_string($field) && (
            strpos($field, $delimiter)!==false ||
            strpos($field, $enclosure)!==false ||
            strpos($field, $escape_char)!==false ||
            strpos($field, "\n")!==false ||
            strpos($field, "\r")!==false ||
            strpos($field, "\t")!==false ||
            strpos($field, ' ')!==false ) ) {

                $field_len = strlen($field);
                $escaped = 0;

                $csvline .= $enclosure;
                for( $ch = 0; $ch < $field_len; $ch++ )    {
                    if( $field[$ch] == $escape_char && $field[$ch+1] == $enclosure && $enc_is_quote ) {
                        continue;
                    }elseif( $field[$ch] == $escape_char ) {
                        $escaped = 1;
                    }elseif( !$escaped && $field[$ch] == $enclosure ) {
                        $csvline .= $enclosure;
                    }else{
                        $escaped = 0;
                    }
                    $csvline .= $field[$ch];
                }
                $csvline .= $enclosure;
            } else {
                $csvline .= $field;
            }

            if( $i++ != $field_cnt ) {
                $csvline .= $delimiter;
            }
        }

        $csvline .= "\n";

        return fwrite($handle, $csvline);
    }
}

/**
 * Get the element config with the given ID
 *
 * @param int $elementId
 * @param array $form
 */
function iphorm_get_element_config($elementId, $form)
{
    if (isset($form['elements']) && is_array($form['elements'])) {
        foreach ($form['elements'] as $element) {
            if ($element['id'] == $elementId) {
                return $element;
            }
        }
    }

    return null;
}

add_action('wp_ajax_iphorm_set_fancybox_requested', 'iphorm_set_fancybox_requested');

/**
 * Sets that fancybox should be loaded
 */
function iphorm_set_fancybox_requested()
{
    update_option('iphorm_fancybox_requested', true);
    exit;
}

/**
 * Returns an HTML options list of only email elements
 *
 * @param array $config The form config
 * @param int $selected Selected element ID
 */
function iphorm_email_elements_as_options($config, $selected)
{
    $xhtml = '';
    foreach ($config['elements'] as $element) {
        if ($element['type'] == 'email') {
            $xhtml .= '<option value="' . $element['id'] . '" ' . selected($element['id'], $selected, false) . '>' . iphorm_get_element_admin_label($element) . '</option>';
        }
    }
    return $xhtml;
}

/**
 * Formats a date to local time and translates
 *
 * @param string $datetime
 * @param boolean $hideDateIfSameDay
 */
function iphorm_format_date($datetime, $hideDateIfSameDay = false)
{
    if (!strlen($datetime)) {
        return '';
    }

    $dateAdded = mysql2date('G', $datetime);
    $dateAdded += get_option('gmt_offset') * 3600;

    if ($hideDateIfSameDay && date('Y-m-d', $dateAdded) == date('Y-m-d')) {
        return date_i18n(get_option('time_format'), $dateAdded);
    } else {
        return date_i18n(get_option('time_format'), $dateAdded) . ' ' . date_i18n(get_option('date_format'), $dateAdded);
    }
}

/**
 * Converts a date in YYYY-MM-DD format to UTC time taking into
 * account the WordPress Timezone setting
 *
 * @param string $date
 * @return string The date in MySQL DATETIME format
 */
function iphorm_local_to_utc($date)
{
    // Get the number of minutes offset
    $offsetMinutes = get_option('gmt_offset') * 60;

    // Get the number of hours and minutes
    $hours = absint($offsetMinutes / 60);
    $minutes = absint($offsetMinutes % 60);

    // Pad with zero
    $hours = str_pad($hours, 2, '0', STR_PAD_LEFT);
    $minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);

    // Join together
    $offset = $hours . $minutes;

    // If it's a positive offset add a +
    if ($offsetMinutes >= 0) {
        $offset = '+' . $offset;
    } else {
        $offset = '-' . $offset;
    }

    // Get the Unix timestamp of the offset date
    $timestamp = strtotime($date . ' ' . $offset);

    // Return the date in MySQL DATETIME format
    return date('Y-m-d H:i:s', $timestamp);
}

function iphorm_global_nav($active)
{
    $activeStr = 'class="iphorm-global-nav-active"';
    ?>
<div class="iphorm-global-nav-wrap clearfix">
    <ul class="iphorm-global-nav-ul">
        <li><a href="admin.php?page=iphorm_forms" <?php if ($active == 'forms') echo $activeStr; ?>><span class="ifb-no-arrow"><?php esc_html_e('All Forms', 'iphorm'); ?></span></a></li>
        <li><a href="admin.php?page=iphorm_form_builder" <?php if ($active == 'form_builder') echo $activeStr; ?>><span class="ifb-no-arrow"><?php esc_html_e('Form Builder', 'iphorm'); ?></span></a></li>
        <li><a href="admin.php?page=iphorm_entries" <?php if ($active == 'entries') echo $activeStr; ?>><span class="ifb-no-arrow"><?php esc_html_e('Entries', 'iphorm'); ?></span></a></li>
        <li><a href="admin.php?page=iphorm_import" <?php if ($active == 'import') echo $activeStr; ?>><span class="ifb-no-arrow"><?php esc_html_e('Import', 'iphorm'); ?></span></a></li>
        <li><a href="admin.php?page=iphorm_export" <?php if ($active == 'export') echo $activeStr; ?>><span class="ifb-no-arrow"><?php esc_html_e('Export', 'iphorm'); ?></span></a></li>
        <li><a href="admin.php?page=iphorm_settings" <?php if ($active == 'settings') echo $activeStr; ?>><span class="ifb-no-arrow"><?php esc_html_e('Settings', 'iphorm'); ?></span></a></li>
        <li><a href="admin.php?page=iphorm_help" <?php if ($active == 'help') echo $activeStr; ?>><span class="ifb-no-arrow"><?php esc_html_e('Help', 'iphorm'); ?></span></a></li>
    </ul>
</div>
    <?php
}

/**
 * This is a duplicate of the list_files WP function as it seems we cannot
 * rely on this function being available when processing Ajax calls
 *
 * @param string $folder Full path to folder
 * @param int $levels (optional) Levels of folders to follow, Default: 100 (PHP Loop limit).
 * @return bool|array False on failure, Else array of files
 */
function iphorm_list_files( $folder = '', $levels = 100 ) {
    if ( empty($folder) )
        return false;

    if ( ! $levels )
        return false;

    $files = array();
    if ( $dir = @opendir( $folder ) ) {
        while (($file = readdir( $dir ) ) !== false ) {
            if ( in_array($file, array('.', '..') ) )
                continue;
            if ( is_dir( $folder . '/' . $file ) ) {
                $files2 = iphorm_list_files( $folder . '/' . $file, $levels - 1);
                if ( $files2 )
                    $files = array_merge($files, $files2 );
                else
                    $files[] = $folder . '/' . $file . '/';
            } else {
                $files[] = $folder . '/' . $file;
            }
        }
    }
    @closedir( $dir );
    return $files;
}

/**
 * Updgrade fixes for versions before DB version 4 (plugin versions before 1.3.3)
 */
function iphorm_upgrade_4()
{
    $forms = iphorm_get_all_forms();

    foreach ($forms as $form) {
        if (isset($form['conditional_recipients'])) {
            foreach ($form['conditional_recipients'] as &$recipient) {
                $crElement = iphorm_get_element_config($recipient['element'], $form);
                if ($crElement['type'] == 'radio') {
                    $recipient['value'] = _wp_specialchars($recipient['value'], ENT_NOQUOTES);
                }
            }
        }

        foreach ($form['elements'] as &$element) {
            // Go through the logic rules and escape the value if the element that the rule is referring to is a checkbox or radio element
            if (isset($element['logic_rules']) && is_array($element['logic_rules'])) {
                foreach ($element['logic_rules'] as &$logicRule) {
                    $lrElement = iphorm_get_element_config($logicRule['element_id'], $form);
                    if (in_array($lrElement['type'], array('checkbox', 'radio'))) {
                        $logicRule['value'] = _wp_specialchars($logicRule['value'], ENT_NOQUOTES);
                    }
                }
            }

            if ($element['type'] == 'groupstart') {
                // Escape Group title and description
                $element['title'] = _wp_specialchars($element['title'], ENT_NOQUOTES);
                $element['description'] = _wp_specialchars($element['description'], ENT_NOQUOTES);
            } elseif (in_array($element['type'], array('radio', 'checkbox'))) {
                // Escape options labels and values for radio and checkbox elements
                foreach ($element['options'] as &$option) {
                    $option['label'] = _wp_specialchars($option['label'], ENT_NOQUOTES);
                    $option['value'] = _wp_specialchars($option['value'], ENT_NOQUOTES);
                }
            }
        }

        iphorm_save_form($form);
    }
}