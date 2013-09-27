<?php

if (!defined('IPHORM_VERSION')) exit;

require_once IPHORM_INCLUDES_DIR . '/widget.php';
require_once IPHORM_INCLUDES_DIR . '/CSSParser/CSSParser.php';
require_once IPHORM_INCLUDES_DIR . '/Podio/PodioAPI.php';
require_once IPHORM_INCLUDES_DIR . '/Twilio/Services/Twilio.php';
require_once IPHORM_INCLUDES_DIR . '/iPhorm.php';
require_once ABSPATH . WPINC . '/class-phpmailer.php';

iPhorm::registerAutoload();

load_plugin_textdomain('iphorm', false, dirname(IPHORM_PLUGIN_BASENAME) . '/languages/');

/**
 * Start a PHP session if necessary
 *
 * We need to start a session:
 *
 * 1. On the frontend when showing the form
 * 2. When processing an SWFUpload file upload
 * 3. When displaying the form via Ajax
 */
if (!session_id() && !headers_sent()) {
    if (!is_admin()) {
        // We're on the front end so we need a session
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['iphorm_swfupload']) && $_GET['iphorm_swfupload'] == 1 && isset($_POST['PHPSESSID'])) {
            // Sets the session ID if we are uploading via SWFUpload
            session_id($_POST['PHPSESSID']);
        }

        session_start();
    } elseif (defined('DOING_AJAX') && DOING_AJAX === true && isset($_GET['action']) && $_GET['action'] === 'iphorm_show_form_ajax') {
        // We are displaying the form via Ajax
        session_start();
    }
}

/**
 * Get the name of the iPhorm forms table including the wpdb prefix
 *
 * @return string
 */
function iphorm_get_form_table_name()
{
    global $wpdb;

    return $wpdb->prefix . 'iphorm_forms';
}

/**
 * Get the name of the iPhorm submitted entries table including the wpdb prefix
 *
 * @return string
 */
function iphorm_get_form_entries_table_name()
{
    global $wpdb;

    return $wpdb->prefix . 'iphorm_form_entries';
}

/**
 * Get the name of the iPhorm submitted entries data including the wpdb prefix
 *
 * @return string
 */
function iphorm_get_form_entry_data_table_name()
{
    global $wpdb;

    return $wpdb->prefix . 'iphorm_form_entry_data';
}

/**
 * Get the count of the forms
 *
 * @param int $active Filter by active 1 or 0
 */
function iphorm_get_form_count($active = null)
{
    global $wpdb;

    $sql = "SELECT COUNT(id) FROM " . iphorm_get_form_table_name();

    if ($active !== null) {
        $active = absint($active);
        $sql .= " WHERE active = $active";
    }

    return absint($wpdb->get_var($sql));
}

/**
 * Get all the form rows from the database
 *
 * @param int $active 1 or 0 to get only active or inactive forms
 * @return object The result object
 */
function iphorm_get_all_form_rows($active = null)
{
    global $wpdb;

    $sql = "SELECT * FROM " . iphorm_get_form_table_name();

    if ($active !== null) {
        $active = absint($active);
        $sql .= " WHERE active = $active";
    }

    return $wpdb->get_results($sql);
}

/**
 * Get all the forms from the database
 *
 * @param int $active 1 or 0 to get only active or inactive forms
 * @return array An array of form configs
 */
function iphorm_get_all_forms($active = null)
{
    $forms = array();
    $rows = iphorm_get_all_form_rows($active);

    if (count($rows)) {
        foreach ($rows as $row) {
            $forms[] = maybe_unserialize($row->config);
        }
    }

    return $forms;
}

/**
 * Checks if the form with the given ID exists
 *
 * @param int $id
 * @return boolean
 */
function iphorm_form_exists($id)
{
    global $wpdb;

    $sql = "SELECT id FROM " . iphorm_get_form_table_name() . " WHERE id = " . absint($id);

    if ($wpdb->get_var($sql) === null) {
        return false;
    } else {
        return true;
    }
}

/**
 * Encodes the given value in JSON
 *
 * @param mixed $value
 */
function iphorm_json_encode($value)
{
    if (function_exists('json_encode')) {
        return json_encode($value);
    } else {
        if (!class_exists('Services_JSON')) {
            require_once IPHORM_INCLUDES_DIR . '/JSON.php';
        }
        $json = new Services_JSON();
        return $json->encode($value);
    }
}

/**
 * Decode the given value from JSON
 *
 * @param mixed $value
 * @param boolean $assoc Decodes to associative array if true
 */
function iphorm_json_decode($value, $assoc = false)
{
    if (function_exists('json_decode')) {
        return json_decode($value, $assoc);
    } else {
        if (!class_exists('Services_JSON')) {
            require_once IPHORM_INCLUDES_DIR . '/JSON.php';
        }
        $json = $assoc ? new Services_JSON(SERVICES_JSON_LOOSE_TYPE) : new Services_JSON();
        return $json->decode($value);
    }
}

/**
 * Get the form row from the database with the given ID
 *
 * @param int $id
 * @return stdClass|null
 */
function iphorm_get_form_row($id)
{
    global $wpdb;
    $id = absint($id);

    $sql = "SELECT * FROM " . iphorm_get_form_table_name() . " WHERE id = %d";

    return $wpdb->get_row($wpdb->prepare($sql, $id));
}

/**
 * Get the form config with the given ID
 *
 * @param int $id
 * @return array|null
 */
function iphorm_get_form_config($id)
{
    global $wpdb;
    $id = absint($id);

    $sql = "SELECT config FROM " . iphorm_get_form_table_name() . " WHERE id = %d";

    $config = $wpdb->get_var($wpdb->prepare($sql, $id));

    return maybe_unserialize($config);
}

/**
 * Get the form object with the given ID
 *
 * @param int $id
 * @param string $uid
 * @return iPhorm
 */
function iphorm_get_form($id, $uid = '', $values = '')
{
    $config = iphorm_get_form_config($id);

    if ($config !== null) {
        if (strlen($uid)) {
            $config['uniq_id'] = $uid;
        }

        $config['dynamic_values'] = $values;

        $form = new iPhorm($config);

        return $form;
    } else {
        return null;
    }
}

/**
 * Display (returns) the HTML of the given form
 *
 * @param iPhorm $form
 */
function iphorm_display_form(iPhorm $form)
{
    ob_start();

    include IPHORM_INCLUDES_DIR . '/form.php';

    return ob_get_clean();
}

/**
 * Get all the months in the year
 *
 * @return array
 */
function iphorm_get_all_months()
{
    return array(
        1 => __('January'),
        2 => __('February'),
        3 => __('March'),
        4 => __('April'),
        5 => __('May'),
        6 => __('June'),
        7 => __('July'),
        8 => __('August'),
        9 => __('September'),
        10 => __('October'),
        11 => __('November'),
        12 => __('December')
    );
}


