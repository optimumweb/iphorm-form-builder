<?php
if (!defined('IPHORM_VERSION')) exit;
include IPHORM_ADMIN_INCLUDES_DIR . '/help/_nav-elements.php';
?>
<div class="iphorm-help-right">
<h2>reCAPTCHA Element</h2>
<p>The reCAPTCHA element is an effective anti-spam element from Google, it requires the user to type
two distorted words.</p>
<h3><span>Configuration options</span></h3>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/label.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/description.php'; ?>
<h4>Theme</h4>
<p>You can choose a reCAPTCHA theme here. Choose a theme to see a preview.</p>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/required-error-message.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/label-placement.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/tooltip-type.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/conditional-logic.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/styles.php'; ?>
</div>