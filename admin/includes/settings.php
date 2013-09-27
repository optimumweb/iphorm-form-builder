<?php if (!defined('IPHORM_VERSION')) exit; ?><div class="wrap">
	<div class="iphorm-top-right">
        <div class="iphorm-information">
        	<span class="iphorm-copyright"><a href="http://www.themecatcher.net" onclick="window.open(this.href); return false;">www.themecatcher.net</a> &copy; <?php echo date('Y'); ?></span>
        	<span class="iphorm-bug-link"><a href="http://www.themecatcher.net/support.php" onclick="window.open(this.href); return false;"><?php esc_html_e('Report a bug', 'iphorm'); ?></a></span>
        	<span class="iphorm-help-link"><a href="<?php echo iphorm_help_link(); ?>" onclick="window.open(this.href); return false;"><?php esc_html_e('Help', 'iphorm'); ?></a></span>
        </div>
    </div>
    <?php screen_icon('iphorm'); ?>
    <h2 class="ifb-main-title"><span class="ifb-iphorm-title">Quform</span><?php esc_html_e('Settings', 'iphorm'); ?></h2>

    <?php iphorm_global_nav('settings'); ?>

    <?php if (isset($_POST['iphorm_settings'])) : ?>
        <?php
            update_option('iphorm_recaptcha_public_key', sanitize_text_field(stripslashes($_POST['recaptcha_public_key'])));
            update_option('iphorm_recaptcha_private_key', sanitize_text_field(stripslashes($_POST['recaptcha_private_key'])));
            update_option('iphorm_email_sending_method', $_POST['global_email_sending_method']);
            update_option('iphorm_smtp_settings', array(
                'host' => sanitize_text_field(stripslashes($_POST['smtp_host'])),
                'port' => sanitize_text_field(stripslashes($_POST['smtp_port'])),
                'encryption' => $_POST['smtp_encryption'],
                'username' => sanitize_text_field(stripslashes($_POST['smtp_username'])),
                'password' => sanitize_text_field(stripslashes($_POST['smtp_password']))
            ));
            update_option('iphorm_podio_client_id', sanitize_text_field(stripslashes($_POST['podio_client_id'])));
            update_option('iphorm_podio_client_secret', sanitize_text_field(stripslashes($_POST['podio_client_secret'])));
            update_option('iphorm_twilio_sid', sanitize_text_field(stripslashes($_POST['twilio_sid'])));
            update_option('iphorm_twilio_token', sanitize_text_field(stripslashes($_POST['twilio_token'])));
            update_option('iphorm_disable_fancybox_output', isset($_POST['disable_fancybox_output']) && $_POST['disable_fancybox_output'] == 1);
            update_option('iphorm_disable_qtip_output', isset($_POST['disable_qtip_output']) && $_POST['disable_qtip_output'] == 1);
            update_option('iphorm_disable_infieldlabels_output', isset($_POST['disable_infieldlabels_output']) && $_POST['disable_infieldlabels_output'] == 1);
            update_option('iphorm_disable_smoothscroll_output', isset($_POST['disable_smoothscroll_output']) && $_POST['disable_smoothscroll_output'] == 1);
            update_option('iphorm_disable_jqueryui_output', isset($_POST['disable_jqueryui_output']) && $_POST['disable_jqueryui_output'] == 1);
            update_option('iphorm_fancybox_requested', isset($_POST['fancybox_requested']) && $_POST['fancybox_requested'] == 1);

            if (isset($_POST['iphorm_update']) && $_POST['iphorm_update'] == '1') {
                iphorm_update_active_themes();
            }
        ?>
        <div class="updated below-h2" id="message">
            <p><?php esc_html_e('Settings saved.', 'iphorm'); ?></p>
        </div>
    <?php endif; ?>
    <form method="post" action="">
        <h3 class="ifb-sub-head"><span><?php esc_html_e('Product license', 'iphorm'); ?></span></h3>
        <p><?php printf(esc_html__('A valid license key entitles you to support and enables automatic upgrades. %3$sA
        license key may only be used for one installation of WordPress at a time%4$s, if you have previously verified a license key
        for another website, and use it again here, the Quform plugin will become unlicensed on the other website. Please enter your
        CodeCanyon Quform license key, you can find your key by following the instructions on %1$sthis page%2$s.', 'iphorm'), '<a onclick="window.open(this.href); return false;" href="http://www.themecatcher.net/iphorm-form-builder/license-key.php">', '</a>', '<span class="ifb-bold">', '</span>'); ?></p>
        <table class="form-table iphorm-purchase-settings">
            <tr>
                <th scope="row"><?php esc_html_e('License status', 'iphorm'); ?></th>
                <td>
                    <?php $valid = (strlen(get_option('iphorm_licence_key'))) ? true : false; ?>
                    <div class="iphorm-valid-licence-wrap <?php if (!$valid) echo 'ifb-hidden'; ?>"><span class="iphorm-valid-licence"><?php esc_html_e('Valid license key', 'iphorm'); ?></span></div>
                    <div class="iphorm-invalid-licence-wrap <?php if ($valid) echo 'ifb-hidden'; ?>"><span class="iphorm-invalid-licence"><?php esc_html_e('Unlicensed product', 'iphorm'); ?></span></div>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Enter license key', 'iphorm'); ?></th>
                <td><div class="iphorm-verify-purchase-code-wrap clearfix"><input id="purchase_code" type="text" name="purchase_code" class="iphorm-recaptcha-key-input" value="" /> <button class="button" id="verify-purchase-code"><?php esc_html_e('Verify', 'iphorm'); ?></button> <span class="iphorm-verify-loading"></span> </div></td>
            </tr>
        </table>
    </form>
    <form method="post" action="">
        <h3 class="ifb-sub-head"><span><?php esc_html_e('reCAPTCHA settings', 'iphorm'); ?></span></h3>
        <p><?php printf(esc_html__('In order to use the reCAPTCHA element in your form you must %ssign up%s
        for a free account to get your set of API keys. Once you have your public and private key, enter them below.', 'iphorm'),
        '<a href="https://www.google.com/recaptcha/admin/create?app=iphorm-form-builder" target="_blank">', '</a>'); ?></p>
        <table class="form-table iphorm-recaptcha-settings">
            <tr>
                <th scope="row"><?php esc_html_e('reCAPTCHA public key', 'iphorm'); ?></th>
                <td><input type="text" name="recaptcha_public_key" class="iphorm-recaptcha-key-input" value="<?php echo esc_attr(get_option('iphorm_recaptcha_public_key')); ?>" /></td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('reCAPTCHA private key', 'iphorm'); ?></th>
                <td><input type="text" name="recaptcha_private_key" class="iphorm-recaptcha-key-input" value="<?php echo esc_attr(get_option('iphorm_recaptcha_private_key')); ?>" /></td>
            </tr>
        </table>
        <h3 class="ifb-sub-head"><span><?php esc_html_e('Email sending settings', 'iphorm'); ?></span></h3>
        <p><?php esc_html_e('The settings here will determine the default email sending settings for all your forms
        you can also override these settings for each form at Form Builder &rarr; Settings &rarr; Email.', 'iphorm'); ?></p>
        <table class="form-table iphorm-email-settings">
            <?php
                $emailSendingMethod = get_option('iphorm_email_sending_method');
                $smtpSettings = get_option('iphorm_smtp_settings');
            ?>
            <tr valign="top">
                <th scope="row"><label for="global_email_sending_method"><?php esc_html_e('Email sending method', 'iphorm'); ?></label></th>
                <td>
                    <select id="global_email_sending_method" name="global_email_sending_method">
                        <option value="mail" <?php selected($emailSendingMethod, 'mail'); ?>><?php esc_html_e('PHP mail() (default)', 'iphorm'); ?></option>
                        <option value="smtp" <?php selected($emailSendingMethod, 'smtp'); ?>><?php esc_html_e('SMTP', 'iphorm'); ?></option>
                    </select>
                </td>
            </tr>
            <tr valign="top" class="<?php if ($emailSendingMethod !== 'smtp') echo 'ifb-hidden'; ?> iphorm-show-if-smtp-on">
                <th scope="row"><label for="smtp_host"><?php esc_html_e('SMTP host', 'iphorm'); ?></label></th>
                <td>
                    <input type="text" name="smtp_host" id="smtp_host" value="<?php echo esc_attr($smtpSettings['host']); ?>" />
                </td>
            </tr>
            <tr valign="top" class="<?php if ($emailSendingMethod !== 'smtp') echo 'ifb-hidden'; ?> iphorm-show-if-smtp-on">
                <th scope="row"><label for="smtp_port"><?php esc_html_e('SMTP port', 'iphorm'); ?></label></th>
                <td>
                    <input type="text" name="smtp_port" id="smtp_port" value="<?php echo esc_attr($smtpSettings['port']); ?>" />
                </td>
            </tr>
            <tr valign="top" class="<?php if ($emailSendingMethod !== 'smtp') echo 'ifb-hidden'; ?> iphorm-show-if-smtp-on">
                <th scope="row"><label for="smtp_encryption"><?php esc_html_e('SMTP encryption', 'iphorm'); ?></label></th>
                <td>
                    <select id="smtp_encryption" name="smtp_encryption">
                        <option value="" <?php selected($smtpSettings['encryption'], ''); ?>><?php esc_html_e('None', 'iphorm'); ?></option>
                        <option value="tls" <?php selected($smtpSettings['encryption'], 'tls'); ?>><?php esc_html_e('TLS', 'iphorm'); ?></option>
                        <option value="ssl" <?php selected($smtpSettings['encryption'], 'ssl'); ?>><?php esc_html_e('SSL', 'iphorm'); ?></option>
                    </select>
                </td>
            </tr>
            <tr valign="top" class="<?php if ($emailSendingMethod !== 'smtp') echo 'ifb-hidden'; ?> iphorm-show-if-smtp-on">
                <th scope="row"><label for="smtp_username"><?php esc_html_e('SMTP username', 'iphorm'); ?></label></th>
                <td>
                    <input type="text" name="smtp_username" id="smtp_username" value="<?php echo esc_attr($smtpSettings['username']); ?>" />
                </td>
            </tr>
            <tr valign="top" class="<?php if ($emailSendingMethod !== 'smtp') echo 'ifb-hidden'; ?> iphorm-show-if-smtp-on">
                <th scope="row"><label for="smtp_password"><?php esc_html_e('SMTP password', 'iphorm'); ?></label></th>
                <td>
                    <input type="text" name="smtp_password" id="smtp_password" value="<?php echo esc_attr($smtpSettings['password']); ?>" />
                </td>
            </tr>
        </table>
        <h3 class="ifb-sub-head"><span><?php esc_html_e('Podio settings', 'iphorm'); ?></span></h3>
        <p><?php esc_html_e('In order to send your form data to Podio, you must provide your Podio authentication information.', 'iphorm'); ?></p>
        <table class="form-table iphorm-podio-settings">
            <tr valign="top">
                <th scope="row"><label for="podio_client_id"><?php esc_html_e('Podio Client ID', 'iphorm'); ?></label></th>
                <td>
                    <input type="text" name="podio_client_id" id="podio_client_id" value="<?php echo esc_attr(get_option('iphorm_podio_client_id')); ?>" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="podio_client_secret"><?php esc_html_e('Podio Client Secret', 'iphorm'); ?></label></th>
                <td>
                    <input type="text" name="podio_client_secret" id="podio_client_secret" value="<?php echo esc_attr(get_option('iphorm_podio_client_secret')); ?>" />
                </td>
            </tr>
        </table>
        <h3 class="ifb-sub-head"><span><?php esc_html_e('Twilio settings', 'iphorm'); ?></span></h3>
        <p><?php esc_html_e('In order to use the Twilio API, you must provide your Twilio authentication information.', 'iphorm'); ?></p>
        <table class="form-table iphorm-twilio-settings">
            <tr valign="top">
                <th scope="row"><label for="twilio_sid"><?php esc_html_e('Twilio Account SID', 'iphorm'); ?></label></th>
                <td>
                    <input type="text" name="twilio_sid" id="twilio_sid" value="<?php echo esc_attr(get_option('iphorm_twilio_sid')); ?>" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="twilio_token"><?php esc_html_e('Twilio Auth Token', 'iphorm'); ?></label></th>
                <td>
                    <input type="text" name="twilio_token" id="twilio_token" value="<?php echo esc_attr(get_option('iphorm_twilio_token')); ?>" />
                </td>
            </tr>
        </table>
        <h3 class="ifb-sub-head"><span><?php esc_html_e('Update active themes cache', 'iphorm'); ?></span></h3>
        <p><?php esc_html_e('If you have added or removed a form from the database directly, e.g. via phpMyAdmin then you should tick
        the box below and Save Changes to make sure the correct themes are being loaded for all your active forms.', 'iphorm'); ?></p>
        <p><label class="ifb-bold"><input type="checkbox" value="1" name="iphorm_update" id="iphorm_update" /> <?php esc_html_e('Update active themes cache', 'iphorm'); ?></label></p>

        <h3 class="ifb-sub-head"><span><?php esc_html_e('Disable script output', 'iphorm'); ?></span></h3>
        <p><?php esc_html_e('You may be having conficts with some other plugins or themes using the same or conflicting
        JavaScript plugins. You can disable the output of the scripts used by the Quform plugin below by ticking the boxes below. This will
        disable both the CSS and JavaScript for the plugin.', 'iphorm'); ?></p>
        <p><label class="ifb-bold"><input type="checkbox" value="1" name="disable_fancybox_output" id="disable_fancybox_output" <?php checked(true, get_option('iphorm_disable_fancybox_output')); ?> /> <?php esc_html_e('Disable Fancybox output', 'iphorm'); ?></label></p>
        <p><label class="ifb-bold"><input type="checkbox" value="1" name="disable_qtip_output" id="disable_qtip_output" <?php checked(true, get_option('iphorm_disable_qtip_output')); ?> /> <?php esc_html_e('Disable qTip2 output', 'iphorm'); ?></label></p>
        <p><label class="ifb-bold"><input type="checkbox" value="1" name="disable_infieldlabels_output" id="disable_infieldlabels_output" <?php checked(true, get_option('iphorm_disable_infieldlabels_output')); ?> /> <?php esc_html_e('Disable Infield Labels output', 'iphorm'); ?></label></p>
        <p><label class="ifb-bold"><input type="checkbox" value="1" name="disable_smoothscroll_output" id="disable_smoothscroll_output" <?php checked(true, get_option('iphorm_disable_smoothscroll_output')); ?> /> <?php esc_html_e('Disable Smooth Scroll output', 'iphorm'); ?></label></p>
        <p><label class="ifb-bold"><input type="checkbox" value="1" name="disable_jqueryui_output" id="disable_jqueryui_output" <?php checked(true, get_option('iphorm_disable_jqueryui_output')); ?> /> <?php esc_html_e('Disable jQuery UI output', 'iphorm'); ?></label></p>

        <h3 class="ifb-sub-head"><span><?php esc_html_e('Enable lightbox script (Fancybox)', 'iphorm'); ?></span></h3>
        <p><?php esc_html_e('This option is enabled automatically when you add a form
        in a popup to a post / page or when you add a Quform Popup widget. If this does not happen for some reason
        you can tick this option to manually enable the Fancybox script. If you have disabled Fancybox output in the above settings
        the script output will still be disabled.', 'iphorm'); ?></p>
        <p><label class="ifb-bold"><input type="checkbox" value="1" name="fancybox_requested" id="fancybox_requested" <?php checked(true, get_option('iphorm_fancybox_requested')); ?> /> <?php esc_html_e('Enable Fancybox', 'iphorm'); ?></label></p>

        <h3 class="ifb-sub-head"><span><?php esc_html_e('Server compatibility', 'iphorm'); ?></span></h3>
        <table class="form-table iphorm-server-compat">
            <?php
            $phpVersion = phpversion();
            $phpVersionGood = version_compare($phpVersion, '5.0.0', '>=');
            ?>
            <tr valign="top">
                <th scope="row"><label><?php esc_html_e('PHP Version', 'iphorm'); ?></label></th>
                <td class="iphorm-server-compat-col2"><?php echo $phpVersion; ?></td>
                <td class="iphorm-server-compat-col3"><?php echo $phpVersionGood ? '<img src="'.IPHORM_ADMIN_URL.'/images/iphorm-success.png" alt="" />' : '<img src="'.IPHORM_ADMIN_URL.'/images/iphorm-warning.png" alt="" />'; ?></td>
                <td><?php if (!$phpVersionGood) echo '<span class="ifb-compat-error">' . esc_html__('The plugin requires PHP version 5 or later.', 'iphorm') . '</span>'; ?></td>
            </tr>
            <?php
            global $wpdb;
            $mysqlVersion = $wpdb->db_version();
            $mysqlVersionGood = version_compare($mysqlVersion, '5.0.0', '>=');
            ?>
            <tr valign="top">
                <th scope="row"><label><?php esc_html_e('MySQL Version', 'iphorm'); ?></label></th>
                <td><?php echo $mysqlVersion; ?></td>
                <td><?php echo $mysqlVersionGood ? '<img src="'.IPHORM_ADMIN_URL.'/images/iphorm-success.png" alt="" />' : '<img src="'.IPHORM_ADMIN_URL.'/images/iphorm-warning.png" alt="" />'; ?></td>
                <td><?php if (!$mysqlVersionGood) echo '<span class="ifb-compat-error">' . esc_html__('The plugin requires MySQL version 5 or later.', 'iphorm') . '</span>'; ?></td>
            </tr>
            <?php
            $wordpressVersion = get_bloginfo('version');
            $wordpressVersionGood = version_compare($wordpressVersion, '3.1', '>=');
            ?>
            <tr valign="top">
                <th scope="row"><label><?php esc_html_e('WordPress Version', 'iphorm'); ?></label></th>
                <td><?php echo $wordpressVersion; ?></td>
                <td><?php echo $wordpressVersionGood ? '<img src="'.IPHORM_ADMIN_URL.'/images/iphorm-success.png" alt="" />' : '<img src="'.IPHORM_ADMIN_URL.'/images/iphorm-warning.png" alt="" />'; ?></td>
                <td><?php if (!$wordpressVersionGood) echo '<span class="ifb-compat-error">' . esc_html__('The plugin requires WordPress version 3.1 or later.', 'iphorm') . '</span>'; ?></td>
            </tr>
            <?php
            $gdImageLibaryGood = function_exists('imagecreate');
            ?>
            <tr valign="top">
                <th scope="row"><label><?php esc_html_e('GD Image Library', 'iphorm'); ?></label></th>
                <td><?php echo $gdImageLibaryGood ? __('Available', 'iphorm') : __('Unavailable', 'iphorm'); ?></td>
                <td><?php echo $gdImageLibaryGood ? '<img src="'.IPHORM_ADMIN_URL.'/images/iphorm-success.png" alt="" />' : '<img src="'.IPHORM_ADMIN_URL.'/images/iphorm-warning.png" alt="" />'; ?></td>
                <td><?php if (!$gdImageLibaryGood) echo '<span class="ifb-compat-error">' . esc_html__('The plugin requires the GD image library for the CAPTCHA element, please ask your host to install it.', 'iphorm') . '</span>'; ?></td>
            </tr>
            <?php
            $tempDir = iphorm_get_temp_dir();
            $tempDirGood = is_writeable($tempDir);
            ?>
            <tr valign="top">
                <th scope="row"><label><?php esc_html_e('Temporary Directory', 'iphorm'); ?></label></th>
                <td><?php echo $tempDir; ?></td>
                <td><?php echo $tempDirGood ? '<img src="'.IPHORM_ADMIN_URL.'/images/iphorm-success.png" alt="" />' : '<img src="'.IPHORM_ADMIN_URL.'/images/iphorm-warning.png" alt="" />'; ?></td>
                <td><?php if (!$tempDirGood) echo '<span class="ifb-compat-error">' . sprintf(esc_html__('The plugin requires a writeable temporary directory for file uploading. You can set a custom temporary directory path in your wp-config.php file by using the code %1$sdefine("WP_TEMP_DIR", "/path/to/tmp/dir");%2$s', 'iphorm'), '<code>', '</code>') . '</span>'; ?></td>
            </tr>
        </table>

        <p class="submit iphorm-save-settings"><input type="submit" value="Save Changes" class="button-primary" name="iphorm_settings" /></p>
    </form>
</div>