/**
 * Get the replaced year for date element Year select,
 * with any placeholder tags replaced
 *
 * @param mixed $year The string placeholder or number of the year
 * @return int
 */
function iphorm_get_year($year = null)
{
    if ($year === '' || $year === null) {
        return null;
    } else if ($year == '{year}') {
        $y = (int) date('Y');
    } else if (preg_match('/^{year\|([+|-])(\d+)}$/', $year, $matches)) {
        $y = (int) date('Y');
        if ($matches[1] == '+') {
            $y += $matches[2];
        } else {
            $y -= $matches[2];
        }
    } else {
        $y = (int) $year;
    }

    return $y;
}

/**
 * Get the replaced start year of date element Year select,
 * with any placeholder tags replaced. Returns the default start
 * year of {current_date}+4 if the year is not specified.
 *
 * @param mixed $year The string placeholder or number of the year
 * @return int
 */
function iphorm_get_start_year($year = null)
{
    $startYear = iphorm_get_year($year);

    return $startYear === null ? ((int) date('Y') + 4) : $startYear;
}

/**
 * Get the replaced end year of date element Year select,
 * with any placeholder tags replaced. Returns the default end
 * year of 1900 if the year is not specified.
 *
 * @param mixed $year The string placeholder or number of the year
 * @return int
 */
function iphorm_get_end_year($year = null)
{
    $endYear = iphorm_get_year($year);

    return $endYear === null ? 1900 : $endYear;
}

/**
 * Get the list of available date formats, the key
 * is the format string passed to date() and the value
 * is an example formatted date.
 *
 * @return array
 */
function iphorm_get_date_formats()
{
    $testDate = strtotime('18th March 2011 17:35');
    $dateFormats = array();
    $formats = array(
        'l, jS F Y',
        'D, jS M Y',
        'jS F Y',
        'jS M Y',
        'd/m/Y',
        'm/d/Y',
        'Y/m/d',
        'Y-m-d',
        'd-m-Y',
        'd.m.Y'
    );

    foreach ($formats as $format) {
        $dateFormats[$format] = date_i18n($format, $testDate);
    }

    return $dateFormats;
}

/**
 * Get the list of available time formats, the key
 * is the format string passed to date() and the value
 * is an example formatted time.
 *
 * @return array
 */
function iphorm_get_time_formats()
{
    $testDate = strtotime('18th March 2011 17:35');
    $timeFormats = array();
    $formats = array(
        'g:i a',
        'g:ia',
        'g:i A',
        'g:iA',
        'H:i'
    );

    foreach ($formats as $format) {
        $timeFormats[$format] = date_i18n($format, $testDate);
    }

    return $timeFormats;
}

/**
 * Get the absolute path to the WordPress upload directory. If the
 * path is not writable it will return false.
 *
 * @return string|false
 */
function iphorm_get_wp_uploads_dir()
{
    $uploadDir = wp_upload_dir();
    if ($uploadDir['error'] == false) {
        return $uploadDir['basedir'];
    }

    return false;
}

/**
 * Get the full URL to the WordPress upload directory.
 *
 * @return string|false
 */
function iphorm_get_wp_uploads_url()
{
    $uploadDir = wp_upload_dir();
    return $uploadDir['baseurl'];
}


/**
 * Frontend JavaScript localisation
 */
function iphorm_js_l10n()
{
    return array(
        'error_submitting_form' => __('An error occurred submitting the form', 'iphorm'),
        'swfupload_flash_url' => includes_url('js/swfupload/swfupload.swf'),
        'swfupload_upload_url' => site_url('?iphorm_swfupload=1'),
        'swfupload_too_many' => __('You have attempted to queue too many files', 'iphorm'),
        'swfupload_file_too_big' => __('This file exceeds the maximum upload size', 'iphorm'),
        'swfupload_file_empty' => __('This file is empty', 'iphorm'),
        'swfupload_file_type_not_allowed' => __('This file type is not allowed', 'iphorm'),
        'swfupload_unknown_queue_error' => __('Unknown queue error, please try again later', 'iphorm'),
        'swfupload_upload_error' => __('Upload error', 'iphorm'),
        'swfupload_upload_failed' => __('Upload failed', 'iphorm'),
        'swfupload_server_io' => __('Server IO error', 'iphorm'),
        'swfupload_security_error' => __('Security error', 'iphorm'),
        'swfupload_limit_exceeded' => __('Upload limit exceeded', 'iphorm'),
        'swfupload_validation_failed' => __('Validation failed', 'iphorm'),
        'swfupload_upload_stopped' => __('Upload stopped', 'iphorm'),
        'swfupload_unknown_upload_error' => __('Unknown upload error', 'iphorm'),
        'plugin_url' => IPHORM_PLUGIN_URL,
        'preview_no_submit' => __('The form cannot be submitted in the preview', 'iphorm')
    );
}

add_action('wp_loaded', 'iphorm_process_form_ajax');

/**
 * Hook for processing the forms submitted via Ajax
 */
function iphorm_process_form_ajax()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['iphorm_ajax']) && $_POST['iphorm_ajax'] == 1) {
        echo iphorm_process_form();
        exit;
    }
}

/**
 * Process the form and returns the response
 *
 * @return string
 */
