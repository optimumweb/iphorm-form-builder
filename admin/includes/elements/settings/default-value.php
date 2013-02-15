<?php if (!defined('IPHORM_VERSION')) exit; ?>
<tr valign="top">
    <th scope="row">
        <div class="ifb-tooltip"><div class="ifb-tooltip-content">
            <?php esc_html_e('The default value is the value that the element is given before
            the user has entered anything', 'iphorm'); ?>
        </div></div>
        <label for="default_value_<?php echo $id; ?>"><?php esc_html_e('Default value', 'iphorm'); ?></label>
    </th>
    <td>
        <input type="text" id="default_value_<?php echo $id; ?>" name="default_value_<?php echo $id; ?>" value="<?php echo esc_attr($element['default_value']); ?>"
          onfocus="iPhorm.updateDefaultValue(this, iPhorm.getElementById(<?php echo $id; ?>));"
          onblur="iPhorm.updateDefaultValue(this, iPhorm.getElementById(<?php echo $id; ?>));"
          onkeyup="iPhorm.updateDefaultValue(this, iPhorm.getElementById(<?php echo $id; ?>));"
        />
        <?php include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/_insert-variable-preprocess.php'; ?>
    </td>
</tr>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/clear-default-value.php'; ?>