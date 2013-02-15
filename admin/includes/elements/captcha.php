<?php
if (!defined('IPHORM_VERSION')) exit;
$id = absint($element['id']);

if (!isset($element['required'])) $element['required'] = true;
if (!isset($element['label'])) $element['label'] = __('Type the characters', 'iphorm');
if (!isset($element['description'])) $element['description'] = '';

if (!isset($element['options'])) $element['options'] = array();
if (!isset($element['options']['length'])) $element['options']['length'] = 5;
if (!isset($element['options']['width'])) $element['options']['width'] = 115;
if (!isset($element['options']['height'])) $element['options']['height'] = 40;
if (!isset($element['options']['bgColour'])) $element['options']['bgColour'] = '#FFFFFF';
if (!isset($element['options']['textColour'])) $element['options']['textColour'] = '#222222';
if (!isset($element['options']['font'])) $element['options']['font'] = 'Typist.ttf';
if (!isset($element['options']['minFontSize'])) $element['options']['minFontSize'] = 12;
if (!isset($element['options']['maxFontSize'])) $element['options']['maxFontSize'] = 19;
if (!isset($element['options']['minAngle'])) $element['options']['minAngle'] = 0;
if (!isset($element['options']['maxAngle'])) $element['options']['maxAngle'] = 20;

$captchaImagePath = IPHORM_PLUGIN_URL . '/includes/captcha.php';
$captchaConfig = array(
    'uniqId' => 1,
    'tmpDir' => iphorm_get_temp_dir(),
    'options' => $element['options']
);