function iphorm_process_form()
{
    $ajax = isset($_POST['iphorm_ajax']) && $_POST['iphorm_ajax'] == 1;
    $swfu = isset($_POST['iphorm_swfu']) && $_POST['iphorm_swfu'] == 1;

    if (isset($_POST['iphorm_id']) && isset($_POST['iphorm_uid']) && (($form = iphorm_get_form($_POST['iphorm_id'], $_POST['iphorm_uid'])) instanceof iPhorm) && $form->getActive()) {
        // Strip slashes from the submitted data (WP adds them automatically)
        $_POST = stripslashes_deep($_POST);

        // Pre-process action hooks
        do_action('iphorm_pre_process', $form);
        do_action('iphorm_pre_process_' . $form->getId(), $form);

        $response = '';

        // If we have files uploaded via SWFUpload, merge them into $_FILES
        if ($swfu && isset($_SESSION['iphorm-' . $form->getUniqId()])) {
            $_FILES = array_merge($_FILES, $_SESSION['iphorm-' . $form->getUniqId()]);
        }

        // Set hidden conditional logic elements to be not required
        if (isset($_POST['hcle']) && strlen($_POST['hcle'])) {
            $hclElementIds = explode(',', $_POST['hcle']);
            $hclElementIds = array_map('absint', $hclElementIds);

            // Only affect elements that actually have conditional logic
            $conditionalLogicElementIds = $form->getConditionalLogicElementIds();
            $hclElementIds = array_intersect($hclElementIds, $conditionalLogicElementIds);

            // Build up the list of affected elements
            $allElementIds = array();
            foreach ($hclElementIds as $hclElementId) {
                $hclElement = $form->getElementById($hclElementId);
                if ($hclElement instanceof iPhorm_Element_GroupStart) {
                    // Get all elements from inside a group
                    $allElementIds = array_merge($allElementIds, iphorm_get_group_element_ids($form, $hclElement));
                } elseif (!$hclElement instanceof iPhorm_Element_Groupend) {
                    $allElementIds[] = $hclElement->getId();
                }
            }
            // Remove any duplicates
            $allElementIds = array_unique($allElementIds);

            // Set them not required
            foreach ($allElementIds as $allElementId) {
                $allElement = $form->getElementById($allElementId);
                $allElement->setRequired(false);
            }
        }

        if ($form->isValid($_POST)) {
            // Process any uploads first
            $attachments = array();
            $elements = $form->getElements();

            foreach ($elements as $element) {
                if ($element instanceof iPhorm_Element_File) {
                    $elementName = $element->getName();
                    if (array_key_exists($elementName, $_FILES) && is_array($_FILES[$elementName])) {
                        $file = $_FILES[$elementName];
                        if (is_array($file['error'])) {
                            // Process multiple upload field
                            foreach ($file['error'] as $key => $error) {
                                if ($error === UPLOAD_ERR_OK) {
                                    $pathInfo = pathinfo($file['name'][$key]);
                                    $extension = isset($pathInfo['extension']) ? $pathInfo['extension'] : '';

                                    $filenameFilter = new iPhorm_Filter_Filename();
                                    $filename = strlen($extension) ? str_replace(".$extension", '', $pathInfo['basename']) : $pathInfo['basename'];
                                    $filename = $filenameFilter->filter($filename);
                                    if (strlen($extension)) {
                                        $filename = (strlen($filename)) ? "$filename.$extension" : "upload.$extension";
                                    } else {
                                        $filename = (strlen($filename)) ? $filename : 'upload';
                                    }

                                    $fullPath = $file['tmp_name'][$key];
                                    $value = array('text' => $filename);

                                    if ($element->getSaveToServer()) {
                                        $result = iphorm_save_uploaded_file($fullPath, $filename, $element, $form->getId());

                                        if ($result !== false) {
                                            $fullPath = $result['fullPath'];
                                            $filename = $result['filename'];

                                            $value = array(
                                                'url' => iphorm_get_wp_uploads_url() . '/' . $result['path'] . $filename,
                                                'text' => $filename
                                            );
                                        }
                                    }

                                    if ($element->getAddAsAttachment()) {
                                        $attachments[] = array(
                                            'fullPath' => $fullPath,
                                            'type' => $file['type'][$key],
                                            'filename' => $filename
                                        );
                                    }

                                    $element->addFile($value);
                                }
                            }
                        } else {
                            // Process single upload field
                            if ($file['error'] === UPLOAD_ERR_OK) {
                                $pathInfo = pathinfo($file['name']);
                                $extension = isset($pathInfo['extension']) ? $pathInfo['extension'] : '';

                                $filenameFilter = new iPhorm_Filter_Filename();
                                $filename = strlen($extension) ? str_replace(".$extension", '', $pathInfo['basename']) : $pathInfo['basename'];
                                $filename = $filenameFilter->filter($filename);
                                if (strlen($extension)) {
                                    $filename = (strlen($filename)) ? "$filename.$extension" : "upload.$extension";
                                } else {
                                    $filename = (strlen($filename)) ? $filename : 'upload';
                                }

                                $fullPath = $file['tmp_name'];
                                $value = array('text' => $filename);

                                if ($element->getSaveToServer()) {
                                    $result = iphorm_save_uploaded_file($fullPath, $filename, $element, $form->getId());

                                    if (is_array($result)) {
                                        $fullPath = $result['fullPath'];
                                        $filename = $result['filename'];

                                        $value = array(
                                            'url' => iphorm_get_wp_uploads_url() . '/' . $result['path'] . $filename,
                                            'text' => $filename
                                        );
                                    }
                                }

                                if ($element->getAddAsAttachment()) {
                                    $attachments[] = array(
                                        'fullPath' => $fullPath,
                                        'type' => $file['type'],
                                        'filename' => $filename
                                    );
                                }

                                $element->addFile($value);
                            }
                        }
                    } // end in $_FILES
                } // end instanceof file
            } // end foreach element

            // Check if we need to send any emails
            if ($form->getSendNotification() || $form->getSendAutoreply()) {
                // Get a new PHP mailer instance
                $mailer = iphorm_new_phpmailer($form);

                // Create an email address validator, we'll need to use it later
                $emailValidator = new iPhorm_Validator_Email();

                // Check if we should send the notification email
                if ($form->getSendNotification() && count($form->getRecipients())) {
                    // Set the from address
                    $notificationFromInfo = $form->getNotificationFromInfo();
                    $mailer->From = $notificationFromInfo['email'];
                    $mailer->FromName = $notificationFromInfo['name'];

                    // Set the Reply-To header
                    if (($replyToElement = $form->getNotificationReplyToElement()) instanceof iPhorm_Element_Email
                    && $emailValidator->isValid($replyToEmail = $replyToElement->getValue())) {
                        $mailer->AddReplyTo($replyToEmail);
                    }

                    // Set the subject
                    $mailer->Subject = $form->replacePlaceholderValues($form->getSubject());

                    // Check for conditional recipient rules
                    if (count($form->getConditionalRecipients())) {
                        $recipients = array();
                        foreach ($form->getConditionalRecipients() as $rule) {
                            if (isset($rule['element'], $rule['value'], $rule['operator'], $rule['recipient'])
                                && ($rElement = $form->getElementById($rule['element'])) instanceof iPhorm_Element_Multi) {
                                if ($rule['operator'] == 'eq') {
                                    if ($rElement->getValue() == $rule['value']) {
                                        $recipients = array_merge($recipients, explode(", ", $rule['recipient']));
                                    }
                                } else {
                                    if ($rElement->getValue() != $rule['value']) {
                                        $recipients = array_merge($recipients, explode(", ", $rule['recipient']));
                                    }
                                }
                            }
                        }

                        if (count($recipients)) {
                            foreach ($recipients as $recipient) {
                                if ( $emailValidator->isValid($recipient) ) {
                                    $mailer->AddAddress($recipient);
                                }
                            }
                        }
                    }

                    // Set the default recipients
                    foreach ($form->getRecipients() as $recipient) {
                        $mailer->AddAddress($recipient);
                    }

                    // Set the message content
                    $emailHTML = '';
                    $emailPlain = '';
                    if ($form->getCustomiseEmailContent()) {
                        if ($form->getNotificationFormat() == 'html') {
                            $emailHTML = $form->getNotificationEmailContent();
                        } else {
                            $emailPlain = $form->getNotificationEmailContent();
                        }

                        // Replace any placeholder values
                        $emailHTML = $form->replacePlaceholderValues($emailHTML);
                        $emailPlain = $form->replacePlaceholderValues($emailPlain);
                    } else {
                        ob_start();
                        include IPHORM_INCLUDES_DIR . '/emails/email-html.php';
                        $emailHTML = ob_get_clean();

                        ob_start();
                        include IPHORM_INCLUDES_DIR . '/emails/email-plain.php';
                        $emailPlain = ob_get_clean();
                    }

                    if (strlen($emailHTML)) {
                        $mailer->MsgHTML($emailHTML);
                        if (strlen($emailPlain)) {
                            $mailer->AltBody = $emailPlain;
                        }
                    } else {
                       $mailer->Body = $emailPlain;
                    }

                    // Attachments
                    foreach ($attachments as $file) {
                        $mailer->AddAttachment($file['fullPath'], $file['filename'], 'base64', $file['type']);
                    }

                    $mailer = apply_filters('iphorm_pre_send_notification_email', $mailer, $form, $attachments);
                    $mailer = apply_filters('iphorm_pre_send_notification_email_' . $form->getId(), $mailer, $form, $attachments);

                    // Send the message
                    $mailer->Send();
                }

                // Check if we should send the autoreply email
                if ($form->getSendAutoreply()
                && ($recipientElement = $form->getAutoreplyRecipientElement()) instanceof iPhorm_Element_Email
                && strlen($recipientEmailAddress = $recipientElement->getValue())
                && $emailValidator->isValid($recipientEmailAddress)) {
                    // Get a new PHP mailer instance
                    $mailer = iphorm_new_phpmailer($form);

                    // Set the subject
                    $mailer->Subject = $form->replacePlaceholderValues($form->getAutoreplySubject());

                    // Set the from name/email
                    $autoreplyFromInfo = $form->getAutoreplyFromInfo();
                    $mailer->From = $autoreplyFromInfo['email'];
                    $mailer->FromName = $autoreplyFromInfo['name'];

                    // Add the recipient address
                    $mailer->AddAddress($recipientEmailAddress);

                    // Build the email content
                    $emailHTML = '';
                    $emailPlain = '';
                    if (strlen($autoreplyEmailContent = $form->getAutoreplyEmailContent())) {
                        if ($form->getAutoreplyFormat() == 'html') {
                            $emailHTML = $form->replacePlaceholderValues($autoreplyEmailContent);
                        } else {
                            $emailPlain = $form->replacePlaceholderValues($autoreplyEmailContent);
                        }
                    }

                    if (strlen($emailHTML)) {
                        $mailer->MsgHTML($emailHTML);
                    } else {
                        $mailer->Body = $emailPlain;
                    }

                    $mailer = apply_filters('iphorm_pre_send_autoreply_email', $mailer, $form, $attachments);
                    $mailer = apply_filters('iphorm_pre_send_autoreply_email_' . $form->getId(), $mailer, $form, $attachments);

                    try {
                        // Send the autoreply
                        $mailer->Send();
                    } catch (Exception $e) {
                        // Catching exceptions so failure of sending the autoreply doesn't generate
                        // an error for the form user
                    }
                }
            }

            // Save the entry to the database
            if ($form->getSaveToDatabase()) {
                global $wpdb;

                $currentUser = wp_get_current_user();

                $entry = array(
                    'form_id' => $form->getId(),
                    'date_added' => gmdate('Y-m-d H:i:s'),
                    'ip' => iphorm_get_user_ip(),
                    'form_url' => isset($_POST['form_url']) ? $_POST['form_url'] : '',
                    'referring_url' => isset($_POST['referring_url']) ? $_POST['referring_url'] : '',
                    'post_id' => isset($_POST['post_id']) ? $_POST['post_id'] : '',
                    'post_title' => isset($_POST['post_title']) ? $_POST['post_title'] : '',
                    'user_display_name' => iphorm_get_current_userinfo('display_name'),
                    'user_email' => iphorm_get_current_userinfo('user_email'),
                    'user_login' => iphorm_get_current_userinfo('user_login')
                );

                $wpdb->insert(iphorm_get_form_entries_table_name(), $entry);
                $entryId = $wpdb->insert_id;

                foreach ($elements as $element) {
                    if ($element->getSaveToDatabase()) {
                        $entryData = array(
                            'entry_id' => $entryId,
                            'element_id' => $element->getId(),
                            'value' => $element->getValueHtml()
                        );
                        $wpdb->insert(iphorm_get_form_entry_data_table_name(), $entryData);
                    }
                }

            }

            // Send the entry to Podio
            if ($form->getSendToPodio()) {
                try {
                    $podio_client_id = get_option('iphorm_podio_client_id');
                    $podio_client_secret = get_option('iphorm_podio_client_secret');

                    $podio_app_id = $form->getPodioAppId();
                    $podio_app_token = $form->getPodioAppToken();

                    Podio::setup($podio_client_id, $podio_client_secret, array());

                    if (!Podio::is_authenticated()) {
                        Podio::authenticate('app', array('app_id' => $podio_app_id, 'app_token' => $podio_app_token));
                    }

                    $podio_fields = array();
                    foreach ($elements as $element) {
                        if ($element->getPodioId() && strlen($element->getValue()) > 0) {
                            $podio_fields[$element->getPodioId()] = (string)(int)$element->getValue() == $element->getValue() ? intval($element->getValue()) : $element->getValue();
                        }
                    }

                    PodioItem::create($podio_app_id, array('fields' => $podio_fields));
                } catch (Exception $e) {}
            }

            // Alert with Twilio
            if ($form->getAlertWithTwilio()) {
                try {
                    $twilio_sid = get_option('iphorm_twilio_sid');
                    $twilio_token = get_option('iphorm_twilio_token');
                    $twilio_number = get_option('iphorm_twilio_number');

                    $twilio_alert_number = $form->getTwilioAlertNumber();
                    $twilio_alert_msg = $form->getTwilioAlertMsg();

                    if ($twilio_sid && $twilio_token) {
                        $twilio = new Services_Twilio($twilio_sid, $twilio_token);

                        if ( $twilio ) {
                            $twiml = urlencode("<Response><Say>" . $twilio_alert_msg . "</Say></Response>");
                            $response = "http://twimlets.com/echo?Twiml=" . $twiml;
                            return $twilio->account->calls->create($twilio_number, $twilio_alert_number, $response);
                        }
                    }
                } catch (Exception $e) {}
            }

            // Okay, so now we can save form data to the custom database table if configured
            if (count($fields = $form->getDbFields())) {
                if ($form->getUseWpDb()) {
                    global $wpdb;
                } else {
                    $wpdb = new wpdb($form->getDbUsername(), $form->getDbPassword(), $form->getDbName(), $form->getDbHost());
                }

                foreach ($fields as $key => $value) {
                    $fields[$key] = $form->replacePlaceholderValues($value);
                }

                $wpdb->insert($form->getDbTable(), $fields);
            }

            // Delete uploaded files and unset file upload info from session
            if (isset($_SESSION['iphorm-' . $form->getUniqId()])) {
                if (is_array($_SESSION['iphorm-' . $form->getUniqId()])) {
                    foreach ($_SESSION['iphorm-' . $form->getUniqId()] as $file) {
                        if (isset($file['tmp_name'])) {
                            if (is_array($file['tmp_name'])) {
                                foreach ($file['tmp_name'] as $multiFile) {
                                    if (is_string($multiFile) && strlen($multiFile) && file_exists($multiFile)) {
                                        unlink($multiFile);
                                    }
                                }
                            } else if (is_string($file['tmp_name']) && strlen($file['tmp_name']) && file_exists($file['tmp_name'])) {
                                unlink($file['tmp_name']);
                            }
                        }
                    }
                }
                unset($_SESSION['iphorm-' . $form->getUniqId()]);
            }

            // Unset CAPTCHA info from session
            if (isset($_SESSION['iphorm-captcha-' . $form->getUniqId()])) {
                unset($_SESSION['iphorm-captcha-' . $form->getUniqId()]);
            }

            // Post-process action hooks
            do_action('iphorm_post_process', $form);
            do_action('iphorm_post_process_' . $form->getId(), $form);

            if (!$ajax) {
                // Reset the form for non-JavaScript submit
                $successMessage = $form->getSuccessMessage();
                $form->setSubmitted(true);
                $form->reset();
            }

            $result = array('type' => 'success', 'data' => $form->getSuccessMessage());
        } else {
            $result = array('type' => 'error', 'data' => $form->getErrors());
        }

        if ($ajax) {
            $response = '<textarea>' . iphorm_json_encode($result) . '</textarea>';
        } else {
            // Redirect if successful
            if (isset($result['type']) && $result['type'] == 'success' && strlen(($redirectURL = $form->getSuccessRedirectURL())) && !headers_sent()) {
                header('Location: ' . $redirectURL);
            }

            // Displays the form again
            ob_start();
            include IPHORM_INCLUDES_DIR . '/form.php';
            $response = ob_get_clean();
        }
        return $response;
    }
}

