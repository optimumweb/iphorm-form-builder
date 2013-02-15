<?php
if (!defined('IPHORM_VERSION')) exit;
if (!isset($element['tooltip'])) $element['tooltip'] = '';
?>
<tr valign="top">
    <th scope="row">
        <div class="ifb-tooltip"><div class="ifb-tooltip-content">
            <?php printf(esc_html__('The tooltip text will appear next to your element in a tooltip when the user hovers
            it with their mouse. You can customize the look of tooltips by going to %1$sSettings &rarr; Style &rarr; Tooltips%2$s', 'iphorm'), '<span class="ifb-bold">', '</span>'); ?>
        </div></div>
        <label for="tooltip_<?php echo $id; ?>"><?php esc_html_e('Tooltip text', 'iphorm'); ?></label>
    </th>
    <td>
        <input type="text" id="tooltip_<?php echo $id; ?>" name="tooltip_<?php echo $id; ?>" value="<?php echo esc_attr($element['tooltip']); ?>" />
        <?php if (isset($element['type']) && in_array($element['type'], array('recaptcha', 'date', 'time', 'file', 'checkbox', 'radio'))) : ?>
            <p class="description"><?php printf(esc_html__('Note: For this element type the tooltip will only show if the tooltip type is set to
%1$sHelp icon%2$s in the %1$sOptional%2$s settings tab, or in the global tooltip settings at %1$sSettings &rarr; Style &rarr; Tooltips%2$s.', 'iphorm'),
'<span class="ifb-bold">', '</span>'); ?></p>
        <?php endif; ?>
    </td>
</tr>