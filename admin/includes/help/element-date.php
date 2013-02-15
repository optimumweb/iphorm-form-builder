<?php
if (!defined('IPHORM_VERSION')) exit;
include IPHORM_ADMIN_INCLUDES_DIR . '/help/_nav-elements.php';
?>
<div class="iphorm-help-right">
<h2>Date Element</h2>
<p>The date element allows the user to enter a date. A date validator is automatically registered with the
element so that the user can only enter a valid date. By default, a JavaScript datepicker is enabled
which all the user to select a date in the familiar calendar format.</p>
<h3><span>Configuration options</span></h3>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/label.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/description.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/required.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/admin-label.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/required-error-message.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/hide-from-email.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/save-to-database.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/label-placement.php'; ?>
<h4>Show date headings</h4>
<p>When checked, the drop down menus will display the headings Day, Month and Year.</p>

<h4>Start year</h4>
<p>The first year to show in the year dropdown. All years will be displayed between Start year and End year.</p>

<h4>End year</h4>
<p>The last year to show in the year dropdown. All years will be displayed between Start year and End year.</p>

<h4>Default value</h4>
<p>The date selected here will be the date selected by default when the form is displayed to the user.</p>

<h4>Show JavaScript datepicker</h4>
<p>If selected, a calender icon will show next to the date input fields. The user will now be able to click the icon to reveal a date picker to select their required date.</p>

<h4>Error message if invalid date</h4>
<p>The error message that is displayed if an invalid date is selected.</p>

<h4>Date format</h4>
<p>How the date will be displayed when viewing the submitted date.</p>

<h4>Translations</h4>
<p>Here you can translate the text Day, Month and Year that appear as dropdown headings.</p>

<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/tooltip-type.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/prevent-duplicates.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/conditional-logic.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/dynamic-default-value.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/styles.php'; ?>
</div>