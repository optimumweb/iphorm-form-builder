<?php
if (!defined('IPHORM_VERSION')) exit;
$id = absint($element['id']);

if (!isset($element['required'])) $element['required'] = true;
if (!isset($element['label'])) $element['label'] = __('Type the words', 'iphorm');
if (!isset($element['description'])) $element['description'] = '';
if (!isset($element['recaptcha_theme'])) $element['recaptcha_theme'] = 'red';
$helpUrl = iphorm_help_link('element-recaptcha');
?>
<div id="ifb-element-wrap-<?php echo $id; ?>" class="ifb-element-wrap ifb-element-wrap-recaptcha <?php echo "ifb-label-placement-{$form['label_placement']}"; ?>">
	<div class="ifb-top-element-wrap clearfix">
        <?php include IPHORM_ADMIN_INCLUDES_DIR . '/elements/_actions.php'; ?>
        <div class="ifb-element-preview ifb-element-preview-recaptcha">
            <?php if (get_option('iphorm_recaptcha_private_key') == null || get_option('iphorm_recaptcha_public_key') == null) : ?>
                <div class="ifb-recaptcha-empty ifb-info-message"><span class="ifb-info-message-icon"></span><?php printf(esc_html__('You must enter your reCAPTCHA API keys on the %sQuform settings page%s to use this element.', 'iphorm'), '<a href="' . admin_url('admin.php?page=iphorm_settings') . '">', '</a>'); ?></div>
            <?php else : ?>
                <label class="ifb-preview-label <?php if (!strlen($element['label'])) echo 'ifb-hidden'; ?>"><span class="ifb-preview-label-content"><?php echo $element['label']; ?></span><span class="ifb-required"><?php echo esc_html($form['required_text']); ?></span></label>
                <div id="ifb_element_<?php echo $id; ?>" class="ifb-preview-input">
                    <img class="ifb-recaptcha-sample ifb-recaptcha-sample-red<?php if ($element['recaptcha_theme'] != 'red') echo ' ifb-hidden'; ?>" src="<?php echo IPHORM_ADMIN_URL . '/images/reCAPTCHA_Sample_Red.png' ?>" alt="" />
                    <img class="ifb-recaptcha-sample ifb-recaptcha-sample-white<?php if ($element['recaptcha_theme'] != 'white') echo ' ifb-hidden'; ?>" src="<?php echo IPHORM_ADMIN_URL . '/images/reCAPTCHA_Sample_White.png' ?>" alt="" />
                    <img class="ifb-recaptcha-sample ifb-recaptcha-sample-black<?php if ($element['recaptcha_theme'] != 'blackglass') echo ' ifb-hidden'; ?>" src="<?php echo IPHORM_ADMIN_URL . '/images/reCAPTCHA_Sample_Black.png' ?>" alt="" />
                    <img class="ifb-recaptcha-sample ifb-recaptcha-sample-clean<?php if ($element['recaptcha_theme'] != 'clean') echo ' ifb-hidden'; ?>" src="<?php echo IPHORM_ADMIN_URL . '/images/reCAPTCHA_Sample_Clean.png' ?>" alt="" />
                    <p class="ifb-preview-description <?php if (!strlen($element['description'])) echo 'ifb-hidden'; ?>"><?php echo $element['description']; ?></p>
                </div>
            <?php endif; ?>
            <span class="ifb-handle"></span>
        </div>
    </div>
    <div class="ifb-element-settings ifb-element-settings-recaptcha">
        <div class="ifb-element-settings-tabs" id="ifb-element-settings-tabs-<?php echo $id; ?>">
            <ul class="ifb-tabs-nav">
                <li><a href="#ifb-element-settings-tab-settings-<?php echo $id; ?>"><?php esc_html_e('Settings', 'iphorm'); ?></a></li>
                <li><a href="#ifb-element-settings-tab-more-<?php echo $id; ?>"><?php esc_html_e('Optional', 'iphorm'); ?></a></li>
                <li><a href="#ifb-element-settings-tab-advanced-<?php echo $id; ?>"><?php esc_html_e('Advanced', 'iphorm'); ?></a></li>
            </ul>
            <div class="ifb-tabs-panel" id="ifb-element-settings-tab-settings-<?php echo $id; ?>">
                <div class="ifb-element-settings-inner">
                    <table class="ifb-form-table ifb-element-settings-form-table ifb-element-settings-settings-form-table">
                        <?php include 'settings/label.php'; ?>
                        <?php include 'settings/description.php'; ?>
                        <tr valign="top">
                            <th scope="row"><label for="recaptcha_theme_<?php echo $id; ?>"><?php esc_html_e('Theme', 'iphorm'); ?></label></th>
                            <td>
                                <select id="recaptcha_theme_<?php echo $id; ?>" name="recaptcha_theme_<?php echo $id; ?>" onchange="iPhorm.setRecaptchaTheme(iPhorm.getElementById(<?php echo $id; ?>), this);">
                                    <option value="red" <?php selected($element['recaptcha_theme'], 'red'); ?>>Red</option>
                                    <option value="white" <?php selected($element['recaptcha_theme'], 'white'); ?>>White</option>
                                    <option value="blackglass" <?php selected($element['recaptcha_theme'], 'blackglass'); ?>>Black Glass</option>
                                    <option value="clean" <?php selected($element['recaptcha_theme'], 'clean'); ?>>Clean</option>
                                </select>
                            </td>
                        </tr>
                        <?php
                        if (!isset($element['recaptcha_lang'])) $element['recaptcha_lang'] = 'en';
                        $langs = array(
                            'en' => __('English', 'iphorm'),
                            'nl' => __('Dutch', 'iphorm'),
                            'fr' => __('French', 'iphorm'),
                            'de' => __('German', 'iphorm'),
                            'pt' => __('Portuguese', 'iphorm'),
                            'ru' => __('Russian', 'iphorm'),
                            'es' => __('Spanish', 'iphorm'),
                            'tr' => __('Turkish', 'iphorm')
                        );
                        ?>
                        <tr valign="top">
                            <th scope="row"><label for="recaptcha_lang_<?php echo $id; ?>"><?php esc_html_e('Language', 'iphorm'); ?></label></th>
                            <td>
                                <select id="recaptcha_lang_<?php echo $id; ?>" name="recaptcha_lang_<?php echo $id; ?>">
                                    <?php foreach ($langs as $key => $lang) : ?>
                                        <option value="<?php echo esc_attr($key); ?>" <?php selected($element['recaptcha_lang'], $key); ?>><?php echo esc_html($lang); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <?php include 'settings/tooltip.php'; ?>
                        <?php include '_save.php'; ?>
                    </table>
                </div>
            </div>
            <div class="ifb-tabs-panel" id="ifb-element-settings-tab-more-<?php echo $id; ?>">
                <div class="ifb-element-settings-inner">
                    <table class="ifb-form-table ifb-element-settings-form-table ifb-element-settings-more-form-table">
                        <?php include 'settings/required-message.php'; ?>
                        <?php include 'settings/label-placement.php'; ?>
                        <?php include 'settings/tooltip-type.php'; ?>
                        <?php include 'settings/conditional-logic.php'; ?>
                    </table>
                    <h3 class="ifb-translate-h3"><?php esc_html_e('Translate error messages', 'iphorm'); ?></h3>
                    <table class="ifb-form-table translate-error-messages-table">
                        <?php
                            if (!isset($element['messages'])) $element['messages'] = array();

                            // key => tooltip
                            $customisableMessages = array(
                                'invalid-site-private-key' => '',
                                'invalid-request-cookie' => '',
                                'incorrect-captcha-sol' => '',
                                'recaptcha-not-reachable' => ''
                            );

                            foreach ($customisableMessages as $key => $tooltip) {
                                if (!isset($element['messages'][$key])) {
                                    $element['messages'][$key] = '';
                                }
                            }

                            $recaptchaValidator = new iPhorm_Validator_Recaptcha();
                        ?>
                        <tr valign="top">
                            <th><?php esc_html_e('Default', 'iphorm'); ?></th>
                            <th><?php esc_html_e('Translation', 'iphorm'); ?></th>
                        </tr>
                        <?php foreach ($customisableMessages as $key => $tooltip) : ?>
                            <tr valign="top">
                                <th scope="row">
                                    <label for="<?php echo $key; ?>_<?php echo $id; ?>"><?php echo esc_html($recaptchaValidator->getMessageTemplate($key)); ?></label>
                                </th>
                                <td>
                                    <input type="text" id="<?php echo $key; ?>_<?php echo $id; ?>" name="<?php echo $key; ?>_<?php echo $id; ?>" value="<?php echo (isset($element['messages'][$key])) ? esc_attr($element['messages'][$key]) : ''; ?>" />
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php include '_save.php'; ?>
                    </table>
                </div>
            </div>
            <div class="ifb-tabs-panel" id="ifb-element-settings-tab-advanced-<?php echo $id; ?>">
                <div class="ifb-element-settings-inner">
                    <table class="ifb-form-table ifb-element-settings-form-table ifb-element-settings-advanced-form-table">
                        <?php include 'settings/styles.php'; ?>
                        <?php include 'settings/selectors.php'; ?>
                        <?php include '_save.php'; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>