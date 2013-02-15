<?php
if (!defined('IPHORM_VERSION')) exit;
$id = absint($element['id']);

if (!isset($element['label'])) $element['label'] = __('Untitled', 'iphorm');
if (!isset($element['description'])) $element['description'] = '';
if (!isset($element['required'])) $element['required'] = false;
if (!isset($element['default_value'])) $element['default_value'] = array();
if (!isset($element['options'])) {
    $element['options'] = array(
        array('value' => __('Option 1', 'iphorm'), 'label' => __('Option 1', 'iphorm')),
        array('value' => __('Option 2', 'iphorm'), 'label' => __('Option 2', 'iphorm')),
        array('value' => __('Option 3', 'iphorm'), 'label' => __('Option 3', 'iphorm'))
    );
}
$helpUrl = iphorm_help_link('element-select');
?>
<div id="ifb-element-wrap-<?php echo $id; ?>" class="ifb-element-wrap ifb-element-wrap-select <?php if (!$element['required']) echo 'ifb-element-optional'; ?> <?php echo "ifb-label-placement-{$form['label_placement']}"; ?>">
	<div class="ifb-top-element-wrap clearfix">
        <?php include IPHORM_ADMIN_INCLUDES_DIR . '/elements/_actions.php'; ?>
        <div class="ifb-element-preview ifb-element-preview-select">
            <label class="ifb-preview-label <?php if (!strlen($element['label'])) echo 'ifb-hidden'; ?>" for="ifb_element_<?php echo $id; ?>"><span class="ifb-preview-label-content"><?php echo $element['label']; ?></span><span class="ifb-required"><?php echo esc_html($form['required_text']); ?></span></label>
            <div class="ifb-preview-input">
                <select id="ifb_element_<?php echo $id; ?>" disabled="disabled">
                    <?php if (count($element['options'])) : ?>
                        <?php $i = 0; foreach ($element['options'] as $option) : ?>
                            <option value="<?php echo esc_attr($option['value']); ?>" <?php echo in_array($option['value'], $element['default_value'], true) ? 'selected="selected"' : ''; ?>><?php echo esc_html($option['label']); ?></option>
                        <?php $i++; endforeach; ?>
                    <?php endif; ?>
                </select>
                <p class="ifb-preview-description <?php if (!strlen($element['description'])) echo 'ifb-hidden'; ?>"><?php echo $element['description']; ?></p>
            </div>
            <span class="ifb-handle"></span>
        </div>
    </div>
    <div class="ifb-element-settings ifb-element-settings-select">
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
                        <?php include 'settings/options.php'; ?>
                        <?php include '_save.php'; ?>
                    </table>
                </div>
            </div>
            <div class="ifb-tabs-panel" id="ifb-element-settings-tab-more-<?php echo $id; ?>">
                <div class="ifb-element-settings-inner">
                    <table class="ifb-form-table ifb-element-settings-form-table ifb-element-settings-more-form-table">
                        <?php include 'settings/admin-label.php'; ?>
                        <?php include 'settings/podio-id.php'; ?>
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
                        <tr valign="top">
                            <th scope="row">
                                <div class="ifb-tooltip"><div class="ifb-tooltip-content">
                                    <?php esc_html_e('You can convert an element to a different type, see the dropdown menu for the available
                                    choices. Most of your settings will also be converted.', 'iphorm'); ?>
                                </div></div>
                                <label for="convert_element_<?php echo $id; ?>"><?php esc_html_e('Convert element', 'iphorm'); ?></label>
                            </th>
                            <td>
                                <select name="convert_element_<?php echo $id; ?>" id="convert_element_<?php echo $id; ?>" onchange="iPhorm.convertElement(iPhorm.getElementById(<?php echo $id; ?>), this); ">
                                    <option value=""><?php esc_html_e('Please select...', 'iphorm'); ?></option>
                                    <option value="radio"><?php esc_html_e('Multiple Choice', 'iphorm'); ?></option>
                                    <option value="checkbox"><?php esc_html_e('Checkboxes', 'iphorm'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <?php include '_save.php'; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>