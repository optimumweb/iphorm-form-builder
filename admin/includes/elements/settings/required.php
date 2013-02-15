<?php if (!defined('IPHORM_VERSION')) exit; ?><tr valign="top">
    <th scope="row">
        <div class="ifb-tooltip"><div class="ifb-tooltip-content">
            <?php esc_html_e('If checked, the user must fill out this field', 'iphorm'); ?>
        </div></div>
        <label for="required_<?php echo $id; ?>"><?php esc_html_e('Required', 'iphorm'); ?></label>
    </th>
    <td><input type="checkbox" id="required_<?php echo $id; ?>" name="required_<?php echo $id; ?>" <?php checked($element['required'], true); ?> onclick="iPhorm.toggleElementRequired(iPhorm.getElementById(<?php echo $id; ?>), this.checked);" /></td>
</tr>