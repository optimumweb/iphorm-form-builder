<?php if (!defined('IPHORM_VERSION')) exit; ?><tr valign="top">
    <th scope="row"><label for="label_<?php echo $id; ?>"><?php esc_html_e('Label', 'iphorm'); ?></label></th>
    <td><input type="text" id="label_<?php echo $id; ?>" name="label_<?php echo $id; ?>" value="<?php echo _wp_specialchars($element['label'], ENT_COMPAT, false, true); ?>" onkeyup="iPhorm.updatePreviewLabel(iPhorm.getElementById(<?php echo $id; ?>));" onblur="iPhorm.updateElementLabel(iPhorm.getElementById(<?php echo $id; ?>));" /></td>
</tr>