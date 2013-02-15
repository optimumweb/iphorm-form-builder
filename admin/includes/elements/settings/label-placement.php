<?php
if (!defined('IPHORM_VERSION')) exit;
if (!isset($element['label_placement'])) $element['label_placement'] = 'inherit';
?>
<tr valign="top">
    <th scope="row">
        <div class="ifb-tooltip"><div class="ifb-tooltip-content">
            <?php esc_html_e('"Inherit" means that the label placement will be inherted from the global
            form settings or parent group.', 'iphorm'); ?>
        </div></div>
        <label for="label_placement_<?php echo $id; ?>"><?php esc_html_e('Label placement', 'iphorm'); ?></label>
    </th>
    <td>
        <select id="label_placement_<?php echo $id; ?>" name="label_placement_<?php echo $id; ?>" onchange="iPhorm.setElementLabelPlacement(iPhorm.getElementById(<?php echo $id; ?>));">
            <option value="inherit" <?php selected($element['label_placement'], 'inherit'); ?>><?php esc_html_e('Inherit', 'iphorm'); ?></option>
            <option value="above" <?php selected($element['label_placement'], 'above'); ?>><?php esc_html_e('Above', 'iphorm'); ?></option>
            <option value="left" <?php selected($element['label_placement'], 'left'); ?>><?php esc_html_e('Left', 'iphorm'); ?></option>
            <option value="inside" <?php selected($element['label_placement'], 'inside'); ?>><?php esc_html_e('Inside', 'iphorm'); ?></option>
        </select>
        <p class="description"><?php esc_html_e('Choose where to display the label relative to the input. Changes to this setting will only be visible when viewing or previewing the form.', 'iphorm'); ?></p>
    </td>
</tr>
<?php if (!isset($element['label_width'])) $element['label_width'] = ''; ?>
<tr valign="top" class="<?php if ($element['label_placement'] != 'left') echo 'ifb-hidden'; ?> ifb-show-if-element-label-placement-left">
    <th scope="row">
        <div class="ifb-tooltip"><div class="ifb-tooltip-content"><?php esc_html_e('Specify how wide the labels should be, this only applies when the label placement is left', 'iphorm'); ?></div></div>
        <label for="label_width_<?php echo $id; ?>"><?php esc_html_e('Label width', 'iphorm'); ?></label>
    </th>
    <td>
        <input name="label_width_<?php echo $id; ?>" id="label_width_<?php echo $id; ?>" type="text" value="<?php echo esc_attr($element['label_width']); ?>" class="ifb-halfwidth-input" />
        <p class="description"><?php printf(esc_html__('The width of the element labels, any valid CSS width is accepted, e.g. %s200px%s', 'iphorm'), '<span class="ifb-bold">', '</span>'); ?></p>
    </td>
</tr>