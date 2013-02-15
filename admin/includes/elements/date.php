<?php
if (!defined('IPHORM_VERSION')) exit;
$id = absint($element['id']);
$months = iphorm_get_all_months();

if (!isset($element['label'])) $element['label'] = __('Date', 'iphorm');
if (!isset($element['description'])) $element['description'] = '';
if (!isset($element['required'])) $element['required'] = false;
if (!isset($element['default_value'])) $element['default_value'] = array('day' => '', 'month' => '', 'year' => '');
if (!isset($element['start_year'])) $element['start_year'] = '';
if (!isset($element['end_year'])) $element['end_year'] = '';
if (!isset($element['show_date_headings'])) $element['show_date_headings'] = true;
if (!isset($element['day_heading'])) $element['day_heading'] = '';
if (!isset($element['month_heading'])) $element['month_heading'] = '';
if (!isset($element['year_heading'])) $element['year_heading'] = '';
if (!isset($element['months_as_numbers'])) $element['months_as_numbers'] = false;
if (!isset($element['field_order'])) $element['field_order'] = 'eu';

$dayHeading = strlen($element['day_heading']) ? $element['day_heading'] : _x('Day', 'select day of the month', 'iphorm');
$monthHeading = strlen($element['month_heading']) ? $element['month_heading'] : _x('Month', 'select month', 'iphorm');
$yearHeading = strlen($element['year_heading']) ? $element['year_heading'] : _x('Year', 'select year', 'iphorm');

