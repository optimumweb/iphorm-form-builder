<?php if (!defined('IPHORM_VERSION')) exit; ?><div id="ifb-top" class="wrap clearfix">
    <div class="iphorm-top-right">
        <div class="iphorm-information">
            <span class="iphorm-copyright"><a href="http://www.themecatcher.net" onclick="window.open(this.href); return false;">www.themecatcher.net</a> &copy; <?php echo date('Y'); ?></span>
            <span class="iphorm-bug-link"><a href="http://www.themecatcher.net/support.php" onclick="window.open(this.href); return false;"><?php esc_html_e('Report a bug', 'iphorm'); ?></a></span>
            <span class="iphorm-help-link"><a href="<?php echo iphorm_help_link(); ?>" onclick="window.open(this.href); return false;"><?php esc_html_e('Help', 'iphorm'); ?></a></span>
        </div>
    </div>
    <?php if (is_array($form)) : ?>
    <?php screen_icon('iphorm'); ?>
    <?php if (!isset($form['name'])) $form['name'] = __('New form', 'iphorm'); ?>
    <h2 class="ifb-main-title"><span class="ifb-iphorm-title">Quform</span><?php esc_html_e('Form Builder', 'iphorm'); ?><span class="ifb-iphorm-title-form-name ifb-update-form-name ifb-hidden"><?php echo esc_html($form['name']); ?></span></h2>
        <?php
            if (!get_option('iphorm_hide_nag_message')) {
                $uploadDir = wp_upload_dir();
                if (($uploadDir['error'] !== false || !is_writable($uploadDir['basedir']))) {
                    echo '<div id="ifb-nag-message" class="iphorm-admin-notice error"><p><strong>' . sprintf(esc_html__('The WordPress uploads directory is not writable, it will not be possible to save files uploaded via your forms. %sPermanently hide this message%s', 'iphorm'), '<a href="javascript:;" onclick="iPhorm.hideNagMessage(); return false;">', '</a>') . '</strong></p></div>';
                }
            }

            if (!strlen(get_option('iphorm_licence_key'))) {
                echo '<div class="error"><p><strong>' . sprintf(esc_html__('You are using an unlicensed version. Please %senter your license key%s or %spurchase a license key%s.', 'iphorm'), '<a href="' . admin_url('admin.php?page=iphorm_settings') .'">', '</a>', '<a href="http://www.themecatcher.net/iphorm-form-builder/buy.php" onclick="window.open(this.href); return false;">', '</a>') . '</strong></p></div>';
            }
        ?>

        <div class="iphorm-global-nav-wrap clearfix">
            <ul class="iphorm-global-nav-ul">
                <li><a href="admin.php?page=iphorm_forms"><span class="ifb-no-arrow"><?php esc_html_e('All Forms', 'iphorm'); ?></span></a></li>
                <li>
                 <div class="iphorm-form-switcher">
                    <a id="iphorm-form-switcher-trigger" class="ifb-form-switcher-closed"><span class="ifb-arrow-down"><?php esc_html_e('Switch Form', 'iphorm'); ?></span></a>
                    <div class="iphorm-form-switcher-list">
                        <ul class="clearfix">
                            <li class="iphorm-create-new clearfix"><a title="<?php esc_attr_e('Create a new form', 'iphorm'); ?>" href="admin.php?page=iphorm_form_builder"><?php esc_html_e('Create a new form', 'iphorm'); ?><span class="ifb-add-icon"></span></a></li>
                            <?php if (count($allForms)) : ?>
                                <?php foreach ($allForms as $allForm) : ?>
                                    <li class="clearfix"><a title="<?php echo esc_attr($allForm['name']); ?>" href="admin.php?page=iphorm_form_builder&amp;id=<?php echo $allForm['id']; ?>"><?php echo esc_html($allForm['name']); ?><span class="ifb-fade-overflow"></span></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                </li>
                <li><a id="iphorm-builder-to-entries-link" class="ifb-hide-if-new-form" href="<?php echo admin_url('admin.php?page=iphorm_entries&amp;id=' . $id); ?>"><span class="ifb-no-arrow"><?php esc_html_e('Entries', 'iphorm'); ?></span></a></li>
                <li><a id="iphorm-add-to-website" class="ifb-add-to-website-closed ifb-hide-if-new-form"><span class="ifb-arrow-down"><?php esc_html_e('Add to website', 'iphorm'); ?></span></a></li>
                <li><a id="iphorm-reload-link" class="ifb-hide-if-new-form" href="<?php echo admin_url('admin.php?page=iphorm_form_builder&amp;id=' . $id); ?>"><span class="ifb-no-arrow"><?php esc_html_e('Reload', 'iphorm'); ?></span></a></li>
            </ul>
            <div class="iphorm-current-form ifb-hidden">
                <span id="ifb-current-form-name" class="ifb-update-form-name"><?php echo esc_html($form['name']); ?></span><span class="ifb-current-form-id-wrap">(<span class="ifb-update-form-id"><?php echo $id; ?></span>)</span>
            </div>
        </div>

        <div id="ifb-first-save-message">
            <div id="ifb-first-save-close"></div>
            <h2><?php esc_html_e('You can now add the form to any post, page or widget.', 'iphorm'); ?></h2>
            <div id="ifb-first-save-accordion">
                <h3 class="ifb-show-atw-content ifb-show-atw-content-closed"><?php esc_html_e('Add your form to a post or page', 'iphorm'); ?></h3>
                <div class="ifb-add-to-website-content-area ifb-first-save-1">
                <p><?php esc_html_e('Add or edit the page you want to show the form on. If you look above
                    the visual editor you should see a Quform icon above it, as shown below.', 'iphorm'); ?></p>
                <p><img src="<?php echo IPHORM_ADMIN_URL . '/images/insert-screenshot.png'; ?>" alt="" /></p>
                <p><?php esc_html_e('Click the Quform icon and a popup should appear, select the form from
                    the list and click the Insert form button. The shortcode for this form should now appear
                    inside your text editor. Alternatively, you can copy and paste one of the shortcodes below into your
                    post or page content.', 'iphorm'); ?></p>
                <h4><?php esc_html_e('Standard form', 'iphorm'); ?></h4>
                <pre>[iphorm id=<span class="ifb-update-form-id"><?php echo $id; ?></span> name="<span class="ifb-update-form-name"><?php echo $form['name']; ?></span>"]</pre>
                <h4><?php esc_html_e('Popup form', 'iphorm'); ?></h4>
                <pre>[iphorm_popup id=<span class="ifb-update-form-id"><?php echo $id; ?></span> name="<span class="ifb-update-form-name"><?php echo $form['name']; ?></span>"]<?php esc_html_e('Change this to the text or HTML that will trigger the popup', 'iphorm'); ?>[/iphorm_popup]</pre>
                </div>
                <h3 class="ifb-show-atw-content ifb-show-atw-content-closed"><?php esc_html_e('Add your form as a widget', 'iphorm'); ?></h3>
                <div class="ifb-add-to-website-content-area ifb-first-save-2">
                <p><?php esc_html_e('To add the form as a widget into a widget enabled area, go to the Appearance &rarr; Widgets
                    in the WordPress navigation. Find the widget with the title "Quform" (or "Quform Popup" for a popup form) and simply
                    drag it to your widget enabled area. Select one of the forms from the dropdown menu
                    and click Save.', 'iphorm'); ?></p>
                </div>
                <h3 class="ifb-show-atw-content ifb-show-atw-content-closed"><?php esc_html_e('Add your form to a theme PHP file', 'iphorm'); ?></h3>
                <div class="ifb-add-to-website-content-area ifb-first-save-3">
                <p><?php esc_html_e('To add this form to one of your theme PHP files, use one of the PHP snippets below.', 'iphorm'); ?></p>
                <h4><?php esc_html_e('Standard form', 'iphorm'); ?></h4>
                <pre>&lt;?php if (function_exists('iphorm')) echo iphorm(<span class="ifb-update-form-id"><?php echo $id; ?></span>); ?&gt;</pre>
                <h4><?php esc_html_e('Popup form', 'iphorm'); ?></h4>
                <pre>&lt;?php if (function_exists('iphorm_popup')) echo iphorm_popup(<span class="ifb-update-form-id"><?php echo $id; ?></span>, '<?php esc_html_e('Change this to the text or HTML that will trigger the popup', 'iphorm'); ?>'); ?&gt;</pre>
                </div>
            </div>
        </div>
        <div id="ifb-new-form-name-overlay" class="ifb-new-form-name-overlay">
            <div class="ifb-new-form-name-outer">
                <div class="ifb-new-form-name-close">x</div>
                <div class="ifb-new-form-name-inner">
                    <h3><?php esc_html_e('Please enter a name for your new form', 'iphorm'); ?></h3>
                    <div class="ifb-new-form-name-inner2 clearfix">
                        <input id="new_form_name" class="new-form-name" type="text" value="" autocomplete="off" />
                        <div class="ifb-new-form-name-ok"><?php esc_html_e('OK', 'iphorm'); ?></div>
                    </div>
                    <p class="description"><?php esc_html_e('e.g. Contact form', 'iphorm'); ?></p>
                </div>
            </div>
        </div>
        <form id="ifb" method="post" action="">
        <div class="ifb-wrap-outer">
            <input type="submit" class="ifb-hidden" /><!-- Prevent the enter key doing wierd stuff -->
            <div class="ifb-wrap clearfix">
                <div class="ifb-right-col">
                    <div class="ifb-right-scroll-wrap">
                        <div class="ifb-add-element-wrap">
                            <div id="ifb-add-element-tabs">
                                <ul class="ifb-tabs-nav">
                                  <li><a href="#ifb-add-element-popular"><?php esc_html_e('Popular', 'iphorm'); ?></a></li>
                                  <li><a href="#ifb-add-element-more"><?php esc_html_e('More', 'iphorm'); ?></a></li>
                               </ul>
                               <div id="ifb-add-element-popular" class="ifb-add-element-list ifb-tabs-panel">
                                    <ul class="ifb-add-element-ul">
                                        <li><div class="ifb-add-element-button" data-type="text" onclick="iPhorm.addElement('text'); return false;"><?php esc_html_e('Single Line Text', 'iphorm'); ?></div></li>
                                        <li><div class="ifb-add-element-button" data-type="textarea" onclick="iPhorm.addElement('textarea'); return false;"><?php esc_html_e('Paragraph Text', 'iphorm'); ?></div></li>
                                        <li><div class="ifb-add-element-button" data-type="email" onclick="iPhorm.addElement('email'); return false;"><?php esc_html_e('Email Address', 'iphorm'); ?></div></li>
                                        <li><div class="ifb-add-element-button" data-type="select" onclick="iPhorm.addElement('select'); return false;"><?php esc_html_e('Dropdown Menu', 'iphorm'); ?></div></li>
                                        <li><div class="ifb-add-element-button" data-type="checkbox" onclick="iPhorm.addElement('checkbox'); return false;"><?php esc_html_e('Checkboxes', 'iphorm'); ?></div></li>
                                        <li><div class="ifb-add-element-button" data-type="radio" onclick="iPhorm.addElement('radio'); return false;"><?php esc_html_e('Multiple Choice', 'iphorm'); ?></div></li>
                                        <li><div class="ifb-add-element-button" data-type="captcha" onclick="iPhorm.addElement('captcha'); return false;"><?php esc_html_e('CAPTCHA', 'iphorm'); ?></div></li>
                                        <li><div class="ifb-add-element-button" data-type="group" onclick="iPhorm.addElement('group'); return false;"><?php esc_html_e('Group', 'iphorm'); ?></div></li>
                                    </ul>
                                </div>
                                <div id="ifb-add-element-more" class="ifb-add-element-list ifb-tabs-panel">
                                    <ul class="ifb-add-element-ul">
                                        <li><div class="ifb-add-element-button" data-type="file" onclick="iPhorm.addElement('file'); return false;"><?php esc_html_e('File Upload', 'iphorm'); ?></div></li>
                                        <li><div class="ifb-add-element-button" data-type="recaptcha" onclick="iPhorm.addElement('recaptcha'); return false;"><?php esc_html_e('reCAPTCHA', 'iphorm'); ?></div></li>
                                        <li><div class="ifb-add-element-button" data-type="html" onclick="iPhorm.addElement('html'); return false;"><?php esc_html_e('HTML', 'iphorm'); ?></div></li>
                                        <li><div class="ifb-add-element-button" data-type="date" onclick="iPhorm.addElement('date'); return false;"><?php esc_html_e('Date', 'iphorm'); ?></div></li>
                                        <li><div class="ifb-add-element-button" data-type="time" onclick="iPhorm.addElement('time'); return false;"><?php esc_html_e('Time', 'iphorm'); ?></div></li>
                                        <li><div class="ifb-add-element-button" data-type="hidden" onclick="iPhorm.addElement('hidden'); return false;"><?php esc_html_e('Hidden', 'iphorm'); ?></div></li>
                                        <li><div class="ifb-add-element-button" data-type="password" onclick="iPhorm.addElement('password'); return false;"><?php esc_html_e('Password', 'iphorm'); ?></div></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="ifb-buttons clearfix">
                            <a class="ifb-grey" onclick="iPhorm.preview(); return false;"><?php esc_html_e('Preview', 'iphorm'); ?></a>
                            <a class="ifb-blue" onclick="iPhorm.saveForm(this, '<?php echo wp_create_nonce('iphorm_save_form'); ?>'); return false;">
                                <span class="ifb-save"><?php esc_attr_e('Save', 'iphorm'); ?></span>
                                <span class="ifb-saving"></span>
                                <span class="ifb-saved"></span>
                                <span class="ifb-save-failed"></span>
                            </a>

                        </div>
                    </div>
                </div>
                <div class="ifb-left-col">
                    <div id="ifb-message-area"></div>
                    <div id="ifb-tabs">
                        <ul class="ifb-tabs-nav">
                            <li><a id="ifb-edit-form-tab" title="<?php esc_attr_e('Edit your form', 'iphorm'); ?>" href="#ifb-elements"><span></span><?php esc_html_e('Form', 'iphorm'); ?></a></li>
                            <li><a id="ifb-settings-tab"  title="<?php esc_attr_e('Global form settings', 'iphorm'); ?>" href="#ifb-settings"><span></span><?php esc_html_e('Settings', 'iphorm'); ?></a></li>
                        </ul>
                        <?php if (!isset($form['elements'])) $form['elements'] = array(); ?>
                        <div class="ifb-tabs-panel" id="ifb-elements">
                            <h2 id="ifb-title" class="ifb-hidden"></h2>
                            <p id="ifb-description" class="ifb-hidden"></p>
                            <p id="ifb-elements-empty">
                                <span class="ibf-elements-empty-line1"><?php esc_html_e('drop an element here', 'iphorm'); ?></span>
                                <span class="ibf-elements-empty-line2"><?php esc_html_e('(or just click it)', 'iphorm'); ?></span>
                            </p>
                            <div id="ifb-elements-wrap">
                                <?php
                                    foreach ($form['elements'] as $element) {
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
                                                break;
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="ifb-tabs-panel" id="ifb-settings">
                            <div id="ifb-settings-tabs">
                                <ul class="ifb-tabs-nav">
                                    <li><a title="<?php esc_attr_e('Common settings', 'iphorm'); ?>" href="#ifb-settings-general"><?php esc_html_e('General', 'iphorm'); ?></a></li>
                                    <li><a title="<?php esc_attr_e('What the form will look like', 'iphorm'); ?>" href="#ifb-settings-style"><?php esc_html_e('Style', 'iphorm'); ?></a></li>
                                    <li><a title="<?php esc_attr_e("Where the data is sent and how it's displayed", 'iphorm'); ?>" href="#ifb-settings-email"><?php esc_html_e('Email', 'iphorm'); ?></a></li>
                                    <li><a title="<?php esc_attr_e('Set up saving submitted form entries', 'iphorm'); ?>" href="#ifb-settings-entries"><?php echo esc_html_x('Entries', 'saved submitted form entries', 'iphorm'); ?></a></li>
                                    <li><a title="<?php esc_attr_e('Save form data to a custom database', 'iphorm'); ?>" href="#ifb-settings-database"><?php esc_html_e('Database', 'iphorm'); ?></a></li>
                                </ul>
                                <div class="ifb-tabs-panel" id="ifb-settings-general">
                                    <table class="ifb-form-table ifb-settings-form-table ifb-settings-general-form-table">
                                        <tr class="ifb-settings-sub-head" valign="top">
                                            <td colspan="2" scope="row"><h3><?php esc_html_e('Form information', 'iphorm'); ?></h3></td>
                                        </tr>
                                        <tr valign="top">
                                            <th scope="row">
                                            <div class="ifb-tooltip"><div class="ifb-tooltip-content"><?php esc_html_e('This is your form name within WordPress, it will not appear on your website', 'iphorm'); ?></div></div>
                                            <label for="name"><?php esc_html_e('Name', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="text" name="name" id="name" onkeyup="iPhorm.updateFormName();" value="<?php echo esc_attr($form['name']); ?>" />
                                                <p class="description"><?php esc_html_e('Give the form a name', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['title'])) $form['title'] = ''; ?>
                                        <tr valign="top">
                                            <th scope="row">
                                             <div class="ifb-tooltip"><div class="ifb-tooltip-content"><?php esc_html_e('The heading that will show above the form on your website', 'iphorm'); ?></div></div>
                                            <label for="title"><?php esc_html_e('Title', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="text" name="title" id="title" onkeyup="iPhorm.updateFormTitle();" value="<?php echo _wp_specialchars($form['title'], ENT_COMPAT, false, true); ?>" />
                                                <p class="description"><?php esc_html_e('Title to display above the form', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['description'])) $form['description'] = ''; ?>
                                        <tr valign="top">
                                            <th scope="row">
                                            <div class="ifb-tooltip"><div class="ifb-tooltip-content"><?php esc_html_e('The description that will show below the form title.', 'iphorm'); ?></div></div>
                                            <label for="description"><?php esc_html_e('Description', 'iphorm'); ?></label></th>
                                            <td>
                                                <textarea name="description" id="description" onkeyup="iPhorm.updateFormDescription();"><?php echo _wp_specialchars($form['description'], ENT_NOQUOTES, false, true); ?></textarea>
                                                <p class="description"><?php esc_html_e('Description to display above the form', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['active'])) $form['active'] = true; ?>
                                        <tr valign="top">
                                            <th scope="row"><label for="active"><?php esc_html_e('Active', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="checkbox" id="active" name="active" <?php checked($form['active'], true); ?> />
                                                <p class="description"><?php esc_html_e('Inactive forms will not appear on your website', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <tr class="ifb-settings-sub-head" valign="top">
                                            <td colspan="2" scope="row"><h3><?php esc_html_e('Successful submit options', 'iphorm'); ?></h3></td>
                                        </tr>
                                        <?php if (!isset($form['success_type'])) $form['success_type'] = 'message'; ?>
                                        <tr valign="top">
                                            <th scope="row"><label for="success_type"><?php esc_html_e('On successful submit', 'iphorm'); ?></label></th>
                                            <td>
                                                <select id="success_type" name="success_type" onchange="iPhorm.updateSuccessType();">
                                                    <option value="message" <?php selected($form['success_type'], 'message'); ?>><?php esc_html_e('Display a message', 'iphorm'); ?></option>
                                                    <option value="redirect" <?php selected($form['success_type'], 'redirect'); ?>><?php esc_html_e('Redirect to another page', 'iphorm'); ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['success_message'])) $form['success_message'] = __('Your message has been sent, thanks.', 'iphorm'); ?>
                                        <tr valign="top" class="<?php if ($form['success_type'] != 'message') echo 'ifb-hidden'; ?> show-if-success-type-message">
                                            <th scope="row"><label for="success_message"><?php esc_html_e('Message', 'iphorm'); ?></label></th>
                                            <td>
                                            	<div class="ifb-success-message-options"><select title="<?php esc_attr_e('Add more data to your message by inserting a variable tag', 'iphorm'); ?>" class="ifb-insert-variable" onchange="iPhorm.insertVariable('#success_message', this);"></select></div>
                                                <textarea id="success_message" name="success_message"><?php echo _wp_specialchars($form['success_message'], ENT_NOQUOTES, false, true); ?></textarea>
                                                <p class="description"><?php esc_html_e('Message to display when the form is successfully submitted. You can enter HTML to format the message.', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['success_message_position'])) $form['success_message_position'] = 'above'; ?>
                                        <tr valign="top" class="<?php if ($form['success_type'] != 'message') echo 'ifb-hidden'; ?> show-if-success-type-message">
                                            <th scope="row"><label for="success_message_position"><?php esc_html_e('Message position', 'iphorm'); ?></label></th>
                                            <td>
                                                <select id="success_message_position" name="success_message_position">
                                                    <option value="above" <?php selected($form['success_message_position'], 'above'); ?>><?php esc_html_e('Above the form', 'iphorm'); ?></option>
                                                    <option value="below" <?php selected($form['success_message_position'], 'below'); ?>><?php esc_html_e('Below the form', 'iphorm'); ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['success_message_timeout'])) $form['success_message_timeout'] = '10'; ?>
                                        <tr valign="top" class="<?php if ($form['success_type'] != 'message') echo 'ifb-hidden'; ?> show-if-success-type-message">
                                            <th scope="row"><label for="success_message_timeout"><?php esc_html_e('Message timeout', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="text" id="success_message_timeout" name="success_message_timeout" value="<?php echo esc_attr($form['success_message_timeout']); ?>" />
                                                <p class="description"><?php esc_html_e('The success message will fade out and disappear after this number of seconds. Set to 0 to disable the timeout.', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['success_redirect_type'])) $form['success_redirect_type'] = ''; ?>
                                        <?php if (!isset($form['success_redirect_value'])) $form['success_redirect_value'] = ''; ?>
                                        <tr valign="top" class="<?php if ($form['success_type'] != 'redirect') echo 'ifb-hidden'; ?> show-if-success-type-redirect">
                                            <th scope="row"><label for="success_redirect_type"><?php esc_html_e('Redirect to', 'iphorm'); ?></label></th>
                                            <td>
                                                <select id="success_redirect_type" name="success_redirect_type" onchange="iPhorm.updateSuccessRedirectType(this);">
                                                    <option value="" <?php selected($form['success_redirect_type'], ''); ?>><?php esc_html_e('Please select...', 'iphorm'); ?></option>
                                                    <option value="page" <?php selected($form['success_redirect_type'], 'page'); ?>><?php esc_html_e('Page', 'iphorm'); ?></option>
                                                    <option value="post" <?php selected($form['success_redirect_type'], 'post'); ?>><?php esc_html_e('Post', 'iphorm'); ?></option>
                                                    <option value="url" <?php selected($form['success_redirect_type'], 'url'); ?>><?php esc_html_e('URL', 'iphorm'); ?></option>
                                                </select>
                                                <select id="success_redirect_page" name="success_redirect_page" class="<?php if ($form['success_redirect_type'] != 'page') echo 'ifb-hidden'; ?>">
                                                    <?php $pages = get_pages(); ?>
                                                    <?php foreach ($pages as $page) : ?>
                                                        <option value="<?php echo esc_attr($page->ID); ?>" <?php if ($form['success_redirect_type'] == 'page') selected($form['success_redirect_value'], $page->ID); ?>><?php echo esc_attr($page->post_title); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <select id="success_redirect_post" name="success_redirect_post" class="<?php if ($form['success_redirect_type'] != 'post') echo 'ifb-hidden'; ?>">
                                                    <?php $posts = get_posts(); ?>
                                                    <?php foreach ($posts as $post) : ?>
                                                        <option value="<?php echo esc_attr($post->ID); ?>" <?php if ($form['success_redirect_type'] == 'post') selected($form['success_redirect_value'], $post->ID); ?>><?php echo esc_attr($post->post_title); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <input type="text" id="success_redirect_url" name="success_redirect_url" class="<?php if ($form['success_redirect_type'] != 'url') echo 'ifb-hidden'; ?>" value="<?php if ($form['success_redirect_type'] == 'url') echo esc_attr($form['success_redirect_value']); ?>" />
                                                <p class="description"><?php esc_html_e('When the form is successfully submitted you can redirect the user to post, page or URL.', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <tr class="ifb-settings-sub-head" valign="top">
                                            <td colspan="2" scope="row"><h3><?php esc_html_e('More options', 'iphorm'); ?></h3></td>
                                        </tr>
                                        <?php if (!isset($form['submit_button_text'])) $form['submit_button_text'] = ''; ?>
                                        <tr valign="top">
                                            <th scope="row">
                                             <div class="ifb-tooltip"><div class="ifb-tooltip-content"><?php esc_html_e('What would you like your form submit button to say? E.g. Submit, Go, Get in touch ... etc', 'iphorm'); ?></div></div>
                                            <label for="submit_button_text"><?php esc_html_e('Submit button text', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="text" id="submit_button_text" name="submit_button_text" value="<?php echo esc_attr($form['submit_button_text']); ?>" />
                                                <p class="description"><?php echo esc_html(sprintf(__('Override the default text of the submit button which is "%s"', 'iphorm'), __('Send', 'iphorm'))); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['use_ajax'])) $form['use_ajax'] = true; ?>
                                        <tr valign="top">
                                            <th scope="row"><label for="use_ajax"><?php esc_html_e('Use Ajax', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="checkbox" id="use_ajax" name="use_ajax" <?php checked($form['use_ajax'], true); ?> />
                                                <p class="description"><?php esc_html_e('When enabled, the form will submit without reloading the page. If disabled, it will also disable the Flash file uploader.', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['use_honeypot'])) $form['use_honeypot'] = true; ?>
                                        <tr valign="top">
                                            <th scope="row"><label for="use_honeypot"><?php esc_html_e('Enable honeypot CAPTCHA', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="checkbox" id="use_honeypot" name="use_honeypot" <?php checked($form['use_honeypot'], true); ?> />
                                                <p class="description"><?php esc_html_e('A hidden anti-spam measure that requires no user interaction', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['conditional_logic_animation'])) $form['conditional_logic_animation'] = true; ?>
                                        <tr valign="top">
                                            <th scope="row"><label for="conditional_logic_animation"><?php esc_html_e('Conditional logic animation', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="checkbox" id="conditional_logic_animation" name="conditional_logic_animation" <?php checked($form['conditional_logic_animation'], true); ?> />
                                                <p class="description"><?php esc_html_e('If enabled the fields that are hidden or shown via conditional logic will be
                                                animated instead of hidden or shown instantly.', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['center_fancybox'])) $form['center_fancybox'] = true; ?>
                                        <tr valign="top">
                                            <th scope="row"><label for="center_fancybox"><?php esc_html_e('Re-center Fancybox after conditional logic', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="checkbox" id="center_fancybox" name="center_fancybox" <?php checked($form['center_fancybox'], true); ?> />
                                                <p class="description"><?php esc_html_e('If enabled, when conditional logic causes the Fancybox popup to change size it will center the popup.', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <tr class="ifb-settings-sub-head" valign="top">
                                            <td colspan="2" scope="row"><h3><?php esc_html_e('Make money and support Quform!', 'iphorm'); ?></h3></td>
                                        </tr>
                                        <?php if (!isset($form['show_referral_link'])) $form['show_referral_link'] = false; ?>
                                        <tr valign="top">
                                            <th scope="row">
                                                <label for="show_referral_link"><?php esc_html_e('Display a referral link', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <input type="checkbox" id="show_referral_link" name="show_referral_link" <?php checked($form['show_referral_link'], true); ?> />
                                                <p class="description"><?php esc_html_e('Displays a Quform referral link under your form, with the text you specify below', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['referral_text'])) $form['referral_text'] = __('Powered by Quform', 'iphorm'); ?>
                                        <tr valign="top">
                                            <th scope="row">
                                                <div class="ifb-tooltip"><div class="ifb-tooltip-content"><?php esc_html_e("This is the text that will link to Quform, it's displayed under your form.", 'iphorm'); ?></div></div>
                                                <label for="referral_text"><?php esc_html_e('Referral link text', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <input type="text" id="referral_text" name="referral_text" value="<?php echo esc_attr($form['referral_text']); ?>" />
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['referral_username'])) $form['referral_username'] = ''; ?>
                                        <tr valign="top">
                                            <th scope="row"><label for="referral_username"><?php esc_html_e('ThemeForest / CodeCanyon username', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="text" id="referral_username" name="referral_username" value="<?php echo $form['referral_username']; ?>" />
                                                <p class="description"><?php esc_html_e('Enter your ThemeForest or CodeCanyon username and you will receive 30% of the first deposit or purchase amount from any referrals
                                                when users click on your referral link.', 'iphorm'); ?> <a href="http://themeforest.net/wiki/referral/referral-program/" onclick="window.open(this.href); return false;"><?php esc_html_e('More information', 'iphorm'); ?></a>.</p>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="ifb-tabs-panel" id="ifb-settings-style">
                                    <table class="ifb-form-table ifb-settings-form-table ifb-settings-style-form-table">
                                        <tr class="ifb-settings-sub-head" valign="top">
                                            <td colspan="2" scope="row"><h3><?php esc_html_e('Style', 'iphorm'); ?></h3></td>
                                        </tr>
                                        <?php if (!isset($form['theme'])) $form['theme'] = ''; ?>
                                        <tr valign="top">
                                            <th scope="row">
                                                <div class="ifb-tooltip"><div class="ifb-tooltip-content"><?php esc_html_e('Themes define the look of your form. You can add your own themes, see the Help for more information.', 'iphorm'); ?></div></div>
                                                <label for="theme"><?php esc_html_e('Theme', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <select id="theme" name="theme">
                                                    <?php if (count($themes)) : ?>
                                                        <option value=""><?php esc_html_e('None', 'iphorm'); ?></option>
                                                        <?php foreach ($themes as $theme) : ?>
                                                            <?php $value = esc_attr($theme['Folder']) . '|' . esc_attr($theme['Filename']); ?>
                                                            <option value="<?php echo $value; ?>" <?php selected($form['theme'], $value); ?>><?php echo esc_attr($theme['Name']); ?></option>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <option value=""><?php esc_html_e('No themes found', 'iphorm'); ?></option>
                                                    <?php endif; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr class="ifb-settings-sub-head" valign="top">
                                            <td colspan="2" scope="row"><h3><?php esc_html_e('Uniform', 'iphorm'); ?></h3></td>
                                        </tr>
                                        <?php if (!isset($form['use_uniformjs'])) $form['use_uniformjs'] = true; ?>
                                        <tr valign="top">
                                            <th scope="row">
                                                <div class="ifb-tooltip"><div class="ifb-tooltip-content"><?php esc_html_e('Uniform makes form inputs look consistent in all browsers.', 'iphorm'); ?></div></div>
                                                <label for="use_uniformjs"><?php esc_html_e('Use Uniform', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <input type="checkbox" name="use_uniformjs" id="use_uniformjs" onclick="iPhorm.toggleUseUniform(this.checked);" <?php checked($form['use_uniformjs'], true); ?> />
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['uniformjs_theme'])) $form['uniformjs_theme'] = 'default'; ?>
                                        <tr valign="top" class="<?php if (!$form['use_uniformjs']) echo 'ifb-hidden'; ?> show-if-use-uniform">
                                            <th scope="row">
                                                <label for="uniformjs_theme"><?php esc_html_e('Theme', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <select id="uniformjs_theme" name="uniformjs_theme">
                                                    <?php foreach ($uniformThemes as $uniformTheme) : ?>
                                                        <option value="<?php echo esc_attr($uniformTheme['Folder']); ?>" <?php selected($form['uniformjs_theme'], $uniformTheme['Folder']); ?>><?php echo esc_html($uniformTheme['UniformTheme']); if (isset($uniformTheme['By'])) echo esc_html(sprintf(__(' (by %s)', 'iphorm'), $uniformTheme['By'])); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <script type="text/javascript">
                                                //<![CDATA[
                                                    jQuery(document).ready(function ($) {
                                                        $('#theme').change(function () {
                                                            if ($(this).val() == '')  {
                                                                $('#uniformjs_theme').val('default');
                                                            }
                                                            <?php foreach ($themes as $theme) : ?>
                                                                <?php if (isset($theme['UniformTheme']) && array_key_exists($theme['UniformTheme'], $uniformThemes)) : ?>
                                                                    if ($(this).val() == '<?php echo esc_js($theme['Folder']) . '|' . esc_js($theme['Filename']); ?>') {
                                                                        $('#uniformjs_theme').val('<?php echo esc_js($theme['UniformTheme']); ?>');
                                                                    }
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        });
                                                    });
                                                //]]>
                                                </script>
                                            </td>
                                        </tr>
                                        <tr class="ifb-settings-sub-head" valign="top">
                                            <td colspan="2" scope="row"><h3><?php esc_html_e('Datepicker', 'iphorm'); ?></h3></td>
                                        </tr>
                                        <?php if (!isset($form['jqueryui_theme'])) $form['jqueryui_theme'] = 'smoothness'; ?>
                                        <tr valign="top">
                                            <th scope="row">
                                                <div class="ifb-tooltip"><div class="ifb-tooltip-content"><?php esc_html_e('The theme chosen here will apply to all datepicker elements in your form.', 'iphorm'); ?></div></div>
                                                <label for="jqueryui_theme"><?php esc_html_e('Theme', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <?php $jqueryUiThemes = array(
                                                    '' => 'None',
                                                    'black-tie' => 'Black Tie',
                                                    'blitzer' => 'Blitzer',
                                                    'cupertino' => 'Cupertino',
                                                    'dark-hive' => 'Dark Hive',
                                                    'dot-luv' => 'Dot Luv',
                                                    'eggplant' => 'Eggplant',
                                                    'excite-bike' => 'Excite Bike',
                                                    'flick' => 'Flick',
                                                    'hot-sneaks' => 'Hot Sneaks',
                                                    'humanity' => 'Humanity',
                                                    'le-frog' => 'Le Frog',
                                                    'mint-choc' => 'Mint Chocolate',
                                                    'overcast' => 'Overcast',
                                                    'pepper-grinder' => 'Pepper Grinder',
                                                    'redmond' => 'Redmond',
                                                    'smoothness' => 'Smoothness',
                                                    'south-street' => 'South Street',
                                                    'start' => 'Start',
                                                    'sunny' => 'Sunny',
                                                    'swanky-purse' => 'Swanky Purse',
                                                    'trontastic' => 'Trontastic',
                                                    'ui-darkness' => 'UI Darkness',
                                                    'ui-lightness' => 'UI Lightness',
                                                    'vader' => 'Vader'
                                                ); ?>
                                                <select id="jqueryui_theme" name="jqueryui_theme">
                                                    <?php foreach ($jqueryUiThemes as $key => $name) : ?>
                                                        <option value="<?php echo esc_attr($key); ?>" <?php selected($form['jqueryui_theme'], $key); ?>><?php echo esc_html($name); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <p class="description"><?php printf(esc_html__('Choose the theme of the datepicker, %ssee examples of each theme%s.', 'iphorm'), '<a href="http://jqueryui.com/demos/datepicker/" onclick="window.open(this.href); return false;">', '</a>'); ?>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['jqueryui_l10n'])) $form['jqueryui_l10n'] = ''; ?>
                                        <tr valign="top">
                                            <th scope="row">
                                                <div class="ifb-tooltip"><div class="ifb-tooltip-content"><?php esc_html_e('The datepicker will be translated into the language you choose
                                                and the date settings will be appropriate for your region.', 'iphorm'); ?></div></div>
                                                <label for="jqueryui_l10n"><?php esc_html_e('Locale', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <?php $jqueryUiLocales = array(
                                                    '' => 'Default (English/Western)',
                                                    'af' => 'Afrikaans',
                                                    'sq' => 'Albanian (Gjuha shqipe)',
                                                    'ar-DZ' => 'Algerian Arabic',
                                                    'ar' => 'Arabic (&#8235;(&#1604;&#1593;&#1585;&#1576;&#1610;',
                                                    'hy' => 'Armenian (&#1344;&#1377;&#1397;&#1381;&#1408;&#1381;&#1398;)',
                                                    'az' => 'Azerbaijani (Az&#601;rbaycan dili)',
                                                    'eu' => 'Basque (Euskara)',
                                                    'bs' => 'Bosnian (Bosanski)',
                                                    'bg' => 'Bulgarian (&#1073;&#1098;&#1083;&#1075;&#1072;&#1088;&#1089;&#1082;&#1080; &#1077;&#1079;&#1080;&#1082;)',
                                                    'ca' => 'Catalan (Catal&agrave;)',
                                                    'zh-HK' => 'Chinese Hong Kong (&#32321;&#39636;&#20013;&#25991;)',
                                                    'zh-CN' => 'Chinese Simplified (&#31616;&#20307;&#20013;&#25991;)',
                                                    'zh-TW' => 'Chinese Traditional (&#32321;&#39636;&#20013;&#25991;)',
                                                    'hr' => 'Croatian (Hrvatski jezik)',
                                                    'cs' => 'Czech (&#269;e&#353;tina)',
                                                    'da' => 'Danish (Dansk)',
                                                    'nl' => 'Dutch (Nederlands)',
                                                    'en-AU' => 'English/Australia',
                                                    'en-NZ' => 'English/New Zealand',
                                                    'en-GB' => 'English/UK',
                                                    'eo' => 'Esperanto',
                                                    'et' => 'Estonian (eesti keel)',
                                                    'fo' => 'Faroese (f&oslash;royskt)',
                                                    'fa' => 'Farsi/Persian (&#8235;(&#1601;&#1575;&#1585;&#1587;&#1740;',
                                                    'fi' => 'Finnish (suomi)',
                                                    'fr' => 'French (Fran&ccedil;ais)',
                                                    'fr-CH' => 'French/Swiss (Fran&ccedil;ais de Suisse)',
                                                    'gl' => 'Galician',
                                                    'de' => 'German (Deutsch)',
                                                    'el' => 'Greek (&#917;&#955;&#955;&#951;&#957;&#953;&#954;&#940;)',
                                                    'he' => 'Hebrew (&#8235;(&#1506;&#1489;&#1512;&#1497;&#1514;',
                                                    'hu' => 'Hungarian (Magyar)',
                                                    'is' => 'Icelandic (&Otilde;slenska)',
                                                    'id' => 'Indonesian (Bahasa Indonesia)',
                                                    'it' => 'Italian (Italiano)',
                                                    'ja' => 'Japanese (&#26085;&#26412;&#35486;)',
                                                    'ko' => 'Korean (&#54620;&#44397;&#50612;)',
                                                    'kz' => 'Kazakhstan (Kazakh)',
                                                    'lv' => 'Latvian (Latvie&ouml;u Valoda)',
                                                    'lt' => 'Lithuanian (lietuviu kalba)',
                                                    'ml' => 'Malayalam',
                                                    'ms' => 'Malaysian (Bahasa Malaysia)',
                                                    'no' => 'Norwegian (Norsk)',
                                                    'pl' => 'Polish (Polski)',
                                                    'pt' => 'Portuguese (Portugu&ecirc;s)',
                                                    'pt-BR' => 'Portuguese/Brazilian (Portugu&ecirc;s)',
                                                    'rm' => 'Rhaeto-Romanic (Romansh)',
                                                    'ro' => 'Romanian (Rom&acirc;n&#259;)',
                                                    'ru' => 'Russian (&#1056;&#1091;&#1089;&#1089;&#1082;&#1080;&#1081;)',
                                                    'sr' => 'Serbian (&#1089;&#1088;&#1087;&#1089;&#1082;&#1080; &#1112;&#1077;&#1079;&#1080;&#1082;)',
                                                    'sr-SR' => 'Serbian (srpski jezik)',
                                                    'sk' => 'Slovak (Slovencina)',
                                                    'sl' => 'Slovenian (Slovenski Jezik)',
                                                    'es' => 'Spanish (Espa&ntilde;ol)',
                                                    'sv' => 'Swedish (Svenska)',
                                                    'ta' => 'Tamil (&#2980;&#2990;&#3007;&#2996;&#3021;)',
                                                    'th' => 'Thai (&#3616;&#3634;&#3625;&#3634;&#3652;&#3607;&#3618;)',
                                                    'tj' => 'Tajikistan',
                                                    'tr' => 'Turkish (T&uuml;rk&ccedil;e)',
                                                    'uk' => 'Ukranian (&#1059;&#1082;&#1088;&#1072;&#1111;&#1085;&#1089;&#1100;&#1082;&#1072;)',
                                                    'vi' => 'Vietnamese (Ti&#7871;ng Vi&#7879;t)'
                                                ); ?>
                                                <select id="jqueryui_l10n" name="jqueryui_l10n">
                                                    <?php foreach ($jqueryUiLocales as $key => $label) : ?>
                                                        <option value="<?php echo $key; ?>" <?php selected($form['jqueryui_l10n'], $key); ?>><?php echo $label; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <p class="description"><?php esc_html_e('Choose the calendar localization', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <tr class="ifb-settings-sub-head" valign="top">
                                            <td colspan="2" scope="row"><h3><?php esc_html_e('Labels', 'iphorm'); ?></h3></td>
                                        </tr>
                                        <?php if (!isset($form['label_placement'])) $form['label_placement'] = 'above'; ?>
                                        <tr valign="top">
                                            <th scope="row"><label for="label_placement"><?php esc_html_e('Label placement', 'iphorm'); ?></label></th>
                                            <td>
                                                <select id="label_placement" name="label_placement" onchange="iPhorm.setLabelPlacement();">
                                                    <option value="above" <?php selected($form['label_placement'], 'above'); ?>><?php esc_html_e('Above', 'iphorm'); ?></option>
                                                    <option value="left" <?php selected($form['label_placement'], 'left'); ?>><?php esc_html_e('Left', 'iphorm'); ?></option>
                                                    <option value="inside" <?php selected($form['label_placement'], 'inside'); ?>><?php esc_html_e('Inside', 'iphorm'); ?></option>
                                                </select>
                                                <p class="description"><?php esc_html_e('Choose where to display the label relative to the input', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['label_width'])) $form['label_width'] = '150px'; ?>
                                        <tr valign="top" class="<?php if ($form['label_placement'] !== 'left') echo 'ifb-hidden'; ?> ifb-show-if-label-placement-left">
                                            <th scope="row">
                                                <div class="ifb-tooltip"><div class="ifb-tooltip-content"><?php esc_html_e('Specify how wide the labels should be, this only applies when the label placement is left', 'iphorm'); ?></div></div>
                                                <label for="label_width"><?php esc_html_e('Label width', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <input id="label_width" name="label_width" type="text" value="<?php echo esc_attr($form['label_width']); ?>" />
                                                <p class="description"><?php printf(esc_html__('The width of the labels, any valid CSS width is accepted, e.g. %s200px%s', 'iphorm'), '<span class="ifb-bold">', '</span>'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['required_text'])) $form['required_text'] = __('(required)', 'iphorm'); ?>
                                        <tr valign="top">
                                            <th scope="row"><label for="required_text"><?php esc_html_e('Required indicator text', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="text" id="required_text" name="required_text" onkeyup="iPhorm.updateRequiredText(this);" value="<?php echo esc_attr($form['required_text']); ?>" />
                                            </td>
                                        </tr>
                                        <tr class="ifb-settings-sub-head" valign="top">
                                            <td colspan="2" scope="row"><h3><?php esc_html_e('Tooltips', 'iphorm'); ?></h3></td>
                                        </tr>
                                        <?php if (!isset($form['use_tooltips'])) $form['use_tooltips'] = true; ?>
                                        <tr valign="top">
                                            <th scope="row">
                                                <div class="ifb-tooltip"><div class="ifb-tooltip-content"><?php esc_html_e("What's a tooltip? You're looking at one.", 'iphorm'); ?></div></div>
                                                <label for="use_tooltips"><?php esc_html_e('Enable tooltips', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <input type="checkbox" id="use_tooltips" name="use_tooltips" onclick="iPhorm.toggleTooltipSettings(this.checked);" <?php checked($form['use_tooltips'], true); ?> />
                                                <p class="description"><?php esc_html_e('If enabled, when the user hovers over an element with tooltip text set, a tooltip will appear.', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['tooltip_type'])) $form['tooltip_type'] = 'field'; ?>
                                        <tr valign="top" class="<?php if (!$form['use_tooltips']) echo 'ifb-hidden'; ?> show-if-tooltips-enabled">
                                            <th scope="row">
                                                <div class="ifb-tooltip"><div class="ifb-tooltip-content"><?php printf(esc_html__('If set to %1$sField%2$s, the tooltip will show when the user interacts with
                                                the field. If set to %1$sHelp icon%2$s, the tooltip will be shown when the user interacts with a help icon.', 'iphorm'), '<span class="ifb-bold">', '</span>'); ?></div></div>
                                                <label for="tooltip_type"><?php esc_html_e('Trigger', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <select name="tooltip_type" id="tooltip_type">
                                                    <option value="field" <?php selected($form['tooltip_type'], 'field'); ?>><?php esc_html_e('Field', 'iphorm'); ?></option>
                                                    <option value="icon" <?php selected($form['tooltip_type'], 'icon'); ?>><?php esc_html_e('Help icon', 'iphorm'); ?></option>
                                                </select>
                                                <p class="description"><?php esc_html_e('Choose what the user will be interacting with to show the tooltip.', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['tooltip_event'])) $form['tooltip_event'] = 'hover'; ?>
                                        <tr valign="top" class="<?php if (!$form['use_tooltips']) echo 'ifb-hidden'; ?> show-if-tooltips-enabled">
                                            <th scope="row">
                                                <label for="tooltip_event"><?php esc_html_e('Event', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <select name="tooltip_event" id="tooltip_event">
                                                    <option value="hover" <?php selected($form['tooltip_type'], 'hover'); ?>><?php esc_html_e('Hover', 'iphorm'); ?></option>
                                                    <option value="click" <?php selected($form['tooltip_type'], 'click'); ?>><?php esc_html_e('Click', 'iphorm'); ?></option>
                                                </select>
                                                <p class="description"><?php esc_html_e('Choose the event that will trigger the tooltip to show.', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <tr valign="top" class="<?php if (!$form['use_tooltips']) echo 'ifb-hidden'; ?> show-if-tooltips-enabled">
                                            <th scope="row"><?php esc_html_e('Tooltip style', 'iphorm'); ?></th>
                                            <td>
                                                <table class="ifb-form-table ifb-tooltip-style-subtable">
                                                    <?php if (!isset($form['tooltip_custom'])) $form['tooltip_custom'] = ''; ?>
                                                    <tr valign="top" class="<?php if ($form['tooltip_custom'] === 'custom') echo 'ifb-hidden'; ?> show-if-tooltip-style-previewable">
                                                        <th scope="row" colspan="2">
                                                            <input type="text" id="ifb-tooltip-example" class="ifb-tooltip-example" value="<?php esc_attr_e('Hover me for preview', 'iphorm'); ?>" />
                                                        </th>
                                                    </tr>
                                                    <?php if (!isset($form['tooltip_style'])) $form['tooltip_style'] = 'ui-tooltip-plain'; ?>
                                                    <tr valign="top">
                                                        <th scope="row"><label for="tooltip_style"><?php esc_html_e('Style', 'iphorm'); ?></label></th>
                                                        <td>
                                                            <select id="tooltip_style" name="tooltip_style" onchange="iPhorm.updateTooltipStyle();">
                                                                <optgroup label="CSS2 styles">
                                                                    <option value="ui-tooltip-cream" <?php selected($form['tooltip_style'], 'ui-tooltip-cream'); ?>><?php esc_html_e('Cream', 'iphorm'); ?> (ui-tooltip-cream)</option>
                                                                    <option value="ui-tooltip-plain" <?php selected($form['tooltip_style'], 'ui-tooltip-plain'); ?>><?php esc_html_e('Plain', 'iphorm'); ?> (ui-tooltip-plain)</option>
                                                                    <option value="ui-tooltip-light" <?php selected($form['tooltip_style'], 'ui-tooltip-light'); ?>><?php esc_html_e('Light', 'iphorm'); ?> (ui-tooltip-light)</option>
                                                                    <option value="ui-tooltip-dark" <?php selected($form['tooltip_style'], 'ui-tooltip-dark'); ?>><?php esc_html_e('Dark', 'iphorm'); ?> (ui-tooltip-dark)</option>
                                                                    <option value="ui-tooltip-red" <?php selected($form['tooltip_style'], 'ui-tooltip-red'); ?>><?php esc_html_e('Red', 'iphorm'); ?> (ui-tooltip-red)</option>
                                                                    <option value="ui-tooltip-green" <?php selected($form['tooltip_style'], 'ui-tooltip-green'); ?>><?php esc_html_e('Green', 'iphorm'); ?> (ui-tooltip-green)</option>
                                                                    <option value="ui-tooltip-blue" <?php selected($form['tooltip_style'], 'ui-tooltip-blue'); ?>><?php esc_html_e('Blue', 'iphorm'); ?> (ui-tooltip-blue)</option>
                                                                </optgroup>
                                                                <optgroup label="CSS3 styles">
                                                                    <option value="ui-tooltip-youtube" <?php selected($form['tooltip_style'], 'ui-tooltip-youtube'); ?>><?php esc_html_e('YouTube', 'iphorm'); ?> (ui-tooltip-youtube) </option>
                                                                    <option value="ui-tooltip-jtools" <?php selected($form['tooltip_style'], 'ui-tooltip-jtools'); ?>><?php esc_html_e('jTools', 'iphorm'); ?> (ui-tooltip-jtools)</option>
                                                                    <option value="ui-tooltip-cluetip" <?php selected($form['tooltip_style'], 'ui-tooltip-cluetip'); ?>><?php esc_html_e('Cluetip', 'iphorm'); ?> (ui-tooltip-cluetip)</option>
                                                                    <option value="ui-tooltip-tipped" <?php selected($form['tooltip_style'], 'ui-tooltip-tipped'); ?>><?php esc_html_e('Tipped', 'iphorm'); ?> (ui-tooltip-tipped)</option>
                                                                    <option value="ui-tooltip-tipsy" <?php selected($form['tooltip_style'], 'ui-tooltip-tipsy'); ?>><?php esc_html_e('Tipsy', 'iphorm'); ?> (ui-tooltip-tipsy)</option>
                                                                </optgroup>
                                                                <option value="custom" <?php selected($form['tooltip_style'], 'custom'); ?>><?php esc_html_e('Custom class', 'iphorm'); ?></option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr valign="top" class="<?php if ($form['tooltip_custom'] !== 'custom') echo 'ifb-hidden'; ?> show-if-tooltip-style-custom">
                                                        <th scope="row"><label for="tooltip_custom"><?php esc_html_e('Custom class', 'iphorm'); ?></label></th>
                                                        <td>
                                                            <input type="text" id="tooltip_custom" name="tooltip_custom" value="<?php echo esc_attr($form['tooltip_custom']); ?>" />
                                                        </td>
                                                    </tr>
                                                    <?php if (!isset($form['tooltip_my'])) $form['tooltip_my'] = 'left center'; ?>
                                                    <tr valign="top">
                                                        <th scope="row"><label for="tooltip_my"><?php esc_html_e('Tip position', 'iphorm'); ?></label></th>
                                                        <td>
                                                            <select id="tooltip_my" name="tooltip_my" onchange="iPhorm.updateTooltipStyle();">
                                                                <option value="left center" <?php selected($form['tooltip_my'], 'left center'); ?>><?php esc_html_e('left center', 'iphorm'); ?></option>
                                                                <option value="left top" <?php selected($form['tooltip_my'], 'left top'); ?>><?php esc_html_e('left top', 'iphorm'); ?></option>
                                                                <option value="top left" <?php selected($form['tooltip_my'], 'top left'); ?>><?php esc_html_e('top left', 'iphorm'); ?></option>
                                                                <option value="top center" <?php selected($form['tooltip_my'], 'top center'); ?>><?php esc_html_e('top center', 'iphorm'); ?></option>
                                                                <option value="top right" <?php selected($form['tooltip_my'], 'top right'); ?>><?php esc_html_e('top right', 'iphorm'); ?></option>
                                                                <option value="right top" <?php selected($form['tooltip_my'], 'right top'); ?>><?php esc_html_e('right top', 'iphorm'); ?></option>
                                                                <option value="right center" <?php selected($form['tooltip_my'], 'right center'); ?>><?php esc_html_e('right center', 'iphorm'); ?></option>
                                                                <option value="right bottom" <?php selected($form['tooltip_my'], 'right bottom'); ?>><?php esc_html_e('right bottom', 'iphorm'); ?></option>
                                                                <option value="bottom right" <?php selected($form['tooltip_my'], 'bottom right'); ?>><?php esc_html_e('bottom right', 'iphorm'); ?></option>
                                                                <option value="bottom center" <?php selected($form['tooltip_my'], 'bottom center'); ?>><?php esc_html_e('bottom center', 'iphorm'); ?></option>
                                                                <option value="bottom left" <?php selected($form['tooltip_my'], 'bottom left'); ?>><?php esc_html_e('bottom left', 'iphorm'); ?></option>
                                                                <option value="left bottom" <?php selected($form['tooltip_my'], 'left bottom'); ?>><?php esc_html_e('left bottom', 'iphorm'); ?></option>
                                                                <option value="center" <?php selected($form['tooltip_my'], 'center'); ?>><?php esc_html_e('center', 'iphorm'); ?></option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <?php if (!isset($form['tooltip_at'])) $form['tooltip_at'] = 'right center'; ?>
                                                    <tr valign="top">
                                                        <th scope="row"><label for="tooltip_at"><?php esc_html_e('Position on input', 'iphorm'); ?></label></th>
                                                        <td>
                                                            <select id="tooltip_at" name="tooltip_at" onchange="iPhorm.updateTooltipStyle();">
                                                                <option value="left center" <?php selected($form['tooltip_at'], 'left center'); ?>><?php esc_html_e('left center', 'iphorm'); ?></option>
                                                                <option value="left top" <?php selected($form['tooltip_at'], 'left top'); ?>><?php esc_html_e('left top', 'iphorm'); ?></option>
                                                                <option value="top left" <?php selected($form['tooltip_at'], 'top left'); ?>><?php esc_html_e('top left', 'iphorm'); ?></option>
                                                                <option value="top center" <?php selected($form['tooltip_at'], 'top center'); ?>><?php esc_html_e('top center', 'iphorm'); ?></option>
                                                                <option value="top right" <?php selected($form['tooltip_at'], 'top right'); ?>><?php esc_html_e('top right', 'iphorm'); ?></option>
                                                                <option value="top right" <?php selected($form['tooltip_at'], 'top right'); ?>><?php esc_html_e('right top', 'iphorm'); ?></option>
                                                                <option value="right center" <?php selected($form['tooltip_at'], 'right center'); ?>><?php esc_html_e('right center', 'iphorm'); ?></option>
                                                                <option value="right bottom" <?php selected($form['tooltip_at'], 'right bottom'); ?>><?php esc_html_e('right bottom', 'iphorm'); ?></option>
                                                                <option value="bottom right" <?php selected($form['tooltip_at'], 'bottom right'); ?>><?php esc_html_e('bottom right', 'iphorm'); ?></option>
                                                                <option value="bottom center" <?php selected($form['tooltip_at'], 'bottom center'); ?>><?php esc_html_e('bottom center', 'iphorm'); ?></option>
                                                                <option value="bottom left" <?php selected($form['tooltip_at'], 'bottom left'); ?>><?php esc_html_e('bottom left', 'iphorm'); ?></option>
                                                                <option value="left bottom" <?php selected($form['tooltip_at'], 'left bottom'); ?>><?php esc_html_e('left bottom', 'iphorm'); ?></option>
                                                                <option value="center" <?php selected($form['tooltip_at'], 'center'); ?>><?php esc_html_e('center', 'iphorm'); ?></option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <?php if (!isset($form['tooltip_shadow'])) $form['tooltip_shadow'] = true; ?>
                                                    <tr valign="top">
                                                        <th scope="row"><label for="tooltip_shadow"><?php esc_html_e('CSS3 Shadow', 'iphorm'); ?></label></th>
                                                        <td>
                                                            <input type="checkbox" id="tooltip_shadow" name="tooltip_shadow" onclick="iPhorm.updateTooltipStyle();" <?php checked($form['tooltip_shadow'], true); ?> />
                                                        </td>
                                                    </tr>
                                                    <?php if (!isset($form['tooltip_rounded'])) $form['tooltip_rounded'] = false; ?>
                                                    <tr valign="top">
                                                        <th scope="row"><label for="tooltip_rounded"><?php esc_html_e('CSS3 Rounded Corners', 'iphorm'); ?></label></th>
                                                        <td>
                                                            <input type="checkbox" id="tooltip_rounded" name="tooltip_rounded" onclick="iPhorm.updateTooltipStyle();" <?php checked($form['tooltip_rounded'], true); ?>/>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <p class="description"><?php esc_html_e('The CSS3 effects may not work with some styles and may only be visible in modern browsers.', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <tr class="ifb-settings-sub-head" valign="top">
                                            <td colspan="2" scope="row"><h3><?php esc_html_e('Global styling', 'iphorm'); ?></h3></td>
                                        </tr>
                                        <?php if (!isset($form['element_background_colour'])) $form['element_background_colour'] = ''; ?>
                                        <tr valign="top">
                                            <th scope="row">
                                                <label for="element_background_colour"><?php esc_html_e('Element background color', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <input type="text" id="element_background_colour" name="element_background_colour" value="<?php echo esc_attr($form['element_background_colour']); ?>" />
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['element_border_colour'])) $form['element_border_colour'] = ''; ?>
                                        <tr valign="top">
                                            <th scope="row">
                                                <label for="element_border_colour"><?php esc_html_e('Element border color', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <input type="text" id="element_border_colour" name="element_border_colour" value="<?php echo esc_attr($form['element_border_colour']); ?>" />
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['element_text_colour'])) $form['element_text_colour'] = ''; ?>
                                        <tr valign="top">
                                            <th scope="row">
                                                <label for="element_text_colour"><?php esc_html_e('Element text color', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <input type="text" id="element_text_colour" name="element_text_colour" value="<?php echo esc_attr($form['element_text_colour']); ?>" />
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['label_text_colour'])) $form['label_text_colour'] = ''; ?>
                                        <tr valign="top">
                                            <th scope="row">
                                                <label for="label_text_colour"><?php esc_html_e('Label text color', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <input type="text" id="label_text_colour" name="label_text_colour" value="<?php echo esc_attr($form['label_text_colour']); ?>" />
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['styles'])) $form['styles'] = array(); ?>
                                        <tr valign="top">
                                            <th scope="row">
                                                <div class="ifb-tooltip"><div class="ifb-tooltip-content">
                                                    <?php printf(esc_html__('Styles entered here will apply to all form elements, you can override these for
                                                    each element inside the element settings. Once you have added a style, enter the CSS styles one per line, with each line ending in
                                                    a semi-colon. %sClick here%s for an example.', 'iphorm'), '<a onclick="window.open(this.href); return false;" href="'.iphorm_help_link('element-text#example-styles').'">', '</a>'); ?>
                                                </div></div>
                                                <label><?php esc_html_e('Global CSS Styles', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <div id="ifb-global-styles">
                                                    <?php
                                                        foreach ($form['styles'] as $style)  {
                                                            include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/global-style.php';
                                                        }
                                                    ?>
                                                </div>
                                                <div class="ifb-global-styles-empty ifb-info-message <?php if (count($form['styles'])) echo 'ifb-hidden'; ?>"><span class="ifb-info-message-icon"></span><?php esc_html_e('No global styles.', 'iphorm'); ?></div>
                                            </td>
                                        </tr>
                                        <tr valign="top">
                                            <th scope="row">
                                                <label><?php esc_html_e('Add a style', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The outer wrapper of the form', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('formOuter');"><?php esc_html_e('Form outer wrapper', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The inner wrapper of the form', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('formInner');"><?php esc_html_e('Form inner wrapper', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The message shown when the form is successfully submitted', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('success');"><?php esc_html_e('Success message', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The form title', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('title');"><?php esc_html_e('Form title', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The form description', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('description');"><?php esc_html_e('Form description', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The wrapper surrounding all elements in the form', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('elements');"><?php esc_html_e('Form elements wrapper', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The outer wrapper of each element', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('outer');"><?php esc_html_e('Element outer wrapper', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The label of each element', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('label');"><?php esc_html_e('Element label', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The inner wrapper of each element', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('inner');"><?php esc_html_e('Element inner wrapper', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The description of each element', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('elementDescription');"><?php esc_html_e('Element description', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The input field of Single Line Text, Email, Password and CAPTCHA elements', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('input');"><?php esc_html_e('Text input elements', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The textarea field of Paragraph Text elements', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('textarea');"><?php esc_html_e('Paragraph Text elements', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The select field of Dropdown Menu elements', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('select');"><?php esc_html_e('Dropdown Menu elements', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The wrapper around all of the options of Multiple Choice and Checkbox elements', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('optionUl');"><?php esc_html_e('Options outer wrapper', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The wrapper around each option of Multiple Choice and Checkbox elements', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('optionLi');"><?php esc_html_e('Option wrappers', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The label of each option of Multiple Choice and Checkbox elements', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('optionLabel');"><?php esc_html_e('Option labels', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('Each of the dropdown menus of the Date element', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('date');"><?php esc_html_e('Date dropdowns', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('Each of the dropdown menus of the Time element', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('time');"><?php esc_html_e('Time dropdowns', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The outer wrapper of the submit button', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('submitOuter');"><?php esc_html_e('Submit button outer wrapper', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The inner wrapper of the submit button', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('submit');"><?php esc_html_e('Submit button inner wrapper', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The submit button', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('submitButton');"><?php esc_html_e('Submit button', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The span tag inside the submit button', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('submitSpan');"><?php esc_html_e('Submit button inside span', 'iphorm'); ?></a>
                                                <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The em tag inside the submit button', 'iphorm'); ?>" onclick="iPhorm.addGlobalStyle('submitEm');"><?php esc_html_e('Submit button inside em', 'iphorm'); ?></a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="ifb-tabs-panel" id="ifb-settings-email">
                                    <table class="ifb-form-table ifb-settings-form-table ifb-settings-email-form-table">
                                        <tr class="ifb-settings-sub-head" valign="top">
                                            <td colspan="2" scope="row"><h3><?php esc_html_e('Notification email settings', 'iphorm'); ?></h3></td>
                                        </tr>
                                        <?php if (!isset($form['send_notification'])) $form['send_notification'] = true; ?>
                                        <tr valign="top">
                                            <th scope="row"><label for="send_notification"><?php esc_html_e('Send form data via email', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="checkbox" id="send_notification" name="send_notification" onclick="iPhorm.setSendNotification(this.checked);" <?php if ($form['send_notification']) echo 'checked="checked"'; ?> />
                                                <p class="description"><?php esc_html_e('If checked, when the user submits the form the submitted form data will be sent in an email to the recipients specified below.', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['recipients']) || !count($form['recipients'])) $form['recipients'] = array(get_bloginfo('admin_email')); ?>
                                        <tr valign="top" class="<?php if (!$form['send_notification']) echo 'ifb-hidden'; ?> ifb-show-if-send-notification-on">
                                            <th scope="row">
                                                <div class="ifb-tooltip"><div class="ifb-tooltip-content">
                                                    <?php esc_html_e('Add email address(es) which the submitted form data will be sent to.', 'iphorm'); ?>
                                                </div></div>
                                                <label><?php esc_html_e('Recipients', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <ul id="recipients">
                                                    <?php foreach ($form['recipients'] as $recipient) : ?>
                                                        <li><input name="ifb_recipient_email" type="text" value="<?php echo esc_attr($recipient); ?>" /> <span class="ifb-small-add-button" onclick="iPhorm.addRecipientField(this); return false;">+</span> <span class="ifb-small-delete-button" onclick="iPhorm.removeRecipientField(this); return false;">x</span></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['conditional_recipients'])) $form['conditional_recipients'] = array(); ?>
                                        <tr valign="top" class="<?php if (!$form['send_notification']) echo 'ifb-hidden'; ?> ifb-show-if-send-notification-on">
                                            <th scope="row">
                                                <div class="ifb-tooltip"><div class="ifb-tooltip-content">
                                                    <?php esc_html_e('Send the form data to different email addresses depending on the submitted form values.', 'iphorm'); ?>
                                                </div></div>
                                                <label><?php esc_html_e('Conditional recipients', 'iphorm'); ?></label></th>
                                            <td>
                                                <div id="ifb-add-conditional-recipient" class="clearfix">
                                                    <button class="button" id="ifb-add-conditional-recipient-button" onclick="iPhorm.addConditionalRecipient(); return false;"><?php esc_html_e('Add a new rule', 'iphorm'); ?></button>
                                                    <div id="ifb-conditional-no-valid-elements" class="ifb-info-message"><span class="ifb-info-message-icon"></span><?php esc_html_e('The form must have at least one Dropdown Menu or Multiple Choice element to use this feature.', 'iphorm'); ?></div>
                                                </div>
                                                <div id="ifb-conditional-recipient-list-wrap" class="ifb-hidden">
                                                    <div class="ifb-conditional-heading"><?php esc_html_e('Active rules', 'iphorm'); ?></div>
                                                    <ul id="ifb-conditional-recipient-list"></ul>
                                                    <p class="description"><?php esc_html_e('If the active conditional rules result in no recipients for the email then the recipients specified in the section above will be used.', 'iphorm'); ?></p>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['notification_reply_to_element'])) $form['notification_reply_to_element'] = null; ?>
                                        <tr valign="top" class="<?php if (!$form['send_notification']) echo 'ifb-hidden'; ?> ifb-show-if-send-notification-on">
                                            <th scope="row">
                                                <label for="notification_reply_to_element"><?php esc_html_e('"Reply-To" address', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <div>
                                                    <select class="ifb-show-if-email-element" name="notification_reply_to_element" id="notification_reply_to_element"><?php echo iphorm_email_elements_as_options($form, $form['notification_reply_to_element']); ?></select>
                                                    <div class="ifb-hidden ifb-info-message ifb-show-if-no-email-element"><span class="ifb-info-message-icon"></span><?php echo esc_html_e('The form must have at least one Email Address element to use this feature.', 'iphorm'); ?></div>
                                                </div>
                                                <p class="description ifb-show-if-email-element"><?php esc_html_e('When you compose a reply to the notification email, it will be addressed to the email address submitted in this field.', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['subject'])) $form['subject'] = __('Message from your website', 'iphorm'); ?>
                                        <tr valign="top" class="<?php if (!$form['send_notification']) echo 'ifb-hidden'; ?> ifb-show-if-send-notification-on">
                                            <th scope="row"><label for="subject"><?php esc_html_e('Email subject', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="text" id="subject" name="subject" value="<?php echo esc_attr($form['subject']); ?>" /> <select title="<?php esc_attr_e('Add more data to your email by inserting a variable tag', 'iphorm'); ?>" class="ifb-insert-variable" onchange="iPhorm.insertVariable('#subject', this);"></select>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['customise_email_content'])) $form['customise_email_content'] = false; ?>
                                        <tr valign="top" class="<?php if (!$form['send_notification']) echo 'ifb-hidden'; ?> ifb-show-if-send-notification-on">
                                            <th scope="row"><label for="customise_email_content"><?php esc_html_e('Customize email content', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="checkbox" id="customise_email_content" name="customise_email_content" onclick="iPhorm.toggleCustomiseEmailContent(this.checked);" <?php checked($form['customise_email_content'], true); ?> />
                                                <p class="description"><?php esc_html_e('Tick to customize the email content. By default all submitted form data is sent, you can see an example by submitting the form.' , 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['notification_format'])) $form['notification_format'] = 'plain'; ?>
                                        <?php if (!isset($form['notification_email_content'])) $form['notification_email_content'] = ''; ?>
                                        <tr valign="top" class="<?php if (!$form['customise_email_content']) echo 'ifb-hidden'; ?> ifb-show-if-customise-email-content">
                                            <th scope="row"><label for="notification_email_content"><?php esc_html_e('Email content', 'iphorm'); ?></label></th>
                                            <td>
                                                <div class="ifb-email-content-options">
                                                    <?php esc_html_e('Email format', 'iphorm'); ?>
                                                    <select id="notification_format">
                                                        <option value="plain" <?php selected($form['notification_format'], 'plain'); ?>><?php esc_html_e('Plain text', 'iphorm'); ?></option>
                                                        <option value="html" <?php selected($form['notification_format'], 'html'); ?>><?php esc_html_e('HTML', 'iphorm'); ?></option>
                                                    </select>
                                                    <select title="<?php esc_attr_e('Add more data to your email by inserting a variable tag', 'iphorm'); ?>" class="ifb-insert-variable" onchange="iPhorm.insertVariable('#notification_email_content', this);"></select>
                                                </div>
                                                <textarea id="notification_email_content" name="notification_email_content"><?php echo _wp_specialchars($form['notification_email_content'], ENT_NOQUOTES, false, true);?></textarea>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['notification_from_type'])) $form['notification_from_type'] = 'static'; ?>
                                        <?php if (!isset($form['from_email'])) $form['from_email'] = get_bloginfo('admin_email'); ?>
                                        <?php if (!isset($form['from_name'])) $form['from_name'] = get_bloginfo('name'); ?>
                                        <?php if (!isset($form['notification_from_element'])) $form['notification_from_element'] = null; ?>
                                        <tr valign="top">
                                            <th scope="row">
                                                <div class="ifb-tooltip"><div class="ifb-tooltip-content"><?php esc_html_e('This is the email address that recipient(s) will see as the sender of the email.', 'iphorm'); ?></div></div>
                                                <label for="from_email"><?php esc_html_e('"From" address', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <div class="ifb-notification-from-type-wrap">
                                                    <select id="notification_from_type" name="notification_from_type" onchange="iPhorm.notificationFromTypeChanged();">
                                                        <option value="static" <?php selected('static', $form['notification_from_type']); ?>><?php esc_html_e('Static email address', 'iphorm'); ?></option>
                                                        <option value="element" <?php selected('element', $form['notification_from_type']); ?>><?php esc_html_e('Submitted email address', 'iphorm'); ?></option>
                                                    </select>
                                                </div>
                                                <div class="ifb-notification-from-static <?php if ($form['notification_from_type'] != 'static') echo 'ifb-hidden'; ?>">
                                                    <table class="ifb-from-address-headings">
                                                        <tr>
                                                            <td class="ifb-from-headings-email"><?php esc_html_e('Email address', 'iphorm'); ?></td>
                                                            <td class="ifb-from-headings-name"><?php esc_html_e('Name (optional)', 'iphorm'); ?></td>
                                                        </tr>
                                                    </table>
                                                    <input type="text" id="from_email" name="from_email" value="<?php echo esc_attr($form['from_email']); ?>" /> <input type="text" id="from_name" name="from_name" value="<?php echo esc_attr($form['from_name']); ?>" />
                                                </div>
                                                <div class="ifb-notification-from-element <?php if ($form['notification_from_type'] != 'element') echo 'ifb-hidden'; ?>">
                                                    <select class="ifb-show-if-email-element" name="notification_from_element" id="notification_from_element"><?php echo iphorm_email_elements_as_options($form, $form['notification_from_element']); ?></select>
                                                    <div class="ifb-hidden ifb-info-message ifb-show-if-no-email-element"><span class="ifb-info-message-icon"></span><?php echo esc_html_e('The form must have at least one Email element to use this feature.', 'iphorm'); ?></div>
                                                    <p class="description ifb-show-if-email-element"><?php printf(esc_html__('The From address of the notification email will be set to the email address submitted in this field.
                                                    %sImportant information%s.', 'iphorm'), '<a href="'.iphorm_help_link('settings-email#from-type').'" onclick="window.open(this.href); return false;">', '</a>'); ?></p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="ifb-settings-sub-head" valign="top">
                                            <td colspan="2" scope="row"><h3><?php esc_html_e('Autoreply email settings (optional)', 'iphorm'); ?></h3></td>
                                        </tr>
                                        <?php if (!isset($form['send_autoreply'])) $form['send_autoreply'] = false; ?>
                                        <tr valign="top">
                                            <th scope="row"><label for="send_autoreply"><?php esc_html_e('Send autoreply email', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="checkbox" id="send_autoreply" name="send_autoreply" onclick="iPhorm.setSendAutoreply(this.checked);" <?php checked($form['send_autoreply'], true); ?> />
                                                <p class="description"><?php esc_html_e('If checked, when the user submits the form an autoreply email will be sent to them', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['autoreply_recipient_element'])) $form['autoreply_recipient_element'] = null; ?>
                                        <tr valign="top" class="<?php if (!$form['send_autoreply']) echo 'ifb-hidden'; ?> ifb-show-if-send-autoreply-on">
                                            <th scope="row"><label for="autoreply_recipient_element"><?php esc_html_e('Recipient element', 'iphorm'); ?></label></th>
                                            <td>
                                                <div>
                                                    <select class="ifb-show-if-email-element" id="autoreply_recipient_element" name="autoreply_recipient_element"><?php echo iphorm_email_elements_as_options($form, $form['autoreply_recipient_element']); ?></select>
                                                    <div id="autoreply_recipient_no_email_element" class="ifb-hidden ifb-info-message ifb-show-if-no-email-element"><span class="ifb-info-message-icon"></span><?php echo esc_html_e('The form must have at least one Email Address element to use this feature.', 'iphorm'); ?></div>
                                                </div>
                                                <p class="description ifb-show-if-email-element"><?php esc_html_e('The autoreply email will be sent to the email address submitted in this field.', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['autoreply_subject'])) $form['autoreply_subject'] = ''; ?>
                                        <tr valign="top" class="<?php if (!$form['send_autoreply']) echo 'ifb-hidden'; ?> ifb-show-if-send-autoreply-on">
                                            <th scope="row"><label for="autoreply_subject"><?php esc_html_e('Email subject', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="text" id="autoreply_subject" name="autoreply_subject" value="<?php echo esc_attr($form['autoreply_subject']); ?>" /> <select title="<?php esc_attr_e('Add more data to your email by inserting a variable tag', 'iphorm'); ?>" class="ifb-insert-variable" onchange="iPhorm.insertVariable('#autoreply_subject', this);"></select>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['autoreply_format'])) $form['autoreply_format'] = 'plain'; ?>
                                        <?php if (!isset($form['autoreply_email_content'])) $form['autoreply_email_content'] = ''; ?>
                                        <tr valign="top" class="<?php if (!$form['send_autoreply']) echo 'ifb-hidden'; ?> ifb-show-if-send-autoreply-on">
                                            <th scope="row"><label for="autoreply_email_content"><?php esc_html_e('Email content', 'iphorm'); ?></label></th>
                                            <td>
                                                <div class="ifb-email-content-options">
                                                    <?php esc_html_e('Email format', 'iphorm'); ?>
                                                    <select id="autoreply_format">
                                                        <option value="plain" <?php selected($form['autoreply_format'], 'plain'); ?>><?php esc_html_e('Plain text', 'iphorm'); ?></option>
                                                        <option value="html" <?php selected($form['autoreply_format'], 'html'); ?>><?php esc_html_e('HTML', 'iphorm'); ?></option>
                                                    </select>
                                                    <select title="<?php esc_attr_e('Add more data to your email by inserting a variable tag', 'iphorm'); ?>" class="ifb-insert-variable" onchange="iPhorm.insertVariable('#autoreply_email_content', this);"></select>
                                                </div>
                                                <textarea id="autoreply_email_content" name="autoreply_email_content"><?php echo _wp_specialchars($form['autoreply_email_content'], ENT_NOQUOTES, false, true); ?></textarea>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['autoreply_from_type'])) $form['autoreply_from_type'] = 'static'; ?>
                                        <?php if (!isset($form['autoreply_from_email'])) $form['autoreply_from_email'] = $form['from_email']; ?>
                                        <?php if (!isset($form['autoreply_from_name'])) $form['autoreply_from_name'] = $form['from_name']; ?>
                                        <?php if (!isset($form['autoreply_from_element'])) $form['autoreply_from_element'] = null; ?>
                                        <tr valign="top" class="<?php if (!$form['send_autoreply']) echo 'ifb-hidden'; ?> ifb-show-if-send-autoreply-on">
                                            <th scope="row">
                                                <div class="ifb-tooltip"><div class="ifb-tooltip-content"><?php esc_html_e('This is the email address that recipient will see as the sender of the email.', 'iphorm'); ?></div></div>
                                                <label for="autoreply_from_email"><?php esc_html_e('"From" address', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <div class="ifb-autoreply-from-type-wrap">
                                                    <select id="autoreply_from_type" name="autoreply_from_type" onchange="iPhorm.autoreplyFromTypeChanged();">
                                                        <option value="static" <?php selected('static', $form['autoreply_from_type']); ?>><?php esc_html_e('Static email address', 'iphorm'); ?></option>
                                                        <option value="element" <?php selected('element', $form['autoreply_from_type']); ?>><?php esc_html_e('Submitted email address', 'iphorm'); ?></option>
                                                    </select>
                                                </div>
                                                <div class="ifb-autoreply-from-static <?php if ($form['autoreply_from_type'] != 'static') echo 'ifb-hidden'; ?>">
                                                    <table class="ifb-from-address-headings">
                                                        <tr>
                                                            <td class="ifb-from-headings-email"><?php esc_html_e('Email address', 'iphorm'); ?></td>
                                                            <td class="ifb-from-headings-name"><?php esc_html_e('Name (optional)', 'iphorm'); ?></td>
                                                        </tr>
                                                    </table>
                                                    <input type="text" id="autoreply_from_email" name="autoreply_from_email" value="<?php echo esc_attr($form['autoreply_from_email']); ?>" /> <input type="text" id="autoreply_from_name" name="autoreply_from_name" value="<?php echo esc_attr($form['autoreply_from_name']); ?>" />
                                                </div>
                                                <div class="ifb-autoreply-from-element <?php if ($form['autoreply_from_type'] != 'element') echo 'ifb-hidden'; ?>">
                                                    <select class="ifb-show-if-email-element" name="autoreply_from_element" id="autoreply_from_element"><?php echo iphorm_email_elements_as_options($form, $form['autoreply_from_element']); ?></select>
                                                    <div class="ifb-hidden ifb-info-message ifb-show-if-no-email-element"><span class="ifb-info-message-icon"></span><?php echo esc_html_e('The form must have at least one Email Address element to use this feature.', 'iphorm'); ?></div>
                                                    <p class="description ifb-show-if-email-element"><?php printf(esc_html__('The From address of the autoreply email will be set to the email address submitted in this field.
                                                    %sImportant information%s.', 'iphorm'), '<a href="'.iphorm_help_link('settings-email#autoreply-from-type').'" onclick="window.open(this.href); return false;">', '</a>'); ?></p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="ifb-settings-sub-head" valign="top">
                                            <td colspan="2" scope="row"><h3><?php esc_html_e('Email sending settings', 'iphorm'); ?></h3></td>
                                        </tr>
                                        <?php if (!isset($form['email_sending_method'])) $form['email_sending_method'] = 'global'; ?>
                                        <tr valign="top">
                                            <th scope="row"><label for="email_sending_method"><?php esc_html_e('Email sending method', 'iphorm'); ?></label></th>
                                            <td>
                                                <select id="email_sending_method" name="email_sending_method" onchange="iPhorm.setMailTransport(this);">
                                                    <option value="global" <?php selected($form['email_sending_method'], 'global'); ?>><?php esc_html_e('Use global setting', 'iphorm'); ?></option>
                                                    <option value="mail" <?php selected($form['email_sending_method'], 'mail'); ?>><?php esc_html_e('PHP mail()', 'iphorm'); ?></option>
                                                    <option value="smtp" <?php selected($form['email_sending_method'], 'smtp'); ?>><?php esc_html_e('SMTP', 'iphorm'); ?></option>
                                                </select>
                                                <p class="description"><?php esc_html_e('The global setting can be configured at Quform &rarr; Settings on the WordPress menu.', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['smtp_host'])) $form['smtp_host'] = ''; ?>
                                        <tr valign="top" class="<?php if ($form['email_sending_method'] !== 'smtp') echo 'ifb-hidden'; ?> ifb-show-if-smtp-on">
                                            <th scope="row"><label for="smtp_host"><?php esc_html_e('SMTP host', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="text" name="smtp_host" id="smtp_host" value="<?php echo esc_attr($form['smtp_host']); ?>" />
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['smtp_port'])) $form['smtp_port'] = 25; ?>
                                        <tr valign="top" class="<?php if ($form['email_sending_method'] !== 'smtp') echo 'ifb-hidden'; ?> ifb-show-if-smtp-on">
                                            <th scope="row"><label for="smtp_port"><?php esc_html_e('SMTP port', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="text" name="smtp_port" id="smtp_port" value="<?php echo esc_attr($form['smtp_port']); ?>" />
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['smtp_encryption'])) $form['smtp_encryption'] = ''; ?>
                                        <tr valign="top" class="<?php if ($form['email_sending_method'] !== 'smtp') echo 'ifb-hidden'; ?> ifb-show-if-smtp-on">
                                            <th scope="row"><label for="smtp_encryption"><?php esc_html_e('SMTP encryption', 'iphorm'); ?></label></th>
                                            <td>
                                                <select id="smtp_encryption" name="smtp_encryption">
                                                    <option value="" <?php selected($form['smtp_encryption'], ''); ?>><?php esc_html_e('None', 'iphorm'); ?></option>
                                                    <option value="tls" <?php selected($form['smtp_encryption'], 'tls'); ?>><?php esc_html_e('TLS', 'iphorm'); ?></option>
                                                    <option value="ssl" <?php selected($form['smtp_encryption'], 'ssl'); ?>><?php esc_html_e('SSL', 'iphorm'); ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['smtp_username'])) $form['smtp_username'] = ''; ?>
                                        <tr valign="top" class="<?php if ($form['email_sending_method'] !== 'smtp') echo 'ifb-hidden'; ?> ifb-show-if-smtp-on">
                                            <th scope="row"><label for="smtp_username"><?php esc_html_e('SMTP username', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="text" name="smtp_username" id="smtp_username" value="<?php echo esc_attr($form['smtp_username']); ?>" />
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['smtp_password'])) $form['smtp_password'] = ''; ?>
                                        <tr valign="top" class="<?php if ($form['email_sending_method'] !== 'smtp') echo 'ifb-hidden'; ?> ifb-show-if-smtp-on">
                                            <th scope="row"><label for="smtp_password"><?php esc_html_e('SMTP password', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="text" name="smtp_password" id="smtp_password" value="<?php echo esc_attr($form['smtp_password']); ?>" />
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="ifb-tabs-panel" id="ifb-settings-entries">
                                    <table class="ifb-form-table ifb-settings-form-table ifb-settings-database-form-table">
                                        <tr class="ifb-settings-sub-head" valign="top">
                                            <td colspan="2" scope="row"><h3><?php esc_html_e('Entry settings', 'iphorm'); ?></h3></td>
                                        </tr>
                                        <?php if (!isset($form['save_to_database'])) $form['save_to_database'] = true; ?>
                                        <tr valign="top">
                                            <th scope="row"><label for="save_to_database"><?php esc_html_e('Save submitted form data', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="checkbox" id="save_to_database" name="save_to_database" onclick="iPhorm.toggleSaveToDatabase(this.checked);" <?php checked($form['save_to_database'], true); ?> />
                                                <p class="description"><?php esc_html_e('If checked, the submitted form data will be saved to your database and you will be able
                                                    to view submitted entries within the WordPress admin.', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php
                                            if (!isset($form['entries_table_layout'])) $form['entries_table_layout'] = array();
                                            if (!isset($form['entries_table_layout']['active'])) {
                                                $form['entries_table_layout']['active'] = array(
                                                    array(
                                                        'type' => 'column',
                                                        'label' => __('Date', 'iphorm'),
                                                        'id' => 'date_added'
                                                    )
                                                );
                                            }
                                            if (!isset($form['entries_table_layout']['inactive']))  {
                                                $form['entries_table_layout']['inactive'] = array(
                                                    array(
                                                        'type' => 'column',
                                                        'label' => __('Form URL', 'iphorm'),
                                                        'id' => 'form_url'
                                                    ),
                                                    array(
                                                        'type' => 'column',
                                                        'label' => __('Referring URL', 'iphorm'),
                                                        'id' => 'referring_url'
                                                    ),
                                                    array(
                                                        'type' => 'column',
                                                        'label' => __('Post / Page ID', 'iphorm'),
                                                        'id' => 'post_id'
                                                    ),
                                                    array(
                                                        'type' => 'column',
                                                        'label' => __('Post / Page Title', 'iphorm'),
                                                        'id' => 'post_title'
                                                    ),
                                                    array(
                                                        'type' => 'column',
                                                        'label' => __('User WP display name', 'iphorm'),
                                                        'id' => 'user_display_name'
                                                    ),
                                                    array(
                                                        'type' => 'column',
                                                        'label' => __('User WP login', 'iphorm'),
                                                        'id' => 'user_login'
                                                    ),
                                                    array(
                                                        'type' => 'column',
                                                        'label' => __('User WP email', 'iphorm'),
                                                        'id' => 'user_email'
                                                    )
                                                );
                                            }
                                        ?>
                                        <tr valign="top">
                                            <th scope="row">
                                                <div class="ifb-tooltip"><div class="ifb-tooltip-content"><?php esc_html_e('Customize what is shown in the table when viewing the list of entries for the form. Drag and drop the elements into the desired columns.', 'iphorm'); ?></div></div>
                                                <label><?php esc_html_e('List of entries table layout', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <table class="ifb-form-table ifb-tooltip-style-subtable">
                                                    <tr valign="top" class="ifb-subtable-heading">
                                                        <th><span><?php esc_html_e('Active columns', 'iphorm'); ?></span></th>
                                                        <th><span><?php esc_html_e('Inactive columns', 'iphorm'); ?></span></th>
                                                    </tr>
                                                    <tr valign="top">
                                                        <td>
                                                            <ul id="ifb-active-columns">
                                                                <?php foreach ($form['entries_table_layout']['active'] as $active) : ?>
                                                                    <li><div class="button" data-type="<?php echo esc_attr($active['type']); ?>" data-id="<?php echo esc_attr($active['id']); ?>"><?php echo _wp_specialchars($active['label'], ENT_NOQUOTES, false, true); ?></div></li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </td>
                                                        <td>
                                                            <ul id="ifb-inactive-columns">
                                                                <?php foreach ($form['entries_table_layout']['inactive'] as $inactive) : ?>
                                                                    <li><div class="button" data-type="<?php echo esc_attr($inactive['type']); ?>" data-id="<?php echo esc_attr($inactive['id']); ?>"><?php echo _wp_specialchars($inactive['label'], ENT_NOQUOTES, false, true); ?></div></li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <p class="description"><?php esc_html_e('Customize how the listing table of entries appears for this form. This only
                                                    applies to the list of entries, all entry information will be displayed when viewing an individual entry.', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <tr class="ifb-settings-sub-head" valign="top">
                                            <td colspan="2" scope="row"><h3><?php esc_html_e('Podio Integration', 'iphorm'); ?></h3></td>
                                        </tr>
                                        <?php if (!isset($form['send_to_podio'])) $form['send_to_podio'] = false; ?>
                                        <tr valign="top">
                                            <th scope="row"><label for="send_to_podio"><?php esc_html_e('Send form data to Podio App', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="checkbox" id="send_to_podio" name="send_to_podio" <?php checked($form['send_to_podio'], true); ?> />
                                                <p class="description"><?php esc_html_e('If checked, the submitted form data will be sent to your given Podio App.', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['podio_app_id'])) $form['podio_app_id'] = ''; ?>
                                        <tr valign="top">
                                            <th scope="row">
                                                <div class="ifb-tooltip"><div class="ifb-tooltip-content">
                                                    <?php esc_html_e('Enter the Podio App ID you want your data to be sent to.', 'iphorm'); ?>
                                                </div></div>
                                                <label for="podio_app_id"><?php esc_html_e('Podio App ID', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <input id="podio_app_id" name="podio_app_id" type="text" value="<?php echo esc_attr($form['podio_app_id']); ?>" />
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['podio_app_token'])) $form['podio_app_token'] = ''; ?>
                                        <tr valign="top">
                                            <th scope="row">
                                                <div class="ifb-tooltip"><div class="ifb-tooltip-content">
                                                    <?php esc_html_e('Enter the Podio App Token for authentication purposes.', 'iphorm'); ?>
                                                </div></div>
                                                <label for="podio_app_token"><?php esc_html_e('Podio App Token', 'iphorm'); ?></label>
                                            </th>
                                            <td>
                                                <input id="podio_app_token" name="podio_app_token" type="text" value="<?php echo esc_attr($form['podio_app_token']); ?>" />
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="ifb-tabs-panel" id="ifb-settings-database">
                                    <div class="ifb-settings-database-user-note ifb-info-message"><p><span class="ifb-info-message-icon"></span><?php esc_html_e('This section enables you to save form data to a custom database.
                                        This is not related to the saving of submitted entries, you can do both at the same time.
                                        You can use this functionality to save submitted form data to the table of another
                                        plugin for example.', 'iphorm'); ?></p>
                                        <p><?php esc_html_e('This tool will not create the database table or fields for you - they should already exist. You can
                                        then choose to save a form value using the button below, just enter the name of the database field you would like to
                                        save to and choose your value from the dropdown menu.', 'iphorm'); ?></p>
                                     </div>
                                    <table class="ifb-form-table ifb-settings-form-table ifb-settings-database-form-table">
                                        <tr class="ifb-settings-sub-head" valign="top">
                                            <td colspan="2" scope="row"><h3><?php esc_html_e('Custom database settings (MySQL)', 'iphorm'); ?></h3></td>
                                        </tr>
                                        <?php if (!isset($form['use_wp_db'])) $form['use_wp_db'] = true; ?>
                                        <tr valign="top">
                                            <th scope="row"><label for="use_wp_db"><?php esc_html_e('Use WordPress database', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="checkbox" id="use_wp_db" name="use_wp_db" onclick="iPhorm.toggleUseWpDb(this.checked);" <?php checked($form['use_wp_db'], true); ?> />
                                                <p class="description"><?php esc_html_e('If checked, the data will be inserted into a table you specify below,
                                                inside the WordPress database. Un-tick to specify your own database credentials', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['db_host'])) $form['db_host'] = 'localhost'; ?>
                                        <tr valign="top" class="<?php if ($form['use_wp_db']) echo 'ifb-hidden'; ?> ifb-show-if-not-wpdb">
                                            <th scope="row"><label for="db_host"><?php esc_html_e('Host', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="text" id="db_host" name="db_host" value="<?php echo esc_attr($form['db_host']); ?>" />
                                                <p class="description"><?php esc_html_e('Usually localhost', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['db_username'])) $form['db_username'] = ''; ?>
                                        <tr valign="top" class="<?php if ($form['use_wp_db']) echo 'ifb-hidden'; ?> ifb-show-if-not-wpdb">
                                            <th scope="row"><label for="db_username"><?php esc_html_e('Username', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="text" id="db_username" name="db_username" value="<?php echo esc_attr($form['db_username']); ?>" />
                                                <p class="description"><?php esc_html_e('The user must have permission to insert data to the database', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['db_password'])) $form['db_password'] = ''; ?>
                                        <tr valign="top" class="<?php if ($form['use_wp_db']) echo 'ifb-hidden'; ?> ifb-show-if-not-wpdb">
                                            <th scope="row"><label for="db_password"><?php esc_html_e('Password', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="text" id="db_password" name="db_password" value="<?php echo esc_attr($form['db_password']); ?>" />
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['db_name'])) $form['db_name'] = ''; ?>
                                        <tr valign="top" class="<?php if ($form['use_wp_db']) echo 'ifb-hidden'; ?> ifb-show-if-not-wpdb">
                                            <th scope="row"><label for="db_name"><?php esc_html_e('Database name', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="text" id="db_name" name="db_name" value="<?php echo esc_attr($form['db_name']); ?>" />
                                            </td>
                                        </tr>
                                        <?php if (!isset($form['db_table'])) $form['db_table'] = ''; ?>
                                        <tr valign="top">
                                            <th scope="row"><label for="db_table"><?php esc_html_e('Database table', 'iphorm'); ?></label></th>
                                            <td>
                                                <input type="text" id="db_table" name="db_table" value="<?php echo esc_attr($form['db_table']); ?>" />
                                                <p class="description"><?php esc_html_e('The name of the database table to insert the data into', 'iphorm'); ?></p>
                                            </td>
                                        </tr>
                                        <tr class="ifb-settings-sub-head" valign="top">
                                            <td colspan="2" scope="row"><h3><?php esc_html_e('What to save', 'iphorm'); ?></h3></td>
                                        </tr>
                                        <?php if (!isset($form['db_fields'])) $form['db_fields'] = array(); ?>
                                        <tr valign="top">
                                            <td scope="row">
                                                <div class="ifb-add-db-field-wrap">
                                                    <a class="button" onclick="iPhorm.addDbField();"><?php esc_html_e('Save another form value', 'iphorm'); ?></a>
                                                </div>
                                            </td>
                                            <td>
                                                <table id="db_fields_headings" class="ifb-hidden">
                                                    <tr>
                                                        <td><?php esc_html_e('Database field', 'iphorm'); ?></td>
                                                        <td><?php esc_html_e('Value', 'iphorm'); ?></td>
                                                    </tr>
                                                </table>
                                                <ul id="db_fields" class="ifb-hidden"></ul>
                                                <div id="db_fields_empty" class="ifb-info-message"><span class="ifb-info-message-icon"></span><?php esc_html_e('You are not currently saving any submitted form values.', 'iphorm'); ?></div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                       </div>
                    </div>
                    <div class="ifb-buttons clearfix">
                        <a class="ifb-grey" onclick="iPhorm.preview(); return false;"><?php esc_html_e('Preview', 'iphorm'); ?></a>
                        <a class="ifb-blue" onclick="iPhorm.saveForm(this, '<?php echo wp_create_nonce('iphorm_save_form'); ?>'); return false;">
                            <span class="ifb-save"><?php esc_attr_e('Save', 'iphorm'); ?></span>
                            <span class="ifb-saving"></span>
                            <span class="ifb-saved"></span>
                            <span class="ifb-save-failed"></span>
                        </a>
                        <a id="ifb-scroll-top"><?php esc_html_e('Top', 'iphorm'); ?></a>
                    </div>
                </div> <!-- /.ifb-left-col -->
            </div>
        </div>
        </form>
        <script type="text/javascript">
        //<![CDATA[
            jQuery(document).ready(function () {
                iPhorm.init(<?php echo iphorm_json_encode($form); ?>);
            });
        //]]>
        </script>
    <?php else : ?>
        <?php echo '<div class="iphorm-admin-notice iphorm-admin-notice-no-form error"><p><strong>' . sprintf(esc_html__('The form with that ID does not exist, %sgo back to the form list%s.', 'iphorm'), '<a href="' . admin_url('admin.php?page=iphorm_forms') . '">', '</a>') . '</strong></p></div>'; ?>
    <?php endif; ?>
</div>