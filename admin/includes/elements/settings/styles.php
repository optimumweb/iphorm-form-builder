<?php
if (!defined('IPHORM_VERSION')) exit;
if (!isset($element['styles'])) $element['styles'] = array();
$validStyles = iphorm_get_valid_styles($element);
?>
<tr valign="top">
    <th scope="row">
        <div class="ifb-tooltip"><div class="ifb-tooltip-content">
            <?php printf(esc_html__('Once you have added a style, enter the CSS styles one per line, with each line ending in
            a semi-colon. %sClick here%s for an example.', 'iphorm'), '<a onclick="window.open(this.href); return false;" href="'.iphorm_help_link('element-text#example-styles').'">', '</a>'); ?>
        </div></div>
        <label><?php esc_html_e('CSS styles', 'iphorm'); ?></label>
    </th>
    <td>
        <div id="ifb-styles-<?php echo $id; ?>">
            <?php if (count($element['styles'])) : ?>
                <?php foreach ($element['styles'] as $style) : ?>
                    <?php include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/style.php'; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="ifb-styles-empty ifb-info-message" id="ifb-styles-empty-<?php echo $id; ?>"<?php if (count($element['styles'])) echo 'style="display: none;"'; ?>><span class="ifb-info-message-icon"></span><?php esc_html_e('No styles.', 'iphorm'); ?></div>
    </td>
</tr>
<tr valign="top">
    <th scope="row"><label><?php esc_html_e('Add a style', 'iphorm'); ?></label></th>
    <td class="ifb-add-style-list">
        <?php if (in_array('outer', $validStyles)) : ?>
            <a class="button" onclick="iPhorm.addStyle(iPhorm.getElementById(<?php echo $id; ?>), 'outer');"><?php esc_html_e('Outer wrapper', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (in_array('label', $validStyles)) : ?>
            <a class="button" onclick="iPhorm.addStyle(iPhorm.getElementById(<?php echo $id; ?>), 'label');"><?php esc_html_e('Label', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (in_array('inner', $validStyles)) : ?>
            <a class="button" onclick="iPhorm.addStyle(iPhorm.getElementById(<?php echo $id; ?>), 'inner');"><?php esc_html_e('Inner wrapper', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (in_array('input', $validStyles)) : ?>
            <a class="button" onclick="iPhorm.addStyle(iPhorm.getElementById(<?php echo $id; ?>), 'input');"><?php esc_html_e('Text input', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (in_array('textarea', $validStyles)) : ?>
            <a class="button" onclick="iPhorm.addStyle(iPhorm.getElementById(<?php echo $id; ?>), 'textarea');"><?php esc_html_e('Textarea input', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (in_array('select', $validStyles)) : ?>
            <a class="button" onclick="iPhorm.addStyle(iPhorm.getElementById(<?php echo $id; ?>), 'select');"><?php esc_html_e('Dropdown menu', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (in_array('description', $validStyles)) : ?>
            <a class="button" onclick="iPhorm.addStyle(iPhorm.getElementById(<?php echo $id; ?>), 'description');"><?php esc_html_e('Group description', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (in_array('elementDescription', $validStyles)) : ?>
            <a class="button" onclick="iPhorm.addStyle(iPhorm.getElementById(<?php echo $id; ?>), 'elementDescription');"><?php esc_html_e('Description', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (in_array('optionUl', $validStyles)) : ?>
            <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The wrapper around all of the options', 'iphorm'); ?>" onclick="iPhorm.addStyle(iPhorm.getElementById(<?php echo $id; ?>), 'optionUl');"><?php esc_html_e('Options outer wrapper', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (in_array('optionLi', $validStyles)) : ?>
            <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The wrapper around each option', 'iphorm'); ?>" onclick="iPhorm.addStyle(iPhorm.getElementById(<?php echo $id; ?>), 'optionLi');"><?php esc_html_e('Option wrapper', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (in_array('optionLabel', $validStyles)) : ?>
            <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('The label of each option', 'iphorm'); ?>" onclick="iPhorm.addStyle(iPhorm.getElementById(<?php echo $id; ?>), 'optionLabel');"><?php esc_html_e('Option label', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (in_array('group', $validStyles)) : ?>
            <a class="button" onclick="iPhorm.addStyle(iPhorm.getElementById(<?php echo $id; ?>), 'group');"><?php esc_html_e('Group wrapper', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (in_array('groupTitle', $validStyles)) : ?>
            <a class="button" onclick="iPhorm.addStyle(iPhorm.getElementById(<?php echo $id; ?>), 'groupTitle');"><?php esc_html_e('Group title', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (in_array('groupElements', $validStyles)) : ?>
            <a class="button" onclick="iPhorm.addStyle(iPhorm.getElementById(<?php echo $id; ?>), 'groupElements');"><?php esc_html_e('Group elements wrapper', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (in_array('dateDay', $validStyles)) : ?>
            <a class="button" onclick="iPhorm.addStyle(iPhorm.getElementById(<?php echo $id; ?>), 'dateDay');"><?php esc_html_e('Date day dropdown', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (in_array('dateMonth', $validStyles)) : ?>
            <a class="button" onclick="iPhorm.addStyle(iPhorm.getElementById(<?php echo $id; ?>), 'dateMonth');"><?php esc_html_e('Date month dropdown', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (in_array('dateYear', $validStyles)) : ?>
            <a class="button" onclick="iPhorm.addStyle(iPhorm.getElementById(<?php echo $id; ?>), 'dateYear');"><?php esc_html_e('Date year dropdown', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (in_array('timeHour', $validStyles)) : ?>
            <a class="button" onclick="iPhorm.addStyle(iPhorm.getElementById(<?php echo $id; ?>), 'timeHour');"><?php esc_html_e('Time hour dropdown', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (in_array('timeMinute', $validStyles)) : ?>
            <a class="button" onclick="iPhorm.addStyle(iPhorm.getElementById(<?php echo $id; ?>), 'timeMinute');"><?php esc_html_e('Time minute dropdown', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (in_array('timeAmPm', $validStyles)) : ?>
            <a class="button" onclick="iPhorm.addStyle(iPhorm.getElementById(<?php echo $id; ?>), 'timeAmPm');"><?php esc_html_e('Time am/pm dropdown', 'iphorm'); ?></a>
        <?php endif; ?>
    </td>
</tr>