<?php
if (!defined('IPHORM_VERSION')) exit;
include IPHORM_ADMIN_INCLUDES_DIR . '/help/_nav-settings.php';
?>
<div class="iphorm-help-right">
    <h2>Global settings</h2>
    <p>The global plugin settings can be accessed by going to Quform &rarr; Settings on the WordPress menu.</p>

    <h3><span>Product license</span><a id="find-licence" class="find-licence"></a></h3>
    <p>Enter your license key as found in your CodeCanyon license certificate. See below for instructions on
    how to find your license key.</p>
    <ol>
        <li>Log in to CodeCanyon and go to the your <span class="ifb-bold">Downloads</span> tab.</li>
        <li>Next to the icon you should find a link called Licence Certificate<br /><img src="<?php echo IPHORM_ADMIN_URL . '/images/licence-key-step1.png'; ?>" alt="" /></li>
        <li>Click the link and download the .txt file</li>
        <li>Inside the file, you'll see a line containing the text Item Purchase Code: [Your license key]<br /><img src="<?php echo IPHORM_ADMIN_URL . '/images/licence-key-step2.png'; ?>" alt="" /></li>
        <li>This code is your license key, enter the key into the <span class="ifb-bold">Quform &rarr; Settings</span> page to verify the plugin and activate the license.</li>
    </ol>

    <h3><span>reCAPTCHA settings</span></h3>
    <p>Enter your reCAPTCHA API keys, which you can get from <a href="https://www.google.com/recaptcha/admin/create?app=iphorm-form-builder" target="_blank">here</a>.</p>

    <h3><span>Email sending settings</span></h3>
    <p>You can decide to have the plugin send emails via the PHP mail() function or
    via an SMTP server. If you choose the SMTP option you will be given more fields to
    enter your SMTP settings.</p>

    <h3><span>Update active themes cache</span></h3>
    <p>If you have added or removed a form from the database directly, e.g. via phpMyAdmin
    then you should tick the box below and Save Changes to make sure the correct themes are being
    loaded for all your active forms.</p>
</div>