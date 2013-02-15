<?php
if (!defined('IPHORM_VERSION')) exit;
include IPHORM_ADMIN_INCLUDES_DIR . '/help/_nav-elements.php';
?>
<div class="iphorm-help-right">
<h2>CAPTCHA Element</h2>
<p>The CAPTCHA element is an anti-spam element that requires the user to copy an image containing
random characters into a text field.</p>
<h3><span>Configuration options</span></h3>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/label.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/description.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/captcha.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/tooltip.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/required-error-message.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/label-placement.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/tooltip-type.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/conditional-logic.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/styles.php'; ?>
</div>