$sy = iphorm_get_start_year($element['start_year']);
$ey = iphorm_get_end_year($element['end_year']);
$helpUrl = iphorm_help_link('element-date');
?>
<div id="ifb-element-wrap-<?php echo $id; ?>" class="ifb-element-wrap ifb-element-wrap-date <?php if (!$element['required']) echo 'ifb-element-optional'; ?> <?php echo "ifb-label-placement-{$form['label_placement']}"; ?>">
	<div class="ifb-top-element-wrap clearfix">
        <?php include IPHORM_ADMIN_INCLUDES_DIR . '/elements/_actions.php'; ?>
        <div class="ifb-element-preview ifb-element-preview-date">
            <label class="ifb-preview-label <?php if (!strlen($element['label'])) echo 'ifb-hidden'; ?>" for="ifb_element_<?php echo $id; ?>"><span class="ifb-preview-label-content"><?php echo $element['label']; ?></span><span class="ifb-required"><?php echo esc_html($form['required_text']); ?></span></label>
            <div class="ifb-preview-input">
                <?php ob_start(); ?>
                <select id="ifb_element_<?php echo $id; ?>_day" name="ifb_element_<?php echo $id; ?>[day]" disabled="disabled">
                    <?php if ($element['show_date_headings']) : ?><option value=""><?php echo esc_html($dayHeading); ?></option><?php endif; ?>
                    <?php foreach (range(1, 31) as $day) : ?>
                        <option value="<?php echo $day; ?>" <?php selected($element['default_value']['day'], $day); ?>><?php echo $day; ?></option>
                    <?php endforeach; ?>
                </select>
                <?php $daySelect = ob_get_clean(); ?>
                <?php ob_start(); ?>
                <select id="ifb_element_<?php echo $id; ?>_month" name="ifb_element_<?php echo $id; ?>[month]" disabled="disabled">
                    <?php if ($element['show_date_headings']) : ?><option value=""><?php echo esc_html($monthHeading); ?></option><?php endif; ?>
                    <?php foreach ($months as $key => $month) : ?>
                        <option value="<?php echo $key; ?>" <?php selected($element['default_value']['month'], $key); ?>><?php echo $element['months_as_numbers'] ? $key : esc_html($month); ?></option>
                    <?php endforeach; ?>
                </select>
                <?php $monthSelect = ob_get_clean(); ?>
                <?php
                if ($element['field_order'] != 'us') {
                    echo $daySelect, $monthSelect;
                } else {
                    echo $monthSelect, $daySelect;
                }
                ?>
                <select id="ifb_element_<?php echo $id; ?>_year" name="ifb_element_<?php echo $id; ?>[year]" disabled="disabled">
                    <?php if ($element['show_date_headings']) : ?><option value=""><?php echo esc_html($yearHeading); ?></option><?php endif; ?>
                    <?php if ($sy > $ey) : ?>
                        <?php for ($i = $sy; $i >= $ey; $i--) : ?>
                            <option value="<?php echo $i; ?>" <?php selected($element['default_value']['year'], $i); ?>><?php echo $i; ?></option>
                        <?php endfor; ?>
                    <?php else : ?>
                        <?php for ($i = $sy; $i <= $ey; $i++) : ?>
                            <option value="<?php echo $i; ?>" <?php selected($element['default_value']['year'], $i); ?>><?php echo $i; ?></option>
                        <?php endfor; ?>
                    <?php endif; ?>
                </select>
                <p class="ifb-preview-description <?php if (!strlen($element['description'])) echo 'ifb-hidden'; ?>"><?php echo $element['description']; ?></p>
            </div>
            <span class="ifb-handle"></span>
        </div>
    </div>
    <div class="ifb-element-settings ifb-element-settings-date">
        <div class="ifb-element-settings-tabs" id="ifb-element-settings-tabs-<?php echo $id; ?>">
            <ul class="ifb-tabs-nav">
                <li><a href="#ifb-element-settings-tab-settings-<?php echo $id; ?>"><?php esc_html_e('Settings', 'iphorm'); ?></a></li>
                <li><a href="#ifb-element-settings-tab-more-<?php echo $id; ?>"><?php esc_html_e('Optional', 'iphorm'); ?></a></li>
                <li><a href="#ifb-element-settings-tab-advanced-<?php echo $id; ?>"><?php esc_html_e('Advanced', 'iphorm'); ?></a></li>
            </ul>
            <div class="ifb-tabs-panel" id="ifb-element-settings-tab-settings-<?php echo $id; ?>">
                <div class="ifb-element-settings-inner">
                    <table class="ifb-form-table ifb-element-settings-form-table ifb-element-settings-settings-form-table">
                        <?php include 'settings/label.php'; ?>
                        <?php include 'settings/description.php'; ?>
                        <?php include 'settings/required.php'; ?>
                        <?php include 'settings/tooltip.php'; ?>
                        <?php include '_save.php'; ?>
                    </table>
                </div>
            </div>
            <div class="ifb-tabs-panel" id="ifb-element-settings-tab-more-<?php echo $id; ?>">
                <div class="ifb-element-settings-inner">
                    <table class="ifb-form-table ifb-element-settings-form-table ifb-element-settings-more-form-table">
                        <?php include 'settings/admin-label.php'; ?>
                        <?php include 'settings/podio-id.php'; ?>
                        <?php include 'settings/required-message.php'; ?>
                        <?php include 'settings/hide-from-email.php'; ?>
                        <?php include 'settings/save-to-database.php'; ?>
                        <?php include 'settings/label-placement.php'; ?>
                        <tr valign="top">
                            <th scope="row">
                                <div class="ifb-tooltip"><div class="ifb-tooltip-content">
                                    <?php esc_html_e('Shows the headings for Day, Month and Year as the first options in the dropdown menus.', 'iphorm'); ?>
                                </div></div>
                                <label for="show_date_headings_<?php echo $id; ?>"><?php esc_html_e('Show date headings', 'iphorm'); ?></label></th>
                            <td>
                                <input type="checkbox" id="show_date_headings_<?php echo $id; ?>" name="show_date_headings_<?php echo $id; ?>" <?php checked(true, $element['show_date_headings']); ?> onclick="iPhorm.showDateHeadings(this.checked, iPhorm.getElementById(<?php echo $id; ?>));" />
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <div class="ifb-tooltip"><div class="ifb-tooltip-content">
                                    <?php esc_html_e('The start year will be the first year in the year dropdown and every from the start year to the end year will be displayed.', 'iphorm'); ?>
                                </div></div>
                                <label for="start_year_<?php echo $id; ?>"><?php esc_html_e('Start year', 'iphorm'); ?></label></th>
                            <td>
                                <input type="text" id="start_year_<?php echo $id; ?>" name="start_year_<?php echo $id; ?>" value="<?php echo esc_attr($element['start_year']); ?>" class="ifb-halfwidth-input" />
                                <p class="description"><?php printf(esc_html__('You can use the tag %1$s for the current year or add modifiers to the current year such as %2$s or %3$s.', 'iphorm'), '<code>{year}</code>', '<code>{year|+4}</code>', '<code>{year|-10}</code>'); ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <div class="ifb-tooltip"><div class="ifb-tooltip-content">
                                    <?php esc_html_e('The end year will be the last year in the year dropdown and every year from the start year to the end year will be displayed.', 'iphorm'); ?>
                                </div></div>
                                <label for="end_year_<?php echo $id; ?>"><?php esc_html_e('End year', 'iphorm'); ?></label></th>
                            <td>
                                <input type="text" id="end_year_<?php echo $id; ?>" name="end_year_<?php echo $id; ?>" value="<?php echo esc_attr($element['end_year']); ?>" class="ifb-halfwidth-input" />
                                <p class="description"><?php printf(esc_html__('You can use the tag %1$s for the current year or add modifiers to the current year such as %2$s or %3$s.', 'iphorm'), '<code>{year}</code>', '<code>{year|+4}</code>', '<code>{year|-10}</code>'); ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <div class="ifb-tooltip"><div class="ifb-tooltip-content">
                                    <?php esc_html_e('The default value is the value that the element is given before
                                    the user has changed anything', 'iphorm'); ?>
                                </div></div>
                                <label><?php esc_html_e('Default value', 'iphorm'); ?></label>
                            </th>
                            <td>
                                <?php ob_start(); ?>
                                <select id="default_value_<?php echo $id; ?>_day" name="default_value_<?php echo $id; ?>[day]" onchange="iPhorm.updateDefaultDate(iPhorm.getElementById(<?php echo $id; ?>));">
                                    <?php if ($element['show_date_headings']) : ?><option value=""><?php echo esc_html($dayHeading); ?></option><?php endif; ?>
                                    <?php foreach (range(1, 31) as $day) : ?>
                                        <option value="<?php echo $day; ?>" <?php selected($element['default_value']['day'], $day); ?>><?php echo $day; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php $defaultDaySelect = ob_get_clean(); ?>
                                <?php ob_start(); ?>
                                <select id="default_value_<?php echo $id; ?>_month" name="default_value_<?php echo $id; ?>[month]" onchange="iPhorm.updateDefaultDate(iPhorm.getElementById(<?php echo $id; ?>));">
                                    <?php if ($element['show_date_headings']) : ?><option value=""><?php echo esc_html($monthHeading); ?></option><?php endif; ?>
                                    <?php foreach ($months as $key => $month) : ?>
                                        <option value="<?php echo $key; ?>" <?php selected($element['default_value']['month'], $key); ?>><?php echo $element['months_as_numbers'] ? $key : esc_html($month); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php $defaultMonthSelect = ob_get_clean(); ?>
                                <?php
                                if ($element['field_order'] != 'us') {
                                    echo $defaultDaySelect, $defaultMonthSelect;
                                } else {
                                    echo $defaultMonthSelect, $defaultDaySelect;
                                }
                                ?>
                                <select id="default_value_<?php echo $id; ?>_year" name="default_value_<?php echo $id; ?>[year]" onchange="iPhorm.updateDefaultDate(iPhorm.getElementById(<?php echo $id; ?>));">
                                    <?php if ($element['show_date_headings']) : ?><option value=""><?php echo esc_html($yearHeading); ?></option><?php endif; ?>
                                    <?php if ($sy > $ey) : ?>
                                        <?php for ($i = $sy; $i >= $ey; $i--) : ?>
                                            <option value="<?php echo $i; ?>" <?php selected($element['default_value']['year'], $i); ?>><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    <?php else : ?>
                                        <?php for ($i = $sy; $i <= $ey; $i++) : ?>
                                            <option value="<?php echo $i; ?>" <?php selected($element['default_value']['year'], $i); ?>><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </select>
                                <span class="ifb-refresh-default-value ifb-simple-tooltip" onclick="iPhorm.updateDatePreview(iPhorm.getElementById(<?php echo $id; ?>));" title="<?php esc_attr_e('Updates the default value options with your changes to other settings', 'iphorm'); ?>"><?php esc_html_e('Sync with changes', 'iphorm'); ?></span>
                            </td>
                        </tr>
                        <?php if (!isset($element['show_datepicker'])) $element['show_datepicker'] = true; ?>
                        <tr valign="top">
                            <th scope="row"><label for="show_datepicker_<?php echo $id; ?>"><?php esc_html_e('Show JavaScript datepicker', 'iphorm'); ?></label></th>
                            <td>
                                <input type="checkbox" id="show_datepicker_<?php echo $id; ?>" name="show_datepicker_<?php echo $id; ?>" <?php checked(true, $element['show_datepicker']); ?> onclick="iPhorm.toggleShowDatepicker(iPhorm.getElementById(<?php echo $id; ?>)); " />
                                <p class="description"><?php esc_html_e('If checked, the user can choose the date using the jQuery UI datepicker. To customize
                                    the calendar theme and localization, go to the form style settings at Settings &rarr; Style.', 'iphorm'); ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="months_as_numbers_<?php echo $id; ?>"><?php esc_html_e('Show months as numbers', 'iphorm'); ?></label></th>
                            <td>
                                <input type="checkbox" id="months_as_numbers_<?php echo $id; ?>" name="months_as_numbers_<?php echo $id; ?>" <?php checked(true, $element['months_as_numbers']); ?> />
                                <p class="description"><?php echo esc_html_e('Displays the months as numbers instead of text.', 'iphorm'); ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="field_order_<?php echo $id; ?>"><?php esc_html_e('Field order', 'iphorm'); ?></label></th>
                            <td>
                                <select id="field_order_<?php echo $id; ?>" name="field_order_<?php echo $id; ?>" onchange="iPhorm.updateDatePreview(iPhorm.getElementById(<?php echo $id; ?>));">
                                    <option value="eu" <?php selected($element['field_order'], 'eu'); ?>><?php echo esc_html_e('Day / Month (European)', 'iphorm'); ?></option>
                                    <option value="us" <?php selected($element['field_order'], 'us'); ?>><?php echo esc_html_e('Month / Day (US)', 'iphorm'); ?></option>
                                </select>
                                <p class="description"><?php esc_html_e('Change the ordering of the Day and Month fields.', 'iphorm'); ?></p>
                            </td>
                        </tr>
                        <?php $dateValidator = new iPhorm_Validator_Date();
                        if (!isset($element['date_validator_message_invalid'])) $element['date_validator_message_invalid'] = ''; ?>
                        <tr valign="top">
                            <th scope="row"><label for="date_validator_message_invalid_<?php echo $id; ?>"><?php esc_html_e('Error message if invalid date', 'iphorm'); ?></label></th>
                            <td>
                                <input type="text" id="date_validator_message_invalid_<?php echo $id; ?>" name="date_validator_message_invalid_<?php echo $id; ?>" value="<?php echo esc_attr($element['date_validator_message_invalid']); ?>" />
                                <p class="description"><?php printf(esc_html__('Translate or override the error message shown if the date is not valid. The
                                default is "%s".', 'iphorm'), '<span class="ifb-bold">' . $dateValidator->getMessageTemplate('invalid') . '</span>'); ?></p>
                            </td>
                        </tr>
                        <?php
                            if (!isset($element['date_format'])) $element['date_format'] = 'l, jS F Y';
                            $dateFormats = iphorm_get_date_formats();
                        ?>
                        <tr valign="top">
                            <th scope="row"><label for="date_format_<?php echo $id; ?>"><?php esc_html_e('Date format', 'iphorm'); ?></label></th>
                            <td>
                                <select id="date_format_<?php echo $id; ?>" name="date_format_<?php echo $id; ?>">
                                    <?php foreach ($dateFormats as $format => $example) : ?>
                                        <option value="<?php echo $format; ?>" <?php selected($element['date_format'], $format); ?>><?php echo esc_html($example); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="description"><?php esc_html_e('The format of the date when displayed in the notification email and when viewing entries', 'iphorm'); ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label><?php esc_html_e('Translations', 'iphorm'); ?></label></th>
                            <td>
                                <table class="ifb-form-table ifb-form-subtable">
                                    <tr>
                                        <th scope="row"><?php esc_html_e('Day', 'iphorm'); ?></th>
                                        <td><input type="text" id="day_heading_<?php echo $id; ?>" name="day_heading_<?php echo $id; ?>" value="<?php echo esc_attr($element['day_heading']); ?>" class="fullwidth-input" /></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php esc_html_e('Month', 'iphorm'); ?></th>
                                        <td><input type="text" id="month_heading_<?php echo $id; ?>" name="month_heading_<?php echo $id; ?>" value="<?php echo esc_attr($element['month_heading']); ?>" class="fullwidth-input" /></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php esc_html_e('Year', 'iphorm'); ?></th>
                                        <td><input type="text" id="year_heading_<?php echo $id; ?>" name="year_heading_<?php echo $id; ?>" value="<?php echo esc_attr($element['year_heading']); ?>" class="fullwidth-input" /></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?php include 'settings/tooltip-type.php'; ?>
                        <?php include 'settings/prevent-duplicates.php'; ?>
                        <?php include 'settings/conditional-logic.php'; ?>
                        <?php include 'settings/dynamic-default-value.php'; ?>
                        <?php include '_save.php'; ?>
                    </table>
                </div>
            </div>
            <div class="ifb-tabs-panel" id="ifb-element-settings-tab-advanced-<?php echo $id; ?>">
                <div class="ifb-element-settings-inner">
                    <table class="ifb-form-table ifb-element-settings-form-table ifb-element-settings-advanced-form-table">
                        <?php include 'settings/styles.php'; ?>
                        <?php include 'settings/selectors.php'; ?>
                        <?php include '_save.php'; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>