/**
 * Get a new PHPMailer instance
 *
 * @param iPhorm $form
 * @return PHPMailer
 */
function iphorm_new_phpmailer(iPhorm $form)
{
    // Create the mailer and set the charset to match the blog charset
    $mailer = new PHPMailer(true);
    $mailer->CharSet = get_bloginfo('charset');

    // Set up SMTP settings if required
    if ($form->getEmailSendingMethod() == 'global' && get_option('iphorm_email_sending_method') == 'smtp') {
        $smtpSettings = get_option('iphorm_smtp_settings');
        $mailer->IsSMTP();

        if (isset($smtpSettings['host']) && strlen($smtpSettings['host'])) {
            $mailer->Host = $smtpSettings['host'];
        }

        if (isset($smtpSettings['port'])) {
            $mailer->Port = absint($smtpSettings['port']);
        }

        if (isset($smtpSettings['username']) && strlen($smtpSettings['username'])) {
            $mailer->SMTPAuth = true;
            $mailer->Username = $smtpSettings['username'];
        }

        if (isset($smtpSettings['password']) && strlen($smtpSettings['password'])) {
            $mailer->Password = $smtpSettings['password'];
        }

        if (isset($smtpSettings['encryption']) && in_array($smtpSettings['encryption'], array('tls', 'ssl'))) {
            $mailer->SMTPSecure = $smtpSettings['encryption'];
        }
    } else if ($form->getEmailSendingMethod() == 'smtp') {
        $mailer->IsSMTP();

        if (strlen($form->getSmtpHost())) {
            $mailer->Host = $form->getSmtpHost();
        }

        if (absint($form->getSmtpPort())) {
            $mailer->Port = $form->getSmtpPort();
        }

        if (strlen($form->getSmtpUsername())) {
            $mailer->SMTPAuth = true;
            $mailer->Username = $form->getSmtpUsername();
        }

        if (strlen($form->getSmtpPassword())) {
            $mailer->Password = $form->getSmtpPassword();
        }

        if (in_array($form->getSmtpEncryption(), array('tls', 'ssl'))) {
            $mailer->SMTPSecure = $form->getSmtpEncryption();
        }
    }

    return $mailer;
}

