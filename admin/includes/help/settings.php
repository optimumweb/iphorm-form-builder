<?php
if (!defined('IPHORM_VERSION')) exit;
include IPHORM_ADMIN_INCLUDES_DIR . '/help/_nav-settings.php';
?>
<div class="iphorm-help-right">
<h2>Settings</h2>
<p>Click through for more documentation.</p>
<ul>
    <li><a href="<?php echo iphorm_help_link('settings-global'); ?>"><?php esc_html_e('Global plugin settings', 'iphorm'); ?></a></li>
    <li><a href="<?php echo iphorm_help_link('settings-general'); ?>"><?php esc_html_e('General settings', 'iphorm'); ?></a></li>
    <li><a href="<?php echo iphorm_help_link('settings-style'); ?>"><?php esc_html_e('Style settings', 'iphorm'); ?></a></li>
    <li><a href="<?php echo iphorm_help_link('settings-email'); ?>"><?php esc_html_e('Email settings', 'iphorm'); ?></a></li>
    <li><a href="<?php echo iphorm_help_link('settings-entries'); ?>"><?php esc_html_e('Entries settings', 'iphorm'); ?></a></li>
    <li><a href="<?php echo iphorm_help_link('settings-database'); ?>"><?php esc_html_e('Database settings', 'iphorm'); ?></a></li>
</ul>
</div>