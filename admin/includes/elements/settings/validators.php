<?php
if (!defined('IPHORM_VERSION')) exit;
if (!isset($element['validators'])) $element['validators'] = array();
$invalidValidators = iphorm_get_invalid_validator_types($element);
?>
<tr valign="top">
    <th scope="row">
        <div class="ifb-tooltip"><div class="ifb-tooltip-content">
            <?php esc_html_e('Validators checks whether the data entered by the user is valid', 'iphorm'); ?>
        </div></div>
        <label><?php esc_html_e('Validators', 'iphorm'); ?></label>
    </th>
    <td>
        <div id="ifb-validators-<?php echo $id; ?>">
            <?php if (count($element['validators'])) : ?>
                <?php foreach ($element['validators'] as $validator) : ?>
                    <?php
                        switch ($validator['type']) {
                            case 'alpha':
                                include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/validators/alpha.php';
                                break;
                            case 'alphaNumeric':
                                include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/validators/alpha-numeric.php';
                                break;
                            case 'digits':
                                include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/validators/digits.php';
                                break;
                            case 'email':
                                include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/validators/email.php';
                                break;
                            case 'greaterThan':
                                include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/validators/greater-than.php';
                                break;
                            case 'identical':
                                include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/validators/identical.php';
                                break;
                            case 'length':
                                include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/validators/length.php';
                                break;
                            case 'lessThan':
                                include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/validators/less-than.php';
                                break;
                            case 'regex':
                                include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/validators/regex.php';
                                break;
                        }
                    ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="ifb-validators-empty ifb-info-message" id="ifb-validators-empty-<?php echo $id; ?>" <?php if (count($element['validators'])) echo 'style="display: none;"'; ?>><span class="ifb-info-message-icon"></span><?php esc_html_e('No validators.', 'iphorm'); ?></div>
    </td>
</tr>
<tr valign="top">
    <th scope="row"><label><?php esc_html_e('Add a validator', 'iphorm'); ?></label></th>
    <td class="ifb-add-validator-list">
        <?php if (!in_array('alpha', $invalidValidators)) : ?>
            <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('Checks that the value contains only alphabet characters', 'iphorm'); ?>" onclick="iPhorm.addValidator(iPhorm.getElementById(<?php echo $id; ?>), 'alpha');"><?php esc_html_e('Alpha', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (!in_array('alphaNumeric', $invalidValidators)) : ?>
            <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('Checks that the value contains only alphabet or digit characters', 'iphorm'); ?>" onclick="iPhorm.addValidator(iPhorm.getElementById(<?php echo $id; ?>), 'alphaNumeric');"><?php esc_html_e('Alpha Numeric', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (!in_array('digits', $invalidValidators)) : ?>
            <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('Checks that the value contains only digits', 'iphorm'); ?>" onclick="iPhorm.addValidator(iPhorm.getElementById(<?php echo $id; ?>), 'digits');"><?php esc_html_e('Digits', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (!in_array('email', $invalidValidators)) : ?>
            <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('Checks that the value is a valid email address', 'iphorm'); ?>" onclick="iPhorm.addValidator(iPhorm.getElementById(<?php echo $id; ?>), 'email');"><?php esc_html_e('Email', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (!in_array('greaterThan', $invalidValidators)) : ?>
            <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('Checks that the value is numerically greater than the given minimum', 'iphorm'); ?>" onclick="iPhorm.addValidator(iPhorm.getElementById(<?php echo $id; ?>), 'greaterThan');"><?php esc_html_e('Greater Than', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (!in_array('identical', $invalidValidators)) : ?>
            <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('Checks that the value is identical to the given token', 'iphorm'); ?>" onclick="iPhorm.addValidator(iPhorm.getElementById(<?php echo $id; ?>), 'identical');"><?php esc_html_e('Identical', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (!in_array('lessThan', $invalidValidators)) : ?>
            <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('Checks that the value is numerically less than the given maximum', 'iphorm'); ?>" onclick="iPhorm.addValidator(iPhorm.getElementById(<?php echo $id; ?>), 'lessThan');"><?php esc_html_e('Less Than', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (!in_array('length', $invalidValidators)) : ?>
            <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('Checks that the length of the value is between the given maximum and minimum', 'iphorm'); ?>" onclick="iPhorm.addValidator(iPhorm.getElementById(<?php echo $id; ?>), 'length');"><?php esc_html_e('Length', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (!in_array('regex', $invalidValidators)) : ?>
            <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('Checks that the value matches the given regular expression', 'iphorm'); ?>" onclick="iPhorm.addValidator(iPhorm.getElementById(<?php echo $id; ?>), 'regex');"><?php esc_html_e('Regex', 'iphorm'); ?></a>
        <?php endif; ?>
    </td>
</tr>