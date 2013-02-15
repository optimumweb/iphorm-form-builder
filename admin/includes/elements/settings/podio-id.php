<?php
if (!defined('IPHORM_VERSION')) exit;
if (!isset($element['podio_id'])) $element['podio_id'] = '';
?>
<tr valign="top">
    <th scope="row">
        <div class="ifb-tooltip"><div class="ifb-tooltip-content">
            <?php esc_html_e('The Podio ID will be used to send data to your Podio app.', 'iphorm'); ?>
        </div></div>
        <label for="podio_id_<?php echo $id; ?>"><?php esc_html_e('Podio ID', 'iphorm'); ?></label>
    </th>
    <td><input type="text" id="podio_id_<?php echo $id; ?>" name="podio_id_<?php echo $id; ?>" value="<?php echo esc_attr($element['podio_id']); ?>" /></td>
</tr>