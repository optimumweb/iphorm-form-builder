<?php
if (!defined('IPHORM_VERSION')) exit;
if (!isset($element['podio_id'])) $element['podio_id'] = '';
if (!isset($element['podio_data_type'])) $element['podio_data_type'] = 'string';
?>
<tr valign="top">
    <th scope="row">
        <div class="ifb-tooltip"><div class="ifb-tooltip-content">
            <?php esc_html_e('The Podio ID will be used to send data to your Podio app.', 'iphorm'); ?>
        </div></div>
        <label for="podio_id_<?php echo $id; ?>"><?php esc_html_e('Podio ID', 'iphorm'); ?></label>
    </th>
    <td><input type="text" id="podio_id_<?php echo $id; ?>" name="podio_id_<?php echo $id; ?>" value="<?php echo esc_attr($element['podio_id']); ?>" onblur="iPhorm.updatePodioId(this, iPhorm.getElementById(<?php echo $id; ?>));" /></td>
</tr>
<tr valign="top">
    <th scope="row">
        <div class="ifb-tooltip"><div class="ifb-tooltip-content">
            <?php esc_html_e('The Podio Data Type will be used to format the data sent to your Podio app.', 'iphorm'); ?>
        </div></div>
        <label for="podio_data_type_<?php echo $id; ?>"><?php esc_html_e('Podio Data Type', 'iphorm'); ?></label>
    </th>
    <td>
        <select id="podio_data_type_<?php echo $id; ?>" name="podio_data_type_<?php echo $id; ?>" onchange="iPhorm.updatePodioDataType(this, iPhorm.getElementById(<?php echo $id; ?>));">
            <option value="string" <?php selected($element['podio_data_type'], 'string'); ?>><?php esc_html_e('String', 'iphorm'); ?></option>
            <option value="int" <?php selected($element['podio_data_type'], 'int'); ?>><?php esc_html_e('Integer', 'iphorm'); ?></option>
        </select>
    </td>
</tr>