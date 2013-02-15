<?php
if (!defined('IPHORM_VERSION')) exit;
if (!isset($element['admin_label'])) $element['admin_label'] = '';
?>
<tr valign="top">
    <th scope="row">
        <div class="ifb-tooltip"><div class="ifb-tooltip-content">
            <?php esc_html_e('The admin label will be shown throughout the form builder, in the notification email and when viewing submitted form entries.', 'iphorm'); ?>
        </div></div>
        <label for="admin_label_<?php echo $id; ?>"><?php esc_html_e('Admin label', 'iphorm'); ?></label>
    </th>
    <td><input type="text" id="admin_label_<?php echo $id; ?>" name="admin_label_<?php echo $id; ?>" value="<?php echo esc_attr($element['admin_label']); ?>" onblur="iPhorm.updateAdminLabel(this, iPhorm.getElementById(<?php echo $id; ?>));" /></td>
</tr>