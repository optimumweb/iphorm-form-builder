<?php
if (!defined('IPHORM_VERSION')) exit;
include IPHORM_ADMIN_INCLUDES_DIR . '/help/_nav-elements.php';
?>
<div class="iphorm-help-right">
<h2>Time Element</h2>
<p>The time element allows the user to enter a time.</p>
<h3><span>Configuration options</span></h3>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/label.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/description.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/required.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/admin-label.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/required-error-message.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/hide-from-email.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/save-to-database.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/label-placement.php'; ?>
<h4>12/24 hour time</h4>
<p>Switch between 12 hour and 24 hour clock</p>

<h4>Default value</h4>
<p>The time selected here will be the time selected by default when the form is displayed to the user.</p>

<h4>Minute granularity</h4>
<p>Determines how many minutes to show per hour. 1 will show all 60 minutes, 5 will show minutes at 5 minute intervals, 10 at 10 minute intervals and so on.</p>

<h4>Time format</h4>
<p>How the time will be displayed when viewing the submitted time.</p>

<h4>Translations</h4>
<p>Here you can translate the text am and pm.</p>

<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/tooltip-type.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/prevent-duplicates.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/conditional-logic.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/dynamic-default-value.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/styles.php'; ?>
</div>