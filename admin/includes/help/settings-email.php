<?php
if (!defined('IPHORM_VERSION')) exit;
include IPHORM_ADMIN_INCLUDES_DIR . '/help/_nav-settings.php';
?>
<div class="iphorm-help-right">
<h2>Email settings</h2>

<h3><span>Notification email settings</span></h3>
<p>The notification email is the email sent out when the form has been successfully submitted. By default
the email contains all the form data you haven't chosen to hide from the email.</p>
<h4>Send form data via email</h4>
<p>If checked, when the user submits the form the submitted form data will be sent in
an email to the recipients specified.</p>
<h4>Recipients</h4>
<p>The email addresses that will be sent the form data.</p>
<h4>Conditional recipients</h4>
<p>Send the form data to different email addresses depending on the submitted values. This
required at least one dropdown menu on multiple choice element in your form. Click
<span class="ifb-bold">Add a new rule</span> to create a new conditional rule. Enter the email
address of the recipient and the conditions on which the email should be sent to them.</p>
<h4>"Reply-To" address</h4>
<p>When you compose a reply to the notification email (in your email software, for example), it will be addressed to the
email address submitted in this field.</p>
<h4>Email subject</h4>
<p>The subject of the notification email, you can also insert variables such as submitted form values.
See the Insert variable... dropdown to see what's available.</p>
<h4>Customize email content</h4>
<p>Check to override the default notification email content. The default notification email may
be sufficient in most cases, it sends out all the form data to you. You should submit the form
to see the default email content before you decide to override it.</p>
<h4>Email content<a name="notification-email-content" id="notification-email-content"></a></h4>
<p>Enter the desired content of the email inside the large box. You can switch the email format
to HTML or plain text. In <span class="ifb-bold">HTML format</span> you are free to enter any HTML and this will be rendered
inside the email in a similar manner to HTML on a website. You can enter new lines using the
<code>&lt;br /&gt;</code> tag for example.</p>
<p>In <span class="ifb-bold">plain text format</span> what you type is what you will see in the email, to enter a new line just
press enter, HTML formatting will not work (the HTML tags will be visible in the email text).</p>
<p>You can also enter variable data such as the data or time the form was submitted, the user's IP and more.
To enter a submitted form value, choose the element from under the <span class="ifb-bold">Submitted form value</span>
group inside the Insert variable... dropdown menu.</p>
<h4>"From" address<a name="from-type" id="from-type"></a></h4>
<h5>Static email address</h5>
<p>Specify the email address and optionally the name of the sender of the email, this will
appear next to the email in the inbox. Note: some hosting companies require that the "From" address is an email address
that is associated with a domain in your hosting account, bear that in mind if you are having problems with receiving emails.</p>
<h5>Submitted email address</h5>
<p>You can also choose to have the From address set to the submitted value of an Email field in your form.
You will need to have at least one Email element in your form. Choose the element that you want the submitted
value to be set as the From address. <span class="ifb-bold">Warning:</span> some hosting companies require that the "From" address is an email address
that is associated with a domain in your hosting account. If you set this to a user submitted value, your
host may block the emails being sent. Test it thoroughly with email addresses not associated with your
hosting account to make sure that all emails will be received correctly.</p>
<h3><span>Autoreply email settings (optional)</span></h3>
<h4>Send autoreply email</h4>
<p>Tick this box, to send an autoreply to the form submitter. You'll need at least one Email
element in your form so the script knows who to send the autoreply email to. You can specify
this in the setting below.</p>
<h4>Recipient element</h4>
<p>Choose the Email element from the form that you would like the autoreply email to be sent to.
That is, it will be sent to the email address in this field when the form is submitted.</p>
<h4>Email subject</h4>
<p>Specify the subject of the autoreply email, you can also insert variable data such as a
submitted form value using the Insert variable... dropdown menu.</p>
<h4>Email content</h4>
<p>Enter the desired content of the email inside the large box. You can switch the email format
to HTML or plain text. In <span class="ifb-bold">HTML format</span> you are free to enter any HTML and this will be rendered
inside the email in a similar manner to HTML on a website. You can enter new lines using the
<code>&lt;br /&gt;</code> tag for example.</p>
<p>In <span class="ifb-bold">plain text format</span> what you type is what you will see in the email, to enter a new line just
press enter, HTML formatting will not work (the HTML tags will be visible in the email text).</p>
<p>You can also enter variable data such as the data or time the form was submitted, the user's IP and more.
To enter a submitted form value, choose the element from under the <span class="ifb-bold">Submitted form value</span>
group inside the Insert variable... dropdown menu.</p>
<h4>"From" address<a name="autoreply-from-type" id="autoreply-from-type"></a></h4>
<h5>Static email address</h5>
<p>Specify the email address and optionally the name of the sender of the email, this will
appear next to the email in the inbox. Note: some hosting companies require that the "From" address is an email address
that is associated with a domain in your hosting account, bear that in mind if you are having problems with receiving emails.</p>
<h5>Submitted email address</h5>
<p>You can also choose to have the From address set to the submitted value of an Email field in your form.
You will need to have at least one Email element in your form. Choose the element that you want the submitted
value to be set as the From address. <span class="ifb-bold">Warning:</span> some hosting companies require that the "From" address is an email address
that is associated with a domain in your hosting account. If you set this to a user submitted value, your
host may block the emails being sent. Test it thoroughly with email addresses not associated with your
hosting account to make sure that all emails will be received correctly.</p>
<h3><span>Email sending settings</span></h3>
<h4>Email sending method</h4>
<p>Choose the method by which the emails are sent. The valid options are:</p>
<ul>
    <li>Use global setting (default) - uses whatever value is set in the Quform global settings at Quform &rarr; Settings</li>
    <li>PHP mail() - send the email using the PHP mail() function</li>
    <li>SMTP - send the email using an SMTP server, upon selecting this option more fields will appear where you can enter
    your SMTP settings</li>
</ul>
</div>