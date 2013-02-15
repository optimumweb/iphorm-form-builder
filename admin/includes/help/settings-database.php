<?php
if (!defined('IPHORM_VERSION')) exit;
include IPHORM_ADMIN_INCLUDES_DIR . '/help/_nav-settings.php';
?>
<div class="iphorm-help-right">
<h2>Database settings</h2>

<h3><span>Custom database settings (MySQL)</span></h3>
<h4>Use WordPress database</h4>
<p>If checked, the data will be inserted into a table you specify below,
inside the WordPress database. Un-check to specify your own database credentials</p>

<h4>Host</h4>
<p>Enter the location of the database server, usually <code>localhost</code>. You only need to
enter this if you are not using the WordPress database.</p>

<h4>Username</h4>
<p>Enter the database user username. This user should have INSERT permission on the database. You only need to
enter this if you are not using the WordPress database.</p>

<h4>Password</h4>
<p>Enter the database user password. You only need to
enter this if you are not using the WordPress database.</p>

<h4>Database name</h4>
<p>Enter the name of the database. You only need to
enter this if you are not using the WordPress database.</p>

<h4>Database table</h4>
<p>Enter the name of the table to insert data into.</p>

<h3><span>What to save</span></h3>
<h4>Save another form value</h4>
<p>Click the button to add another form value to save. Then enter the table field name and choose
which data you want to save into this field.</p>
</div>