$captchaConfig = base64_encode(iphorm_json_encode($captchaConfig));
$helpUrl = iphorm_help_link('element-captcha');
?>
<div id="ifb-element-wrap-<?php echo $id; ?>" class="ifb-element-wrap ifb-element-wrap-captcha <?php if (!$element['required']) echo 'ifb-element-optional'; ?> <?php echo "ifb-label-placement-{$form['label_placement']}"; ?>">
	<div class="ifb-top-element-wrap clearfix">
        <?php include IPHORM_ADMIN_INCLUDES_DIR . '/elements/_actions.php'; ?>
        <div class="ifb-element-preview ifb-element-preview-captcha">
            <label class="ifb-preview-label <?php if (!strlen($element['label'])) echo 'ifb-hidden'; ?>" for="ifb_element_<?php echo $id; ?>"><span class="ifb-preview-label-content"><?php echo $element['label']; ?></span><span class="ifb-required"><?php echo esc_html($form['required_text']); ?></span></label>
            <div class="ifb-preview-input">
                <input type="text" name="ifb_element_<?php echo $id; ?>" id="ifb_element_<?php echo $id; ?>" disabled="disabled" />
                <p class="ifb-preview-description <?php if (!strlen($element['description'])) echo 'ifb-hidden'; ?>"><?php echo $element['description']; ?></p>
            </div>
            <div class="ifb-captcha-preview-image-wrap clearfix">
                <div class="ifb-captcha-preview-image-inner">
                    <img class="ifb-captcha-preview-image" id="ifb_captcha_<?php echo $id; ?>" src="<?php echo $captchaImagePath . '?c=' . $captchaConfig . '&amp;t=' . microtime(true); ?>" onclick="iPhorm.refreshCaptchaPreview(iPhorm.getElementById(<?php echo $id; ?>));" />
                </div>
            </div>
            <span class="ifb-handle"></span>
        </div>
    </div>
    <div class="ifb-element-settings ifb-element-settings-captcha">
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
                        <?php include 'settings/tooltip.php'; ?>
                        <tr valign="top">
                            <th scope="row"><label><?php esc_html_e('Number of characters', 'iphorm'); ?></label></th>
                            <td><input class="ifb-small-input" type="text" id="length_<?php echo $id; ?>" name="length_<?php echo $id; ?>" value="<?php echo esc_attr($element['options']['length']); ?>" onkeyup="iPhorm.refreshCaptchaPreview(iPhorm.getElementById(<?php echo $id; ?>));"></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label><?php esc_html_e('Width (pixels)', 'iphorm'); ?></label></th>
                            <td><input class="ifb-small-input" type="text" id="width_<?php echo $id; ?>" name="width_<?php echo $id; ?>" value="<?php echo esc_attr($element['options']['width']); ?>" onkeyup="iPhorm.refreshCaptchaPreview(iPhorm.getElementById(<?php echo $id; ?>));"></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label><?php esc_html_e('Height (pixels)', 'iphorm'); ?></label></th>
                            <td><input class="ifb-small-input" type="text" id="height_<?php echo $id; ?>" name="height_<?php echo $id; ?>" value="<?php echo esc_attr($element['options']['height']); ?>" onkeyup="iPhorm.refreshCaptchaPreview(iPhorm.getElementById(<?php echo $id; ?>));"></td>
                        </tr>
                        <tr valign="top" class="ifb-captcha-bg-colour">
                            <th scope="row"><label><?php esc_html_e('Background color', 'iphorm'); ?></label></th>
                            <td>
                                <input type="text" id="bg_colour_<?php echo $id; ?>" name="bg_colour_<?php echo $id; ?>" value="<?php echo esc_attr($element['options']['bgColour']); ?>" onkeyup="iPhorm.refreshCaptchaPreview(iPhorm.getElementById(<?php echo $id; ?>));">
                            </td>
                        </tr>
                        <tr valign="top" class="ifb-captcha-text-colour">
                            <th scope="row"><label><?php esc_html_e('Text color', 'iphorm'); ?></label></th>
                            <td><input type="text" id="text_colour_<?php echo $id; ?>" name="text_colour_<?php echo $id; ?>" value="<?php echo esc_attr($element['options']['textColour']); ?>" onkeyup="iPhorm.refreshCaptchaPreview(iPhorm.getElementById(<?php echo $id; ?>));"></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label><?php esc_html_e('Font', 'iphorm'); ?></label></th>
                            <td>
                                <select id="font_<?php echo $id; ?>" name="font_<?php echo $id; ?>" onchange="iPhorm.refreshCaptchaPreview(iPhorm.getElementById(<?php echo $id; ?>));">
                                    <option value="Base_02.ttf" <?php selected('Base_02.ttf', $element['options']['font']); ?>>Base 02</option>
                                    <option value="coolvetica_rg.ttf" <?php selected('coolvetica_rg.ttf', $element['options']['font']); ?>>Coolvetica</option>
                                    <option value="Diesel.ttf" <?php selected('Diesel.ttf', $element['options']['font']); ?>>Diesel</option>
                                    <option value="Dirty_Ego.ttf" <?php selected('Dirty_Ego.ttf', $element['options']['font']); ?>>Dirty Ego</option>
                                    <option value="Distress.ttf" <?php selected('Distress.ttf', $element['options']['font']); ?>>Distress</option>
                                    <option value="Dotmatrix_5.ttf" <?php selected('Dotmatrix_5.ttf', $element['options']['font']); ?>>Dotmatrix 5</option>
                                    <option value="DS_Moster.ttf" <?php selected('DS_Moster.ttf', $element['options']['font']); ?>>DS Moster</option>
                                    <option value="Phinster.ttf" <?php selected('Phinster.ttf', $element['options']['font']); ?>>Phinster</option>
                                    <option value="Rolling_Stone.ttf" <?php selected('Rolling_Stone.ttf', $element['options']['font']); ?>>Rolling Stone</option>
                                    <option value="Sabotage.ttf" <?php selected('Sabotage.ttf', $element['options']['font']); ?>>Sabotage</option>
                                    <option value="Sketch_Heavy.ttf" <?php selected('Sketch_Heavy.ttf', $element['options']['font']); ?>>Sketch Heavy</option>
                                    <option value="Typist.ttf" <?php selected('Typist.ttf', $element['options']['font']); ?>>Typist</option>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <div class="ifb-tooltip"><div class="ifb-tooltip-content">
                                    <?php esc_html_e('The font size for each character will be randomly chosen between the minimum and maximum.', 'iphorm'); ?>
                                </div></div>
                                <label><?php esc_html_e('Minimum font size', 'iphorm'); ?></label>
                            </th>
                            <td><input class="ifb-small-input" type="text" id="min_font_size_<?php echo $id; ?>" name="min_font_size_<?php echo $id; ?>" value="<?php echo esc_attr($element['options']['minFontSize']); ?>" onkeyup="iPhorm.refreshCaptchaPreview(iPhorm.getElementById(<?php echo $id; ?>));"></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <div class="ifb-tooltip"><div class="ifb-tooltip-content">
                                    <?php esc_html_e('The font size for each character will be randomly chosen between the minimum and maximum.', 'iphorm'); ?>
                                </div></div>
                                <label><?php esc_html_e('Maximum font size', 'iphorm'); ?></label></th>
                            <td><input class="ifb-small-input" type="text" id="max_font_size_<?php echo $id; ?>" name="max_font_size_<?php echo $id; ?>" value="<?php echo esc_attr($element['options']['maxFontSize']); ?>" onkeyup="iPhorm.refreshCaptchaPreview(iPhorm.getElementById(<?php echo $id; ?>));"></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <div class="ifb-tooltip"><div class="ifb-tooltip-content">
                                    <?php esc_html_e('The angle for each character will be randomly chosen between the minimum and maximum.', 'iphorm'); ?>
                                </div></div>
                                <label><?php esc_html_e('Minimum letter rotation (degrees)', 'iphorm'); ?></label></th>
                            <td><input class="ifb-small-input" type="text" id="min_angle_<?php echo $id; ?>" name="min_angle_<?php echo $id; ?>" value="<?php echo esc_attr($element['options']['minAngle']); ?>" onkeyup="iPhorm.refreshCaptchaPreview(iPhorm.getElementById(<?php echo $id; ?>));"></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <div class="ifb-tooltip"><div class="ifb-tooltip-content">
                                    <?php esc_html_e('The angle for each character will be randomly chosen between the minimum and maximum.', 'iphorm'); ?>
                                </div></div>
                                <label><?php esc_html_e('Maximum letter rotation (degrees)', 'iphorm'); ?></label></th>
                            <td><input class="ifb-small-input" type="text" id="max_angle_<?php echo $id; ?>" name="max_angle_<?php echo $id; ?>" value="<?php echo esc_attr($element['options']['maxAngle']); ?>" onkeyup="iPhorm.refreshCaptchaPreview(iPhorm.getElementById(<?php echo $id; ?>));"></td>
                        </tr>
                        <?php include '_save.php'; ?>
                    </table>
                    <script type="text/javascript">
                    //<![CDATA[
                        jQuery(document).ready(function ($) {
                            $('#bg_colour_<?php echo $id; ?>, #text_colour_<?php echo $id; ?>').ColorPicker({
                                onSubmit: function(hsb, hex, rgb, el) {
                                    $(el).val('#' + hex);
                                    $(el).ColorPickerHide();
                                },
                                onBeforeShow: function () {
                                    $(this).ColorPickerSetColor(this.value);
                                },
                                onChange: function (hsb, hex, rgb) {
                                    $($(this).data('colorpicker').el).val('#'+hex);
                                },
                                onHide: function () {
                                	iPhorm.refreshCaptchaPreview(iPhorm.getElementById(<?php echo $id; ?>));
                                }
                            })
                            .bind('keyup', function(){
                                $(this).ColorPickerSetColor(this.value);
                            });

                            $('#ifb_captcha_<?php echo $id; ?>').hover(function () {
                                $(this).stop().fadeTo('slow', '0.3');
                            }, function () {
                                $(this).stop().fadeTo('slow', '1.0');
                            });
                        });
                    //]]>
                    </script>
                </div>
            </div>
            <div class="ifb-tabs-panel" id="ifb-element-settings-tab-more-<?php echo $id; ?>">
                <div class="ifb-element-settings-inner">
                    <table class="ifb-form-table ifb-element-settings-form-table ifb-element-settings-more-form-table">
                        <?php include 'settings/required-message.php'; ?>
                        <?php
                            if (!isset($element['invalid_message'])) $element['invalid_message'] = '';
                            $captchaValidator = new iPhorm_Validator_Captcha();
                        ?>
                        <tr valign="top">
                            <th scope="row"><label for="invalid_message_<?php echo $id; ?>"><?php esc_html_e('Error message if invalid', 'iphorm'); ?></label></th>
                            <td>
                                <input type="text" id="invalid_message_<?php echo $id; ?>" name="invalid_message_<?php echo $id; ?>" value="<?php echo esc_attr($element['invalid_message']); ?>" />
                                <p class="description"><?php printf(esc_html__('Translate or override the error message shown under the field
                                when the given solution does not match. The default is "%s".', 'iphorm'), '<span class="ifb-bold">' . $captchaValidator->getMessageTemplate('not_match')) . '</span>'; ?></p>
                            </td>
                        </tr>
                        <?php include 'settings/label-placement.php'; ?>
                        <?php include 'settings/tooltip-type.php'; ?>
                        <?php include 'settings/conditional-logic.php'; ?>
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