/**
 * Save the uploaded file
 *
 * @param string $currentPath The path to the uploaded file
 * @param string $filename Desired filename
 * @param iPhorm_Element_File $element The iPhorm file element
 * @param int $formId  The ID of the form
 */
function iphorm_save_uploaded_file($currentPath, $filename, iPhorm_Element_File $element, $formId)
{
    if (($wpUploadsDir = iphorm_get_wp_uploads_dir()) !== false) {
        // Get the save path
        $path = $element->getSavePath() == '' ? 'iphorm/{form_id}/{year}/{month}/' : $element->getSavePath();

        // Replace placeholders
        $path = str_replace(array('{form_id}', '{year}', '{month}', '{day}'), array($formId, date('Y'), date('m'), date('d')), $path);

        // Apply any filter hooks to the path
        $path = apply_filters('iphorm_upload_path', $path, $element);
        $path = apply_filters("iphorm_upload_path_$formId", $path, $element);

        // Join the path with the WP uploads directory
        $absolutePath = rtrim($wpUploadsDir, '/') . '/' . ltrim($path, '/');

        // Apply filters to the absolute path
        $absolutePath = apply_filters('iphorm_upload_absolute_path', $absolutePath, $element);
        $absolutePath = apply_filters("iphorm_upload_absolute_path_$formId", $absolutePath, $element);

        // Add a trailing slash
        $absolutePath = trailingslashit($absolutePath);

        // Make the upload directory if it's not set
        if (!is_dir($absolutePath)) {
            wp_mkdir_p($absolutePath);
        }

        // Check if the file name already exists, if so generate a new one
        if (file_exists($absolutePath . $filename)) {
            $count = 1;
            $newFilenamePath = $absolutePath . $filename;

            while (file_exists($newFilenamePath)) {
                $newFilename = $count++ . '_' . $filename;
                $newFilenamePath = $absolutePath . $newFilename;
            }

            $filename = $newFilename;
        }

        // Move the file
        if (rename($currentPath, $absolutePath . $filename) !== false) {
            chmod($absolutePath . $filename, 0644);

            return array(
                'path' => $path,
                'fullPath' => $absolutePath . $filename,
                'filename' => $filename
            );
        } else {
            return false;
        }
    } else {
        // Uploads dir is not writable
        return false;
    }
}

add_action('wp_loaded', 'iphorm_process_swfupload');

/**
 * Hook for processing uploads via SWFUpload
 *
 * Process the upload and print the response
 */
