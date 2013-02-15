<?php if (!defined('IPHORM_VERSION')) exit; ?><h4>Enable Flash uploader<a class="iphorm-help-anchor" id="enable-swf" name="enable-swf"></a></h4>
<p>Enables the SWFUpload flash file upload functionality, which shows the progress of file uploads
when the form is submitted. Uncheck to use normal web browser file uploading. Note: users without
Flash installed will not be able to use this and they will see a normal web browser file upload field.</p>

<h4>Allow multiple file uploads</h4>
<p>Enables you to add more than one upload field grouped under the one element configuration.
If you have the Flash uploader enabled then the user can upload as many files as they want. For
normal web browser uploads and Uniform file upload fields, you can choose to show more than one upload
field and optionally allow the user to add more upload fields.</p>

<h4>Number of file upload fields to show</h4>
<p>How many file upload fields to show. If you have enabled the Flash uploader, you can upload more
than one file using one upload field so only one upload field is shown. For users with Flash disabled, or if you have disabled it here,
they will see this number of upload fields.</p>

<h4>Allow the user to add more upload fields</h4>
<p>If checked a link appears under the file upload fields that allows the user
to add more upload fields to upload more files. If you have enabled the Flash uploader, this
will not appear for users with Flash enabled. For users with JavaScript enabled, the link will be shown.</p>

<h4>Add another upload link text</h4>
<p>Override the default text for the add another upload link which is "Upload another".</p>

<h4>Allowed file extensions</h4>
<p>The element will not accept any file extensions other than those added here. Enter the extensions
separated by commas and without the dot, e.g. <code>jpg, png, gif</code>. If left blank, all
file extensions are allowed (this is NOT recommended for security reasons, as malicious users could
upload and execute a PHP script for example).</p>

<h4>Maximum allowed file size<a class="iphorm-help-anchor" name="upload-maximum-size" id="upload-maximum-size"></a></h4>
<p>The maximum allowed size of a single file.</p>
<p>The total of all maximum allowed file sizes for all your upload fields should be less than your PHP value <span class="ifb-bold">post_max_size</span>
which is currently: <?php echo (int) ini_get('post_max_size'); ?>MB</p>
<p>The maximum of a single file upload should not exceed the PHP
setting <span class="ifb-bold">upload_max_filesize</span> which is currently: <?php echo (int) ini_get('upload_max_filesize'); ?>MB</p>
<p>If you are attaching the file to the notification email,
you should make sure that your PHP memory limit is about 8-10 times the maximum file size. Your
PHP setting <span class="ifb-bold">memory_limit</span> is currently <?php echo (int) ini_get('memory_limit'); ?>MB</p>
<p>If you are not attaching the file to the email, but storing it on the server instead you can probably
safely upload a file much larger than this. If in doubt, upload a test file at your maximum limit and
see if the form works correctly.</p>

<h4>Attach uploaded files to the notification email</h4>
<p>When checked, any uploaded files will be sent out as attachments with the notification email.</p>

<h4>Save uploaded files to the server</h4>
<p>When checked, any uploaded files will be saved to the server.</p>

<h4>Path to save uploaded files</h4>
<p>The path to save the uploaded files inside the WordPress uploads folder. See
the tooltip for available placeholders.</p>

<h4>Browse button text</h4>
<p>Override/translate the text of the Browse button for file uploads. This will only be used
if using the Flash uploader or Uniform is enabled.</p>

<h4>Default text</h4>
<p>Specify the default text for the file upload input. This is only shown when the Flash
uploader is disabled and Uniform is enabled (since the Flash uploader replaces the
file input) or if the user doesn't have Flash but JavaScript is enabled.</p>

<h4>Translate error messages</h4>
<p>You can translate or change any of the default error messages, by entering your message in the text
field next to the original error message.</p>
