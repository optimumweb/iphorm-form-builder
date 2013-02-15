<?php
if (!defined('IPHORM_VERSION')) exit;
if (!isset($element['tooltip_type'])) $element['tooltip_type'] = 'inherit';
?>
<tr valign="top">
    <th scope="row">
        <div class="ifb-tooltip"><div class="ifb-tooltip-content"><?php printf(esc_html__('If set to %1$sInherit%2$s, the setting will be inherited from the global
form settings. If set to %1$sField%2$s, the tooltip will show when the user interacts with
        the field. If set to %1$sHelp icon%2$s, the tooltip will be shown when the user interacts with a help icon.', 'iphorm'), '<span class="ifb-bold">', '</span>'); ?></div></div>
        <label for="tooltip_type_<?php echo $id; ?>"><?php esc_html_e('Tooltip trigger', 'iphorm'); ?></label>
    </th>
    <td>
    <select name="tooltip_type_<?php echo $id; ?>" id="tooltip_type_<?php echo $id; ?>">
        <?php if (isset($element['type']) && !in_array($element['type'], array('recaptcha', 'date', 'time', 'file', 'checkbox', 'radio'))) : ?>
            <option value="inherit" <?php selected($element['tooltip_type'], 'inherit'); ?>><?php esc_html_e('Inherit', 'iphorm'); ?></option>
            <option value="field" <?php selected($element['tooltip_type'], 'field'); ?>><?php esc_html_e('Field', 'iphorm'); ?></option>
        <?php endif; ?>
        <option value="icon" <?php selected($element['tooltip_type'], 'icon'); ?>><?php esc_html_e('Help icon', 'iphorm'); ?></option>

    </select>
    <p class="description"><?php esc_html_e('Choose what the user will be interacting with to show the tooltip.', 'iphorm'); ?></p>
</tr>
<?php if (!isset($element['tooltip_event'])) $element['tooltip_event'] = 'inherit'; ?>
<tr valign="top">
    <th scope="row">
        <div class="ifb-tooltip"><div class="ifb-tooltip-content"><?php printf(esc_html__('If set to %1$sInherit%2$s, the setting will be inherited from the global
form settings.', 'iphorm'), '<span class="ifb-bold">', '</span>'); ?></div></div>
        <label for="tooltip_event_<?php echo $id; ?>"><?php esc_html_e('Tooltip event', 'iphorm'); ?></label>
    </th>
    <td>
        <select name="tooltip_event_<?php echo $id; ?>" id="tooltip_event_<?php echo $id; ?>">
            <option value="inherit" <?php selected($element['tooltip_event'], 'inherit'); ?>><?php esc_html_e('Inherit', 'iphorm'); ?></option>
            <option value="hover" <?php selected($element['tooltip_event'], 'hover'); ?>><?php esc_html_e('Hover', 'iphorm'); ?></option>
            <option value="click" <?php selected($element['tooltip_event'], 'click'); ?>><?php esc_html_e('Click', 'iphorm'); ?></option>
        </select>
        <p class="description"><?php esc_html_e('Choose the event that will trigger the tooltip to show.', 'iphorm'); ?></p>
    </td>
</tr>