<?php
if (!defined('IPHORM_VERSION')) exit;
include IPHORM_ADMIN_INCLUDES_DIR . '/help/_nav-settings.php';
?>
<div class="iphorm-help-right">
<h2>General settings</h2>

<h3><span>Form information</span></h3>
<h4>Name</h4>
<p>The name you enter here will help you identify the form within WordPress, it will not appear on
a form on your website.</p>
<h4>Title</h4>
<p>The title of your form will appear before the form elements.</p>
<h4>Description</h4>
<p>The description will appear underneath the title, useful for giving the form user
instructions or information about your form.</p>
<h4>Active</h4>
<p>Toggle between setting the form active or inactive. Active forms will appear on your website, inactive
forms will not.</p>

<h3><span>Successful submit options</span></h3>
<h4>On successful submit</h4>
<p>Choose to either display a message or redirect to another page when the form is successfully submitted.</p>
<h4>Message</h4>
<p>Enter the message for the form user to see when the form is successfully submitted. You can insert submitted form data into the success message,
and other varibles, by choosing one of the options from the "Insert variables..." dropdown menu.</p>
<h4>Message position</h4>
<p>Choose to either display the message above or below the form.</p>
<h4>Message timeout</h4>
<p>Choose the number of seconds after which the success message will fade out and disappear. You can
enter a fraction of seconds e.g. <code>0.5</code>. If set to 0 then the success message will not disappear.</p>
<h4>Redirect to</h4>
<p>Choose whether the redirect to a page, post or URL.</p>

<h3><span>More options</span></h3>
<h4>Submit button text</h4>
<p>Override the default text of the submit button which is "Send".</p>
<h4>Use Ajax</h4>
<p>When enabled, the form will submit without reloading the page</p>
<h4>Enable honeypot CAPTCHA</h4>
<p>A hidden anti-spam measure that requires no user interaction</p>

<h3><span>Make money and support Quform!</span></h3>
<h4>Display a referral link</h4>
<p>Check to show a referral link underneath the form.</p>
<h4>Referral link text</h4>
<p>The text of the referral link.</p>
<h4>ThemeForest / CodeCanyon username</h4>
<p>Enter your ThemeForest or CodeCanyon username and you will receive 30% of the first deposit
or purchase amount from any referrals when users click on your referral link.
<a onclick="window.open(this.href); return false;" href="http://themeforest.net/wiki/referral/referral-program/">More information</a>.</p>
</div>