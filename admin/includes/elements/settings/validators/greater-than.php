<?php if (!defined('IPHORM_VERSION')) exit; ?><div id="ifb-validator-wrap-<?php echo $validator['element_id']; ?>-<?php echo $validator['id']; ?>" class="ifb-validator ifb-validator-greaterthan">
    <div class="ifb-validator-actions">
        <a class="ifb-validator-close-link" title="<?php esc_attr_e('Hide validator settings', 'iphorm'); ?>" href="#" onclick="iPhorm.hideValidatorSettings(<?php echo $validator['element_id']; ?>, <?php echo $validator['id']; ?>); return false;"><span></span><?php esc_html_e('Hide', 'iphorm'); ?></a>
        <a class="ifb-validator-settings-link" title="<?php esc_attr_e('Settings', 'iphorm'); ?>" href="#" onclick="iPhorm.showValidatorSettings(<?php echo $validator['element_id']; ?>, <?php echo $validator['id']; ?>); return false;"><span></span><?php esc_html_e('Settings', 'iphorm'); ?></a>
        <a class="ifb-validator-delete-link" title="<?php esc_attr_e('Delete this validator', 'iphorm'); ?>" href="#" onclick="iPhorm.deleteValidator(iPhorm.getElementById(<?php echo $validator['element_id']; ?>), <?php echo $validator['id']; ?>); return false;"><?php esc_html_e('Delete', 'iphorm'); ?></a>
    </div>
    <?php if (!isset($validator['name'])) $validator['name'] = _x('Greater Than', 'the name of the greater than validator which validates that the value is greater than a number', 'iphorm'); ?>
    <div class="ifb-validator-title"><?php echo esc_html($validator['name']); ?></div>
    <div class="ifb-validator-settings">
        <h3><?php esc_html_e('Settings', 'iphorm'); ?></h3>
        <table class="ifb-form-table ifb-validator-settings-form-table">
            <?php if (!isset($validator['min'])) $validator['min'] = 0; ?>
            <tr valign="top">
                <th scope="row">
                    <div class="ifb-tooltip">
                        <div class="ifb-tooltip-content">
                            <?php esc_html_e('The submitted value must be numerically greater than the minimum, if not the error message shown below will be displayed to the user', 'iphorm'); ?>
                        </div>
                    </div>
                    <label for="v_min_<?php echo $validator['element_id']; ?>_<?php echo $validator['id']; ?>"><?php esc_html_e('Minimum', 'iphorm'); ?></label></th>
                <td><input type="text" id="v_min_<?php echo $validator['element_id']; ?>_<?php echo $validator['id']; ?>" name="v_min_<?php echo $validator['element_id']; ?>_<?php echo $validator['id']; ?>" value="<?php echo esc_attr($validator['min']); ?>" /></td>
            </tr>
        </table>
        <h3><?php esc_html_e('Translate error message', 'iphorm'); ?></h3>
        <table class="ifb-form-table ifb-validator-settings-form-table">
            <?php
                $greaterThanValidator = new iPhorm_Validator_GreaterThan(array('min' => 0));
                if (!isset($validator['messages']['not_greater_than'])) $validator['messages']['not_greater_than'] = '';
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
                            <code>%2$s = <?php esc_html_e('the minimum allowed value', 'iphorm'); ?></code><br />
                            <?php esc_html_e('You can enter the placeholder code in your custom message to display their values.', 'iphorm'); ?>
                        </div>
                    </div>
                    <label for="v_not_greater_than_<?php echo $validator['element_id']; ?>_<?php echo $validator['id']; ?>"><?php echo esc_html($greaterThanValidator->getMessageTemplate('not_greater_than')); ?></label></th>
                <td><input type="text" id="v_not_greater_than_<?php echo $validator['element_id']; ?>_<?php echo $validator['id']; ?>" name="v_not_greater_than_<?php echo $validator['element_id']; ?>_<?php echo $validator['id']; ?>" value="<?php echo esc_attr($validator['messages']['not_greater_than']); ?>" /></td>
            </tr>
        </table>
    </div>
</div>