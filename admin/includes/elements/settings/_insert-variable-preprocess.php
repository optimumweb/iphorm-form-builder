<?php
if (!defined('IPHORM_VERSION')) exit;
$dateFormats = iphorm_get_date_formats();
$timeFormats = iphorm_get_time_formats();
?><select class="ifb-insert-variable-preprocess" onchange="iPhorm.insertVariable('#default_value_<?php echo $id; ?>', this);">
	<option value=""><?php esc_html_e('Insert variable...', 'iphorm'); ?></option>
	<option value="{ip}"><?php esc_html_e('User IP address', 'iphorm'); ?></option>
	<option value="{post_id}"><?php esc_html_e('Form post/page ID', 'iphorm'); ?></option>
	<option value="{post_title}"><?php esc_html_e('Form post/page title', 'iphorm'); ?></option>
	<option value="{url}"><?php esc_html_e('Form URL', 'iphorm'); ?></option>
	<option value="{user_display_name}"><?php esc_html_e('User display name', 'iphorm'); ?></option>
	<option value="{user_email}"><?php esc_html_e('User email', 'iphorm'); ?></option>
	<option value="{user_login}"><?php esc_html_e('User login', 'iphorm'); ?></option>
	<option value="{referring_url}"><?php esc_html_e('Referring URL', 'iphorm'); ?></option>
	<optgroup label="<?php esc_attr_e('Date (select a format)', 'iphorm'); ?>">
		<?php foreach ($dateFormats as $dateFormat => $dateExample) : ?>
		<option value="{current_date|<?php echo $dateFormat; ?>}"><?php echo esc_html($dateExample); ?></option>
		<?php endforeach; ?>
	</optgroup>
		<optgroup label="<?php esc_attr_e('Time (select a format)', 'iphorm'); ?>">
		<?php foreach ($timeFormats as $timeFormat => $timeExample) : ?>
		<option value="{current_time|<?php echo $timeFormat; ?>}"><?php echo esc_html($timeExample); ?></option>
		<?php endforeach; ?>
	</optgroup>
</select>