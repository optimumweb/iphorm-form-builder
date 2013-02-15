<?php
if (!defined('IPHORM_VERSION')) exit;
$id = absint($element['id']);

if (!isset($element['label'])) $element['label'] = __('Untitled', 'iphorm');
if (!isset($element['description'])) $element['description'] = '';
if (!isset($element['required'])) $element['required'] = false;
if (!isset($element['default_value'])) $element['default_value'] = '';
$helpUrl = iphorm_help_link('element-textarea');
?>
<div id="ifb-element-wrap-<?php echo $id; ?>" class="ifb-element-wrap ifb-element-wrap-textarea <?php if (!$element['required']) echo 'ifb-element-optional'; ?> <?php echo "ifb-label-placement-{$form['label_placement']}"; ?>">
	<div class="ifb-top-element-wrap clearfix">
        <?php include IPHORM_ADMIN_INCLUDES_DIR . '/elements/_actions.php'; ?>
        <div class="ifb-element-preview ifb-element-preview-textarea">
            <label class="ifb-preview-label <?php if (!strlen($element['label'])) echo 'ifb-hidden'; ?>" for="ifb_element_<?php echo $id; ?>"><span class="ifb-preview-label-content"><?php echo $element['label']; ?></span><span class="ifb-required"><?php echo esc_html($form['required_text']); ?></span></label>
            <div class="ifb-preview-input">
                <textarea name="ifb_element_<?php echo $id; ?>" id="ifb_element_<?php echo $id; ?>" disabled="disabled"><?php echo esc_html($element['default_value']); ?></textarea>
                <p class="ifb-preview-description <?php if (!strlen($element['description'])) echo 'ifb-hidden'; ?>"><?php echo $element['description']; ?></p>
            </div>
            <span class="ifb-handle"></span>
        </div>
    </div>
    <div class="ifb-element-settings ifb-element-settings-textarea">
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
                        <?php include 'settings/required.php'; ?>
                        <?php include 'settings/tooltip.php'; ?>
                        <?php include '_save.php'; ?>
                    </table>
                </div>
            </div>
            <div class="ifb-tabs-panel" id="ifb-element-settings-tab-more-<?php echo $id; ?>">
                <div class="ifb-element-settings-inner">
                    <table class="ifb-form-table ifb-element-settings-form-table ifb-element-settings-more-form-table">
						<tr valign="top">
						    <th scope="row">
						        <div class="ifb-tooltip"><div class="ifb-tooltip-content">
						            <?php esc_html_e('The default value is the value that the element is given before
						            the user has entered anything', 'iphorm'); ?>
						        </div></div>
						        <label for="default_value_<?php echo $id; ?>"><?php esc_html_e('Default value', 'iphorm'); ?></label>
						    </th>
						    <td>
                                <?php include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/_insert-variable-preprocess.php'; ?>
						        <textarea class="ifb-textarea-default-value" id="default_value_<?php echo $id; ?>" name="default_value_<?php echo $id; ?>"
						          onfocus="iPhorm.updateDefaultValue(this, iPhorm.getElementById(<?php echo $id; ?>));"
						          onblur="iPhorm.updateDefaultValue(this, iPhorm.getElementById(<?php echo $id; ?>));"
						          onkeyup="iPhorm.updateDefaultValue(this, iPhorm.getElementById(<?php echo $id; ?>));"><?php echo esc_html($element['default_value']); ?></textarea>
						    </td>
						</tr>
                        <?php include 'settings/clear-default-value.php'; ?>
                        <?php include 'settings/admin-label.php'; ?>
                        <?php include 'settings/required-message.php'; ?>
                        <?php include 'settings/hide-from-email.php'; ?>
                        <?php include 'settings/save-to-database.php'; ?>
                        <?php include 'settings/label-placement.php'; ?>
                        <?php include 'settings/tooltip-type.php'; ?>
                        <?php include 'settings/prevent-duplicates.php'; ?>
                        <?php include 'settings/conditional-logic.php'; ?>
                        <?php include 'settings/dynamic-default-value.php'; ?>
                        <?php include '_save.php'; ?>
                    </table>
                </div>
            </div>
            <div class="ifb-tabs-panel" id="ifb-element-settings-tab-advanced-<?php echo $id; ?>">
                <div class="ifb-element-settings-inner">
                    <table class="ifb-form-table ifb-element-settings-form-table ifb-element-settings-advanced-form-table">
                        <?php include 'settings/styles.php'; ?>
                        <?php include 'settings/selectors.php'; ?>
                        <?php include 'settings/filters.php'; ?>
                        <?php include 'settings/validators.php'; ?>
                        <?php include '_save.php'; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>