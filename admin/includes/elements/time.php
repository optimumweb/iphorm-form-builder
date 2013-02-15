<?php
if (!defined('IPHORM_VERSION')) exit;
$id = absint($element['id']);

if (!isset($element['label'])) $element['label'] = __('Time', 'iphorm');
if (!isset($element['description'])) $element['description'] = '';
if (!isset($element['required'])) $element['required'] = false;
if (!isset($element['time_12_24'])) $element['time_12_24'] = '12';
if (!isset($element['default_value'])) $element['default_value'] = array('hour' => '12', 'minute' => '00', 'ampm' => 'am');
if (!isset($element['minute_granularity'])) $element['minute_granularity'] = 1;
if (!isset($element['am_string'])) $element['am_string'] = '';
if (!isset($element['pm_string'])) $element['pm_string'] = '';

$amString = strlen($element['am_string']) ? $element['am_string'] : _x('am', 'time, morning', 'iphorm');
$pmString = strlen($element['pm_string']) ? $element['pm_string'] : _x('pm', 'time, evening', 'iphorm');
$helpUrl = iphorm_help_link('element-time');
?>
<div id="ifb-element-wrap-<?php echo $id; ?>" class="ifb-element-wrap ifb-element-wrap-time <?php if (!$element['required']) echo 'ifb-element-optional'; ?> <?php echo "ifb-label-placement-{$form['label_placement']}"; ?>">
	<div class="ifb-top-element-wrap clearfix">
        <?php include IPHORM_ADMIN_INCLUDES_DIR . '/elements/_actions.php'; ?>
        <div class="ifb-element-preview ifb-element-preview-time">
            <label class="ifb-preview-label <?php echo ($element['label']) ? '' : 'ifb-hidden' ?>" for="ifb_element_<?php echo $id; ?>"><span class="ifb-preview-label-content"><?php echo $element['label']; ?></span><span class="ifb-required"><?php echo esc_html($form['required_text']); ?></span></label>
            <div class="ifb-preview-input">
                <select id="ifb_element_<?php echo $id; ?>_hour" name="ifb_element_<?php echo $id; ?>[hour]" disabled="disabled">
                    <?php if ($element['time_12_24'] == '24') : ?>
                        <?php foreach (range(0, 23) as $hour) : ?>
                            <?php $hour = str_pad($hour, 2, '0', STR_PAD_LEFT); ?>
                            <option value="<?php echo $hour; ?>" <?php selected($element['default_value']['hour'], $hour); ?>><?php echo $hour; ?></option>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <?php foreach (range(1, 12) as $hour) : ?>
                            <?php $hour = str_pad($hour, 2, '0', STR_PAD_LEFT); ?>
                            <option value="<?php echo $hour; ?>" <?php selected($element['default_value']['hour'], $hour); ?>><?php echo $hour; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <select id="ifb_element_<?php echo $id; ?>_minute" name="ifb_element_<?php echo $id; ?>[minute]" disabled="disabled">
                    <?php foreach (range(0, 59) as $min) : ?>
                        <?php if ($min % $element['minute_granularity'] == 0) : ?>
                            <?php $min = str_pad($min, 2, '0', STR_PAD_LEFT); ?>
                            <option value="<?php echo $min; ?>" <?php selected($element['default_value']['minute'], $min); ?>><?php echo $min; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <select id="ifb_element_<?php echo $id; ?>_ampm" name="ifb_element_<?php echo $id; ?>[ampm]" <?php if ($element['time_12_24'] == '24') echo 'class="ifb-hidden"'; ?> disabled="disabled">
                    <option value="am" <?php selected($element['default_value']['ampm'], 'am'); ?>><?php echo esc_html($amString); ?></option>
                    <option value="pm" <?php selected($element['default_value']['ampm'], 'pm'); ?>><?php echo esc_html($pmString); ?></option>
                </select>
                <p class="ifb-preview-description <?php if (!strlen($element['description'])) echo 'ifb-hidden'; ?>"><?php echo $element['description']; ?></p>
            </div>
            <span class="ifb-handle"></span>
        </div>
    </div>
    <div class="ifb-element-settings ifb-element-settings-time">
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
                            <th scope="row"><label for="time_12_24_<?php echo $id; ?>"><?php esc_html_e('12/24 hour time', 'iphorm'); ?></label></th>
                            <td>
                                <select id="time_12_24_<?php echo $id; ?>" name="time_12_24_<?php echo $id; ?>" onchange="iPhorm.updateTimePreview(iPhorm.getElementById(<?php echo $id; ?>));">
                                    <option value="12" <?php selected($element['time_12_24'], '12'); ?>><?php esc_html_e('12 hour', 'iphorm'); ?></option>
                                    <option value="24" <?php selected($element['time_12_24'], '24'); ?>><?php esc_html_e('24 hour', 'iphorm'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label><?php esc_html_e('Default value', 'iphorm'); ?></label></th>
                            <td>
                                <select id="default_value_<?php echo $id; ?>_hour" name="default_value_<?php echo $id; ?>[hour]" onchange="iPhorm.updateTimePreview(iPhorm.getElementById(<?php echo $id; ?>));">
                                    <?php if ($element['time_12_24'] == '24') : ?>
                                        <?php foreach (range(0, 23) as $hour) : ?>
                                            <?php $hour = str_pad($hour, 2, '0', STR_PAD_LEFT); ?>
                                            <option value="<?php echo $hour; ?>" <?php selected($element['default_value']['hour'], $hour); ?>><?php echo $hour; ?></option>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <?php foreach (range(1, 12) as $hour) : ?>
                                            <?php $hour = str_pad($hour, 2, '0', STR_PAD_LEFT); ?>
                                            <option value="<?php echo $hour; ?>" <?php selected($element['default_value']['hour'], $hour); ?>><?php echo $hour; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <select id="default_value_<?php echo $id; ?>_minute" name="default_value_<?php echo $id; ?>[minute]" onchange="iPhorm.updateTimePreview(iPhorm.getElementById(<?php echo $id; ?>));">
                                    <?php foreach (range(0, 59) as $min) : ?>
                                        <?php if ($min % $element['minute_granularity'] == 0) : ?>
                                            <?php $min = str_pad($min, 2, '0', STR_PAD_LEFT); ?>
                                            <option value="<?php echo $min; ?>" <?php selected($element['default_value']['minute'], $min); ?>><?php echo $min; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <select id="default_value_<?php echo $id; ?>_ampm" name="default_value_<?php echo $id; ?>[ampm]" onchange="iPhorm.updateTimePreview(iPhorm.getElementById(<?php echo $id; ?>));" <?php if ($element['time_12_24'] == '24') echo 'class="ifb-hidden"'; ?>>
                                    <option value="am" <?php selected($element['default_value']['ampm'], 'am'); ?>><?php echo esc_html($amString); ?></option>
                                    <option value="pm" <?php selected($element['default_value']['ampm'], 'pm'); ?>><?php echo esc_html($pmString); ?></option>
                                </select>
                                <span class="ifb-refresh-default-value ifb-simple-tooltip" onclick="iPhorm.updateTimePreview(iPhorm.getElementById(<?php echo $id; ?>));" title="<?php esc_attr_e('Updates the default value options with your changes to other settings', 'iphorm'); ?>"><?php esc_html_e('Sync with changes', 'iphorm'); ?></span>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <div class="ifb-tooltip"><div class="ifb-tooltip-content">
                                    <?php esc_html_e('Determines how many minutes to show per hour. 1 will show all 60 minutes, 5 will show minutes at 5 minute intervals, 10 at 10 minute intervals and so on.', 'iphorm'); ?>
                                </div></div>
                                <label for="minute_granularity_<?php echo $id; ?>"><?php esc_html_e('Minute granularity', 'iphorm'); ?></label>
                            </th>
                            <td>
                                <select id="minute_granularity_<?php echo $id; ?>" name="minute_granularity_<?php echo $id; ?>" onchange="iPhorm.updateTimePreview(iPhorm.getElementById(<?php echo $id; ?>));">
                                    <option value="1" <?php selected($element['minute_granularity'], 1); ?>>1</option>
                                    <option value="5" <?php selected($element['minute_granularity'], 5); ?>>5</option>
                                    <option value="10" <?php selected($element['minute_granularity'], 10); ?>>10</option>
                                    <option value="15" <?php selected($element['minute_granularity'], 15); ?>>15</option>
                                    <option value="20" <?php selected($element['minute_granularity'], 20); ?>>20</option>
                                    <option value="30" <?php selected($element['minute_granularity'], 30); ?>>30</option>
                                </select>
                            </td>
                        </tr>
                        <?php
                            if (!isset($element['time_format'])) $element['time_format'] = 'g:i a';
                            $timeFormats = iphorm_get_time_formats();
                        ?>
                        <tr valign="top">
                            <th scope="row"><label for="time_format_<?php echo $id; ?>"><?php esc_html_e('Time format', 'iphorm'); ?></label></th>
                            <td>
                                <select id="time_format_<?php echo $id; ?>" name="time_format_<?php echo $id; ?>">
                                    <?php foreach ($timeFormats as $format => $example) : ?>
                                        <option value="<?php echo $format; ?>" <?php selected($element['time_format'], $format); ?>><?php echo esc_html($example); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="description"><?php esc_html_e('The format of the time when displayed in the notification email and when viewing entries', 'iphorm'); ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label><?php esc_html_e('Translations', 'iphorm'); ?></label></th>
                            <td>
                                <table class="ifb-form-table ifb-form-subtable">
                                    <tr>
                                        <th scope="row"><?php esc_html_e('am', 'iphorm'); ?></th>
                                        <td><input type="text" id="am_string_<?php echo $id; ?>" name="am_string_<?php echo $id; ?>" value="<?php echo esc_attr($element['am_string']); ?>" class="ifb-smallish-input" /></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php esc_html_e('pm', 'iphorm'); ?></th>
                                        <td><input type="text" id="pm_string_<?php echo $id; ?>" name="pm_string_<?php echo $id; ?>" value="<?php echo esc_attr($element['pm_string']); ?>" class="ifb-smallish-input" /></td>
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