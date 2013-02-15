<?php
if (!defined('IPHORM_VERSION')) exit;
if (!isset($element['save_to_database'])) $element['save_to_database'] = true;
?>
<tr valign="top">
    <th scope="row">
        <div class="ifb-tooltip"><div class="ifb-tooltip-content">
            <?php esc_html_e('If checked, the submitted element data will be saved to the database and shown when viewing an entry', 'iphorm'); ?>
        </div></div>
        <label for="save_to_database_<?php echo $id; ?>"><?php esc_html_e('Save value to the database', 'iphorm'); ?></label>
    </th>
    <td><input type="checkbox" id="save_to_database_<?php echo $id; ?>" name="save_to_database_<?php echo $id; ?>" <?php checked($element['save_to_database'], true); ?> onclick="iPhorm.toggleSaveToDatabase(iPhorm.getElementById(<?php echo $id; ?>));" /></td>
</tr>