<?php
if (!defined('IPHORM_VERSION')) exit;
if (!isset($element['input_mask'])) $element['input_mask'] = '';
?>
<tr valign="top">
    <th scope="row">
        <div class="ifb-tooltip"><div class="ifb-tooltip-content">
            <?php esc_html_e('The input mask is used to format the input.', 'iphorm'); ?>
        </div></div>
        <label for="input_mask_<?php echo $id; ?>"><?php esc_html_e('Input Mask', 'iphorm'); ?></label>
    </th>
    <td><input type="text" id="input_mask_<?php echo $id; ?>" name="input_mask_<?php echo $id; ?>" value="<?php echo esc_attr($element['input_mask']); ?>" onblur="iPhorm.updateInputMask(this, iPhorm.getElementById(<?php echo $id; ?>));" /></td>
</tr>