function iphorm_process_swfupload()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['iphorm_swfupload']) && $_GET['iphorm_swfupload'] == 1) {
        if (isset($_POST['iphorm_id'], $_POST['iphorm_form_uniq_id'], $_POST['iphorm_element_id'], $_POST['iphorm_element_name'], $_POST['PHPSESSID'])) {
            $form = iphorm_get_form($_POST['iphorm_id'], $_POST['iphorm_form_uniq_id']);
            $filesKey = $_POST['iphorm_element_name'];

            if ($form instanceof iPhorm && isset($_FILES[$filesKey]) && is_uploaded_file($_FILES[$filesKey]['tmp_name']) && $_FILES[$filesKey]['error'] == UPLOAD_ERR_OK) {
                $element = $form->getElementById($_POST['iphorm_element_id']);

                if ($element instanceof iPhorm_Element_File) {
                    $tmpDir = untrailingslashit(iphorm_get_temp_dir());

                    if (is_writable($tmpDir)) {
                        $iphormTmpDir = $tmpDir . '/iphorm';
                        if (!is_dir($iphormTmpDir)) {
                            wp_mkdir_p($iphormTmpDir);
                        }

                        if (is_writable($iphormTmpDir)) {
                            if ($element->isValid('')) {
                                $filename = tempnam($iphormTmpDir, 'iphorm');
                                move_uploaded_file($_FILES[$filesKey]['tmp_name'], $filename);
                                $_FILES[$filesKey]['tmp_name'] = $filename;

                                $sessionKey = 'iphorm-' . $_POST['iphorm_form_uniq_id'];

                                if (!isset($_SESSION[$sessionKey])) {
                                    $_SESSION[$sessionKey] = array();
                                }

                                if ($element->getIsMultiple()) {
                                    $keys = array('name', 'type', 'tmp_name', 'error', 'size');
                                    foreach ($keys as $key) {
                                        if (isset($_SESSION[$sessionKey][$filesKey][$key]) && is_array($_SESSION[$sessionKey][$filesKey][$key])) {
                                            $_SESSION[$sessionKey][$filesKey][$key][] = $_FILES[$filesKey][$key];
                                        } else {
                                            $_SESSION[$sessionKey][$filesKey][$key] = array(
                                                0 => $_FILES[$filesKey][$key]
                                            );
                                        }
                                    }
                                } else {
                                    $_SESSION[$sessionKey][$filesKey] = $_FILES[$filesKey];
                                }
                            } else {
                                $response = array(
                                    'type' => 'error',
                                    'data' => $element->getErrors()
                                );

                                echo iphorm_json_encode($response);
                            }
                        }
                    }
                }
            }
        }
        exit;
    }
}


/**
 * Has the file been uploaded via PHP or SWFUpload?
 *
 * @param string $filename The path to the file
 */
function iphorm_is_uploaded_file($filename)
{
    if (is_uploaded_file($filename)) {
        return true;
    } else {
        $filename = realpath($filename);

        if (preg_match('#[/|\\\]iphorm[/|\\\]iph#', $filename)) {
            return true;
        }
    }

    return false;
}

add_action('iphorm_upload_cleanup', 'iphorm_do_upload_cleanup');

/**
 * Deletes any files uploaded via SWFUpload that were temporarily
 * stored in the system temp directory but were never used.
 */
function iphorm_do_upload_cleanup()
{
    $iphormTmpDir = untrailingslashit(iphorm_get_temp_dir()) . '/iphorm/';

    if (is_dir($iphormTmpDir) && $handle = opendir($iphormTmpDir)) {
        clearstatcache();
        $keepUntil = time() - (60 * 60); // Delete anything older than one hour
        while (false !== ($file = readdir($handle))) {
            $mtime = filemtime($iphormTmpDir . $file);
            if ($file != '.' && $file != '..' && $mtime < $keepUntil) {
                @unlink($iphormTmpDir . $file);
            }
        }

        closedir($handle);
    }
}

/**
 * Get the IP address of the visitor
 *
 * @return string
 */
function iphorm_get_user_ip()
{
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return $ip;
}

/**
 * Get the current URL
 *
 * @return string
 */
function iphorm_get_current_url()
{
    $url = 'http';
    if (is_ssl()) {
        $url .= 's';
    }
    $url .= '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    return $url;
}

/**
 * Get the HTTP referer
 *
 * @return string
 */
function iphorm_get_http_referer()
{
    if (isset($_SERVER['HTTP_REFERER'])) {
        return $_SERVER['HTTP_REFERER'];
    }
}

/**
 * Get the current Post ID
 *
 * @return int
 */
function iphorm_get_current_post_id()
{
    global $wp_query;

    if ($wp_query instanceof WP_Query) {
        if (isset($wp_query->post) && isset($wp_query->post->ID)) {
            return $wp_query->post->ID;
        }
    }
}

/**
 * Get the current Post title
 *
 * @return string
 */
function iphorm_get_current_post_title()
{
    global $wp_query;
    if ($wp_query instanceof WP_Query) {
        if (isset($wp_query->post) && isset($wp_query->post->post_title)) {
            return $wp_query->post->post_title;
        }
    }
}

/**
 * Get information on the current user
 *
 * @param string $which Which property to get
 * @return mixed
 */
function iphorm_get_current_userinfo($which)
{
    $currentUser = wp_get_current_user();
    if ($currentUser->ID != 0 && strlen($which) && isset($currentUser->{$which})) {
        return $currentUser->{$which};
    }
}

/**
 * Display/process the given form
 *
 * @param int|iPhorm $form
 * @param string|array $values
 */
function iphorm($form, $values = '')
{
    if (is_string($values)) {
        $values = join('&', explode('&amp;', $values));
    }

    $id = $form instanceof iPhorm ? $form->getId() : absint($form);
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['iphorm_id']) && $_POST['iphorm_id'] == $id) {
        return iphorm_process_form();
    }

    if (($form instanceof iPhorm || ($form = iphorm_get_form(absint($form), null, $values)) instanceof iPhorm) && $form->getActive()) {
        do_action('iphorm_pre_display', $form);
        do_action('iphorm_pre_display_' . $form->getId(), $form);
        return iphorm_display_form($form);
    }
}

add_shortcode('iphorm', 'iphorm_shortcode');

/**
 * Process the iPhorm shortcode
 *
 * @param array $atts
 */
function iphorm_shortcode($atts)
{
    extract(shortcode_atts(array(
        'id' => 0,
        'values' => ''
    ), $atts ));

    if (iphorm_needs_raw_tag()) {
        return '[raw]' . iphorm($id, $values) . '[/raw]';
    }

    return iphorm($id, $values);
}

add_shortcode('iphorm_popup', 'iphorm_popup_shortcode');

/**
 * Process the iPhorm popup shortcode
 *
 * @param array $atts
 * @param string $content Trigger content/HTML
 */
