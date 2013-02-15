<?php if (!defined('IPHORM_VERSION')) exit; ?><tr class="ifb-element-description-tr" valign="top">
    <th scope="row"><label for="description_<?php echo $id; ?>"><?php esc_html_e('Description', 'iphorm'); ?></label></th>
    <td><textarea id="description_<?php echo $id; ?>" name="description_<?php echo $id; ?>" onkeyup="iPhorm.updatePreviewDescription(iPhorm.getElementById(<?php echo $id; ?>));"><?php echo _wp_specialchars($element['description'], ENT_NOQUOTES, false, true); ?></textarea></td>
</tr>