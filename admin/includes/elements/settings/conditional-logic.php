<?php
if (!defined('IPHORM_VERSION')) exit;
if (!isset($element['logic'])) $element['logic'] = false;
?>
<tr valign="top">
    <th scope="row">
        <label for="prevent_duplicates_<?php echo $id; ?>"><?php esc_html_e('Enable conditional logic', 'iphorm'); ?></label>
    </th>
    <td>
        <input type="checkbox" id="logic_<?php echo $id; ?>" name="logic_<?php echo $id; ?>" <?php checked(true, $element['logic']); ?> onclick="iPhorm.toggleLogic(iPhorm.getElementById(<?php echo $id; ?>));" />
        <p class="description">
            <?php
                if ($element['type'] == 'groupstart') {
                    esc_html_e('Enables you to create rules to show or hide this group depending on the values of other fields', 'iphorm');
                } else {
                    esc_html_e('Enables you to create rules to show or hide this field depending on the values of other fields', 'iphorm');
                }
            ?>
        </p>
    </td>
</tr>
<?php
if (!isset($element['logic_action'])) $element['logic_action'] = 'show';
if (!isset($element['logic_match'])) $element['logic_match'] = 'all';
if (!isset($element['logic_rules'])) $element['logic_rules'] = array();
?>
<tr valign="top" class="ifb-show-if-logic-on <?php if (!$element['logic']) echo 'ifb-hidden'; ?>">
    <th scope="row">
        <label><?php esc_html_e('Logic rules', 'iphorm'); ?></label>
    </th>
    <td>
        <div id="ifb_logic_rules_<?php echo $id; ?>"></div>
    </td>
</tr>