function iphorm_popup_shortcode($atts, $content = null)
{
    extract(shortcode_atts(array(
        'id' => 0,
        'options' => '',
        'values' => ''
    ), $atts ));

    if (iphorm_needs_raw_tag()) {
        return '[raw]' . iphorm_popup($id, $content, $options, $values) . '[/raw]';
    }

    return iphorm_popup($id, $content, $options, $values);
}

/**
 * Displays the trigger code to display a form in Fancybox
 *
 * @param iPhorm|int $form The form object or form ID
 * @param string $content The trigger content/HTML
 * @param string $options Fancybox options as a JSON string
 * @param string|array $values Dynamic default values in key/value URL format or array
 */
function iphorm_popup($form, $content = '', $options = '', $values = '')
{
    if (is_string($values)) {
        $values = join('&', explode('&amp;', $values));
    }

    if (($form instanceof iPhorm || ($form = iphorm_get_form(absint($form), null, $values)) instanceof iPhorm) && $form->getActive()) {
        $form = apply_filters('iphorm_pre_display_popup', apply_filters('iphorm_pre_display_popup_' . $form->getId(), $form));
        if (!strlen($options)) $options = '{}';
        $options = apply_filters('iphorm_pre_display_popup_options', apply_filters('iphorm_pre_display_popup_options_' . $form->getId(), $options));
        $linkId = 'iphorm_fancybox_' . uniqid();

        ob_start();
        ?>
<a id="<?php echo esc_attr($linkId); ?>" class="iphorm-fancybox-link" href="#"><?php echo do_shortcode($content); ?></a>
<script type="text/javascript">
<!--
    jQuery(document).ready(function ($) {
        var $link = $('#<?php echo esc_js($linkId); ?>');
        if ($.isFunction($.fn.fancybox) && !$link.data('iphorm-initialised')) {
            $link.fancybox($.extend({
                inline: true,
                href: '#iphorm-outer-<?php echo $form->getUniqId(); ?>',
                onStart: function () {
                    $('#fancybox-outer').css('opacity', 0);
                },
                onComplete: function () {
                    $('#fancybox-wrap, #fancybox-content').css({width: 'auto'});
                    $.fancybox.center(0);
                    setTimeout(function () {
                        $('#fancybox-outer').animate({opacity: 1}, <?php echo apply_filters('iphorm_fancybox_animate_speed_' . $form->getId(), apply_filters('iphorm_fancybox_animate_speed', 400)); ?>);
                        $('#fancybox-overlay').css({height: $(document).height()});
                    }, 1);
                }
            }, <?php echo $options; ?>)).data('iphorm-initialised', true);
        }
    });
//-->
</script>
<div style="display: none;">
<?php echo iphorm_display_form($form); ?>
</div>
        <?php
        return ob_get_clean();
    }
}

add_action('wp_enqueue_scripts', 'iphorm_enqueue_styles');

/**
 * Enqueue the frontend styles
 */
function iphorm_enqueue_styles()
{
    wp_enqueue_style('iphorm', IPHORM_PLUGIN_URL . '/css/styles.css', array(), IPHORM_VERSION);

    if (!get_option('iphorm_disable_qtip_output')) {
        wp_enqueue_style('qtip', IPHORM_PLUGIN_URL . '/js/qtip2/jquery.qtip.css', array(), 'nightly');
    }

    if (get_option('iphorm_fancybox_requested') && !get_option('iphorm_disable_fancybox_output')) {
        wp_enqueue_style('iphorm-fancybox', IPHORM_PLUGIN_URL . '/js/fancybox/jquery.fancybox-1.3.4.css', array(), '1.3.4');
    }

    if (!get_option('iphorm_disable_uniform_ouput')) {
        // Check which uniform themes are active and enqueue them
        $activeUniformThemes = maybe_unserialize(get_option('iphorm_active_uniform_themes'));
        $activeUniformThemes = is_array($activeUniformThemes) ? array_unique($activeUniformThemes) : array();
        foreach ($activeUniformThemes as $key => $activeUniformTheme) {
            wp_enqueue_style('iphorm-uniform-theme-' . $key, IPHORM_PLUGIN_URL . "/js/uniform/themes/$activeUniformTheme/$activeUniformTheme.css", array(), IPHORM_VERSION);
        }
    }

    // Check which themes are active and enqueue them
    $activeThemes = maybe_unserialize(get_option('iphorm_active_themes'));
    $activeThemes = is_array($activeThemes) ? array_unique($activeThemes) : array();
    foreach ($activeThemes as $key => $activeTheme) {
        $themeInfo = explode('|', $activeTheme);
        wp_enqueue_style('iphorm-theme-' . $key, IPHORM_PLUGIN_URL . "/themes/" . $themeInfo[0] . "/" . $themeInfo[1] . ".css", array(), IPHORM_VERSION);
    }

    // Enqueue user custom stylesheet
    if (file_exists(IPHORM_PLUGIN_DIR . '/css/custom.css')) {
        wp_enqueue_style('iphorm-custom', IPHORM_PLUGIN_URL . '/css/custom.css');
    }
}

add_action('wp_enqueue_scripts', 'iphorm_enqueue_scripts');

/**
 * Enqueue the frontend scripts
 */
