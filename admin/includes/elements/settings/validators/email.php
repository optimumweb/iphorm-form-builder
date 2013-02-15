<?php if (!defined('IPHORM_VERSION')) exit; ?><div id="ifb-validator-wrap-<?php echo $validator['element_id']; ?>-<?php echo $validator['id']; ?>" class="ifb-validator ifb-validator-email">
    <div class="ifb-validator-actions">
        <a class="ifb-validator-close-link" title="<?php esc_attr_e('Hide validator settings', 'iphorm'); ?>" href="#" onclick="iPhorm.hideValidatorSettings(<?php echo $validator['element_id']; ?>, <?php echo $validator['id']; ?>); return false;"><span></span><?php esc_html_e('Hide', 'iphorm'); ?></a>
        <a class="ifb-validator-settings-link" title="<?php esc_attr_e('Settings', 'iphorm'); ?>" href="#" onclick="iPhorm.showValidatorSettings(<?php echo $validator['element_id']; ?>, <?php echo $validator['id']; ?>); return false;"><span></span><?php esc_html_e('Settings', 'iphorm'); ?></a>
        <a class="ifb-validator-delete-link" title="<?php esc_attr_e('Delete this validator', 'iphorm'); ?>" href="#" onclick="iPhorm.deleteValidator(iPhorm.getElementById(<?php echo $validator['element_id']; ?>), <?php echo $validator['id']; ?>); return false;"><?php esc_html_e('Delete', 'iphorm'); ?></a>
    </div>
    <?php if (!isset($validator['name'])) $validator['name'] = _x('Email Address', 'the name of the email address validator', 'iphorm'); ?>
    <div class="ifb-validator-title"><?php echo esc_html($validator['name']); ?></div>
    <div class="ifb-validator-settings">
        <h3><?php esc_html_e('Translate error message', 'iphorm'); ?></h3>
        <table class="ifb-form-table ifb-validator-settings-form-table">
            <?php
                $emailValidator = new iPhorm_Validator_Email();
                if (!isset($validator['messages']['invalid'])) $validator['messages']['invalid'] = '';
            ?>
            <tr valign="top">
                <th><?php esc_html_e('Default', 'iphorm'); ?></th>
                <th><?php esc_html_e('Translation', 'iphorm'); ?></th>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="v_invalid_<?php echo $validator['element_id']; ?>_<?php echo $validator['id']; ?>"><?php echo esc_html($emailValidator->getMessageTemplate('invalid')); ?></label></th>
                <td><input type="text" id="v_invalid_<?php echo $validator['element_id']; ?>_<?php echo $validator['id']; ?>" name="v_invalid_<?php echo $validator['element_id']; ?>_<?php echo $validator['id']; ?>" value="<?php echo esc_attr($validator['messages']['invalid']); ?>" /></td>
            </tr>
        </table>
    </div>
</div>