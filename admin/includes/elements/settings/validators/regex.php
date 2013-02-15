<?php if (!defined('IPHORM_VERSION')) exit; ?><div id="ifb-validator-wrap-<?php echo $validator['element_id']; ?>-<?php echo $validator['id']; ?>" class="ifb-validator ifb-validator-regex">
    <div class="ifb-validator-actions">
        <a class="ifb-validator-close-link" title="<?php esc_attr_e('Hide validator settings', 'iphorm'); ?>" href="#" onclick="iPhorm.hideValidatorSettings(<?php echo $validator['element_id']; ?>, <?php echo $validator['id']; ?>); return false;"><span></span><?php esc_html_e('Hide', 'iphorm'); ?></a>
        <a class="ifb-validator-settings-link" title="<?php esc_attr_e('Settings', 'iphorm'); ?>" href="#" onclick="iPhorm.showValidatorSettings(<?php echo $validator['element_id']; ?>, <?php echo $validator['id']; ?>); return false;"><span></span><?php esc_html_e('Settings', 'iphorm'); ?></a>
        <a class="ifb-validator-delete-link" title="<?php esc_attr_e('Delete this validator', 'iphorm'); ?>" href="#" onclick="iPhorm.deleteValidator(iPhorm.getElementById(<?php echo $validator['element_id']; ?>), <?php echo $validator['id']; ?>); return false;"><?php esc_html_e('Delete', 'iphorm'); ?></a>
    </div>
    <?php if (!isset($validator['name'])) $validator['name'] = _x('Regex', 'the name of the regex validator which validates by regular expression', 'iphorm'); ?>
    <div class="ifb-validator-title"><?php echo esc_html($validator['name']); ?></div>
    <div class="ifb-validator-settings">
        <h3><?php esc_html_e('Settings', 'iphorm'); ?></h3>
        <table class="ifb-form-table ifb-validator-settings-form-table">
            <?php if (!isset($validator['pattern'])) $validator['pattern'] = ''; ?>
            <tr valign="top">
                <th scope="row">
                    <div class="ifb-tooltip">
                        <div class="ifb-tooltip-content">
                            <?php esc_html_e('The submitted value must match this regular expression, or the error message shown below will be displayed to the user', 'iphorm'); ?>
                        </div>
                    </div>
                    <label for="v_pattern_<?php echo $validator['element_id']; ?>_<?php echo $validator['id']; ?>"><?php esc_html_e('Pattern', 'iphorm'); ?></label>
                </th>
                <td><input type="text" id="v_pattern_<?php echo $validator['element_id']; ?>_<?php echo $validator['id']; ?>" name="v_pattern_<?php echo $validator['element_id']; ?>_<?php echo $validator['id']; ?>" value="<?php echo esc_attr($validator['pattern']); ?>" /></td>
            </tr>
        </table>
        <h3><?php esc_html_e('Translate error message', 'iphorm'); ?></h3>
        <table class="ifb-form-table ifb-validator-settings-form-table">
            <?php
                $regexValidator = new iPhorm_Validator_Regex();
                if (!isset($validator['messages']['invalid'])) $validator['messages']['invalid'] = '';
            ?>
            <tr valign="top">
                <th><?php esc_html_e('Default', 'iphorm'); ?></th>
                <th><?php esc_html_e('Translation', 'iphorm'); ?></th>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <div class="ifb-tooltip">
                        <div class="ifb-tooltip-content">
                            <div class="ifb-tooltip-title"><?php esc_html_e('Placeholders', 'iphorm'); ?></div>
                            <code>%1$s = <?php esc_html_e('the submitted value', 'iphorm'); ?></code><br />
                            <?php esc_html_e('You can enter the placeholder code in your custom message to display their values.', 'iphorm'); ?>
                        </div>
                    </div>
                    <label for="v_invalid_<?php echo $validator['element_id']; ?>_<?php echo $validator['id']; ?>"><?php echo esc_html($regexValidator->getMessageTemplate('invalid')); ?></label></th>
                <td><input type="text" id="v_invalid_<?php echo $validator['element_id']; ?>_<?php echo $validator['id']; ?>" name="v_invalid_<?php echo $validator['element_id']; ?>_<?php echo $validator['id']; ?>" value="<?php echo esc_attr($validator['messages']['invalid']); ?>" /></td>
            </tr>
        </table>
    </div>
</div>