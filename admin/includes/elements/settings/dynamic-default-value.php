<?php
if (!defined('IPHORM_VERSION')) exit;
if (!isset($element['dynamic_default_value'])) $element['dynamic_default_value'] = false;
?>
<tr valign="top">
    <th scope="row">
        <div class="ifb-tooltip"><div class="ifb-tooltip-content">
            <?php esc_html_e('Allows the default value of the field to be set dynamically via a
            URL parameter, shortcode attribute or filter hook.', 'iphorm'); ?>
        </div></div>
        <label for="dynamic_default_value_<?php echo $id; ?>"><?php esc_html_e('Dynamic default value', 'iphorm'); ?></label>
    </th>
    <td><input type="checkbox" id="dynamic_default_value_<?php echo $id; ?>" name="dynamic_default_value_<?php echo $id; ?>" <?php checked(true, $element['dynamic_default_value']); ?>" onclick="iPhorm.toggleDynamicDefaultValue(iPhorm.getElementById(<?php echo $id; ?>));" /></td>
</tr>
<?php if (!isset($element['dynamic_key'])) $element['dynamic_key'] = ''; ?>
<tr valign="top" class="ifb-show-if-dynamic-default-value <?php if (!$element['dynamic_default_value']) echo 'ifb-hidden'; ?>">
    <th scope="row">
        <div class="ifb-tooltip"><div class="ifb-tooltip-content">
            <?php printf(esc_html__('This is the name of the parameter that you will use to set the default.
            For example, in the URL you can set the value using %s?parameter_name=my_value%s.', 'iphorm'), '<span class="ifb-bold">', '</span>'); ?>
        </div></div>
        <label for="dynamic_key_<?php echo $id; ?>"><?php esc_html_e('Parameter name', 'iphorm'); ?></label>
    </th>
    <td><input type="text" id="dynamic_key_<?php echo $id; ?>" name="dynamic_key_<?php echo $id; ?>" value="<?php echo esc_attr($element['dynamic_key']); ?>" /></td>
</tr>