function iphorm_enqueue_scripts()
{
    wp_enqueue_script('iphorm', IPHORM_PLUGIN_URL . '/js/iphorm.js', array(), IPHORM_VERSION, false);
    wp_enqueue_script('iphorm-plugin', IPHORM_PLUGIN_URL . '/js/jquery.iphorm.js', array('jquery', 'swfupload-all'), IPHORM_VERSION, true);
    if (version_compare(get_bloginfo('version'), '3.2') >= 0) {
        wp_enqueue_script('jquery-form');
    } else {
        wp_deregister_script('jquery-form');
        wp_enqueue_script('jquery-form', IPHORM_PLUGIN_URL . '/js/jquery.form.js', array('jquery'), '2.7.3', true);
    }

    if (!get_option('iphorm_disable_smoothscroll_output')) {
        wp_enqueue_script('jquery-smooth-scroll', IPHORM_PLUGIN_URL . '/js/jquery.smooth-scroll.min.js', array('jquery'), '1.4', true);
    }

    if (!get_option('iphorm_disable_qtip_output')) {
        wp_enqueue_script('qtip', IPHORM_PLUGIN_URL . '/js/qtip2/jquery.qtip.min.js', array(), 'nightly', true);
    }

    if (get_option('iphorm_fancybox_requested') && !get_option('iphorm_disable_fancybox_output')) {
        wp_enqueue_script('iphorm-fancybox', IPHORM_PLUGIN_URL . '/js/fancybox/jquery.fancybox-1.3.4.pack.js', array('jquery'), '1.3.4', true);
    }

    $activeUniformThemes = maybe_unserialize(get_option('iphorm_active_uniform_themes'));
    if (!get_option('iphorm_disable_uniform_ouput') && (is_array($activeUniformThemes) && count($activeUniformThemes))) {
        wp_enqueue_script('uniform', IPHORM_PLUGIN_URL . '/js/uniform/jquery.uniform.js', array('jquery'), '1.7.5', true);
    }

    if (!get_option('iphorm_disable_infieldlabels_output')) {
        wp_enqueue_script('infield-label', IPHORM_PLUGIN_URL . '/js/jquery.infieldlabel.min.js', array('jquery'), '0.1', true);
    }

    $activeDatepickers = maybe_unserialize(get_option('iphorm_active_datepickers'));
    if (!get_option('iphorm_disable_jqueryui_output') && (is_array($activeDatepickers) && count($activeDatepickers))) {
        wp_enqueue_script('iphorm-jquery-ui-core', IPHORM_PLUGIN_URL . '/js/jqueryui/jquery.ui.core.min.js', array('jquery'), '1.8.16', true);
        wp_enqueue_script('iphorm-jquery-ui-datepicker', IPHORM_PLUGIN_URL . '/js/jqueryui/jquery.ui.datepicker.min.js', array('jquery', 'iphorm-jquery-ui-core'), '1.8.16', true);
    }

    $activeThemes = maybe_unserialize(get_option('iphorm_active_themes'));
    $activeThemes = is_array($activeThemes) ? array_unique($activeThemes) : array();
    foreach ($activeThemes as $key => $activeTheme) {
        $themeInfo = explode('|', $activeTheme);
        if (file_exists(IPHORM_PLUGIN_DIR . "/themes/" . $themeInfo[0] . "/" . $themeInfo[1] . ".js")) {
            wp_enqueue_script('iphorm-theme-' . $key, IPHORM_PLUGIN_URL . "/themes/" . $themeInfo[0] . "/" . $themeInfo[1] . ".js", array(), IPHORM_VERSION, true);
        }
    }

    wp_localize_script('iphorm-plugin', 'iphormL10n', iphorm_js_l10n());
}

add_action('wp_ajax_nopriv_iphorm_show_form_ajax', 'iphorm_show_form_ajax');
add_action('wp_ajax_iphorm_show_form_ajax', 'iphorm_show_form_ajax');

/**
 * Displays the form via an Ajax call, for Lightboxes etc.
 *
 * @deprecated 1.3 Use iphorm_display_form_ajax()
 */
function iphorm_show_form_ajax()
{
    $id = isset($_REQUEST['id']) ? absint($_REQUEST['id']) : 0;
    $_GET['iphorm_display_form_ajax'] = $id;
    iphorm_display_form_ajax();
}

add_action('wp_loaded', 'iphorm_display_form_ajax');

/**
 * Show only the form HTML, for Lightboxes etc.
 */
function iphorm_display_form_ajax()
{
    if (isset($_GET['iphorm_display_form_ajax'])) {
        $id = absint($_GET['iphorm_display_form_ajax']);
        if (iphorm_form_exists($id)) {
            $form = iphorm_get_form($id);
            $xhtml = iphorm_display_form($form);

            header('Content-Type: text/html');
            echo $xhtml;
            exit;
        }
    }
}

/**
 * Log arguments to the PHP error log
 */
function iphorm_error_log()
{
    foreach (func_get_args() as $arg) {
        ob_start();
        var_dump($arg);
        error_log(ob_get_clean());
    }
}

/**
 * Get the list of IDs of all elements in the given group
 *
 * @param iPhorm $form
 * @param iPhorm_Element_Groupstart $group
 * @return array
 */
function iphorm_get_group_element_ids($form, $group) {
    $groupElementIds = array();
    $startCapture = false;
    $depth = 0;
    $elements = $form->getElements();

    foreach ($elements as $element) {
        if ($element instanceof iPhorm_Element_Groupstart) {
            if ($element->getId() == $group->getId()) {
                // We've found ths group, so start capturing element IDs
                $startCapture = true;
                $depth++;
                continue;
            } else {
                if ($startCapture) {
                    // This is another group inside it, so increment depth
                    $depth++;
                }
            }
        } elseif ($element instanceof iPhorm_Element_Groupend) {
            // This is a group end element so decrement depth
            if ($startCapture) {
                if (--$depth == 0) {
                    // This is the group end for our target group so we're done
                    break;
                }
            }
        } else {
            if ($startCapture) {
                $groupElementIds[] = $element->getId();
            }
        }
    }

    return $groupElementIds;
}

/**
 * Get a writable temporary directory
 *
 * This is a duplicate of the WP function get_temp_dir() because there was an issue with one
 * popular plugin manually firing the wp_ajax_* hooks before WordPress does,
 * causing this plugin to fatal error since this function was not available
 * at that time. So we'll just use the function below in all cases instead of the
 * WP function.
 *
 * @return string
 */
function iphorm_get_temp_dir()
{
    if (function_exists('get_temp_dir')) {
        return get_temp_dir();
    } else {
        static $temp;
        if ( defined('WP_TEMP_DIR') )
            return trailingslashit(WP_TEMP_DIR);

        if ( $temp )
            return trailingslashit($temp);

        $temp = WP_CONTENT_DIR . '/';
        if ( is_dir($temp) && @is_writable($temp) )
            return $temp;

        if  ( function_exists('sys_get_temp_dir') ) {
            $temp = sys_get_temp_dir();
            if ( @is_writable($temp) )
                return trailingslashit($temp);
        }

        $temp = ini_get('upload_tmp_dir');
        if ( is_dir($temp) && @is_writable($temp) )
            return trailingslashit($temp);

        $temp = '/tmp/';
        return $temp;
    }
}

add_action('wp_loaded', 'iphorm_detect_raw_tag');

/**
 * Does the theme have a [raw] tag function?
 */
function iphorm_detect_raw_tag()
{
    define('IPHORM_RAW_TAG', trim(apply_filters('the_content', '[raw]a[/raw]')) == 'a');
}

/**
 * Checks if the the form shortcode should be wrapped in [raw] tags, specifically checks all of
 * the following are true:
 *
 * 1. The [raw] tag content filter is available in the current theme
 * 2. We are currently in the 'the_content' filter
 * 3. The form shortcode isn't already wrapped in [raw] tags
 *
 * @return boolean
 */
function iphorm_needs_raw_tag()
{
    global $post, $wp_current_filter;

    $result = defined('IPHORM_RAW_TAG')
              && IPHORM_RAW_TAG
              && isset($wp_current_filter[0], $post->post_content)
              && $wp_current_filter[0] == 'the_content'
              && !preg_match('/\[raw\].*?\[iphorm.*?\[\/raw\]/', $post->post_content);

    return apply_filters('iphorm_needs_raw_tag', $result);
}

// Include the admin functions if we're in the WordPress admin
if (is_admin()) {
    require_once IPHORM_ADMIN_DIR . '/admin.php';
}