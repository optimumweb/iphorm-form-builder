<?php
if (!defined('IPHORM_VERSION')) exit;
include IPHORM_ADMIN_INCLUDES_DIR . '/help/_nav-elements.php';
?>
<div class="iphorm-help-right">
<h2>Hidden Element</h2>
<p>The hidden element can be used to pass information into the submitted form without the user
seeing it, such as the URL of the form, the current date etc.</p>
<h3><span>Configuration options</span></h3>
<h4>Label</h4>
<p>The label will be shown in the default notification email, to distinguish the element from others.
It will not be shown to the user.</p>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/default.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/hide-from-email.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/save-to-database.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/dynamic-default-value.php'; ?>
</div>