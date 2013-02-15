<?php
if (!defined('IPHORM_VERSION')) exit;
if (!isset($element['customise_values'])) $element['customise_values'] = false;
?>
<tr valign="top">
    <th scope="row">
        <div class="ifb-tooltip"><div class="ifb-tooltip-content">
            <?php esc_html_e('These are the choices that the user will be able to choose from.', 'iphorm'); ?>
            <br /><br />
            <?php printf(esc_html__('The %sCustomize values%s setting allows you to have a different value being submitted, than the value that is displayed to the user.', 'iphorm'), '<span class="ifb-bold">', '</span>'); ?>
        </div></div>
        <label><?php esc_html_e('Options', 'iphorm'); ?></label>
    </th>
    <td id="options_td_<?php echo $id; ?>" <?php if ($element['customise_values']) echo 'class="ifb-customise-values"'; ?>>
        <div class="ifb-options-heading clearfix">
            <div class="ifb-options-heading-option"><?php esc_html_e('Label', 'iphorm'); ?></div>
            <div class="ifb-options-heading-value"><?php esc_html_e('Value', 'iphorm'); ?></div>
        </div>
        <ul class="ifb-options-list" id="ifb_options_<?php echo $id; ?>">
            <?php $i = 0; foreach ($element['options'] as $option) : ?>
                <li class="ifb-option-wrap">
                    <input class="ifb-default-option" name="default_option_<?php echo $id; ?>" type="checkbox" onclick="iPhorm.updateOptions(iPhorm.getElementById(<?php echo $id; ?>));" <?php echo in_array($option['value'], $element['default_value'], true) ? 'checked="checked"' : ''; ?> /> <input class="ifb-option-label" type="text" value="<?php echo _wp_specialchars($option['label'], ENT_COMPAT, false, true); ?>" onkeyup="iPhorm.updateOptions(iPhorm.getElementById(<?php echo $id; ?>));" onclick="iPhorm.maybeSelectOptionText(this);" onblur="iPhorm.updateLogicOptions(iPhorm.getElementById(<?php echo $id; ?>));" /> <input class="ifb-option-value" type="text" value="<?php echo _wp_specialchars($option['value'], ENT_COMPAT, false, true); ?>" onkeyup="iPhorm.updateOptions(iPhorm.getElementById(<?php echo $id?>));" onblur="iPhorm.updateLogicOptions(iPhorm.getElementById(<?php echo $id; ?>));" /> <span class="ifb-add-option" onclick="iPhorm.addOption(this, iPhorm.getElementById(<?php echo $id?>));">+</span> <span class="ifb-remove-option" onclick="iPhorm.removeOption(this, iPhorm.getElementById(<?php echo $id; ?>));">x</span>
                </li>
            <?php $i++; endforeach; ?>
        </ul>
        <div class="ifb-customise-values-wrap"><label for="customise_values_<?php echo $id; ?>"><input id="customise_values_<?php echo $id; ?>" name="customise_values_<?php echo $id; ?>" type="checkbox" onclick="iPhorm.toggleCustomiseValues(this.checked, iPhorm.getElementById(<?php echo $id; ?>));" <?php echo checked($element['customise_values'], true); ?> /> <?php esc_html_e('Customize values', 'iphorm'); ?></label></div>
        <?php include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/options-bulk.php'; ?>
    </td>
</tr>