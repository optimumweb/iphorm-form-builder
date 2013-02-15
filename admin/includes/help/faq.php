<?php
if (!defined('IPHORM_VERSION')) exit;
include IPHORM_ADMIN_INCLUDES_DIR . '/help/_nav-faq.php';
?>
<div class="iphorm-help-right">
<h2>Frequently asked questions</h2>

<h2>License</h2>
<ul>
    <li><a href="#find-licence">How do I find my license key?</a></li>
    <li><a href="#use-multi-licence">How can I legally use the plugin on more than website at a time?</a></li>
</ul>

<h2>Styling &amp; layout</h2>
<ul>
    <li><a href="#styling-css">How do I make minor CSS changes to the form?</a></li>
    <li><a href="#styling-column">How do I make a two column layout?</a></li>
    <li><a href="#styling-submit">How do I change the text of the submit button?</a></li>
    <li><a href="#styling-required">How do I change the (required) text?</a></li>
</ul>

<h2>On your website</h2>
<ul>
    <li><a href="#website-lightbox">How do I put my form into a lightbox (popup)?</a></li>
    <li><a href="#website-google">Can I integrate the form with Google AdWords conversion tracking?</a></li>
    <li><a href="#website-mailchimp">Can I integrate the form with MailChimp?</a></li>
    <li><a href="#website-aweber">Can I integrate the form with Aweber?</a></li>
</ul>

<h2>Email</h2>

<ul>
    <li><a href="#email-notif">How do I customize the notifcation email?</a></li>
    <li><a href="#email-autoreply">How do I send an autoreply?</a></li>
    <li><a href="#email-cust-autoreply">How do I customize the autoreply email?</a></li>
    <li><a href="#email-smtp">How do I use SMTP to send the email?</a></li>
</ul>

<h2>Entries</h2>

<ul>
    <li><a href="#entry-layout">How do I change the layout of the entries list?</a></li>
    <li><a href="#entry-hide">How do I show/hide form values on the view entry page?</a></li>
    <li><a href="#entry-export">Can I export my entries to a spreadsheet e.g. Excel?</a></li>
</ul>

<h2>Translating</h2>
<ul>
    <li><a href="#translate">How do I translate the plugin?</a></li>
</ul>


<h2>Themes</h2>
<ul>
    <li><a href="#create-theme">How do I create a theme?</a></li>
    <li><a href="#sell-theme">Can I sell my theme?</a></li>
    <li><a href="#skill-theme">What skills do I require?</a></li>
    <li><a href="#long-theme">How long will it take?</a></li>
    <li><a href="#many-theme">How many can I make?</a></li>
    <li><a href="#promote-theme">Will ThemeCatcher help promote my theme?</a></li>
</ul>

<h2>Troubleshooting</h2>

<ul>
    <li><a href="#bad-formatter">There are big gaps between my form elements and my form does not work properly</a></li>
    <li><a href="#bug">Found a bug?</a></li>
    <li><a href="#more-support">Need more support?</a></li>
</ul>

<!-- Start answers -->

<h2>License<a class="iphorm-help-anchor" name="faq-licence" id="faq-licence">&nbsp;</a></h2>

<h3><span>How do I find my license key?<a class="iphorm-help-anchor" name="find-licence" id="find-licence">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>See the instuctions on <a href="<?php echo iphorm_help_link('settings-global#find-licence'); ?>">this page</a>.</p>

<h3><span>How can I legally use the plugin on more than website at a time?<a class="iphorm-help-anchor" name="use-multi-licence" id="use-multi-licence">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>You will need to purchase another licence key, by buying the plugin on CodeCanyon again.
You'll get a unique licence key that you can use on your other website. A single licence
key can only be active on one WordPress installation at a time.</p>

<h2>Styling &amp; layout<a class="iphorm-help-anchor" name="faq-styling" id="faq-styling">&nbsp;</a></h2>

<h3><span>How do I make minor CSS changes to the form?<a class="iphorm-help-anchor" name="styling-css" id="styling-css">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>In the Advanced tab of each element settings, you can add and remove CSS styles that will be applied to
the part of the form described by the button text. There is also a global CSS styles section at
<span class="ifb-bold">Settings &rarr; Style &rarr; Global styling</span> in the form builder. Styles added in the global
section will be applied to each element in the form.</p>

<p>For more control, you can create a file named <code>custom.css</code> and place it into the <code>/css/</code> folder.
This file will be loaded after all other Quform related stylesheets on your website so it's the
perfect place to add in CSS overrides. If you use exactly the same selector as one discovered
from a stylesheet loaded above it, for example a theme, the styles you add to this file will override
the theme styles. Firebug is a great tool for quickly finding the selectors that are styling something.
You can also style the individual elements in this file, by
using the selectors found in the Advanced tab of the element settings. For more flexibility than
this you will need to create a theme, see the Theming section below.</p>

<h3><span>How do I make a two column layout?<a class="iphorm-help-anchor" name="styling-column" id="styling-column">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>Please see <a class="iphorm-external" href="http://www.youtube.com/user/ThemeCatcher#p/u/3/0YnLH3h44Vw">this video tutorial</a>. You
can use the same technique to create 3, 4 and 5 column layouts.</p>

<h3><span>How do I change the text of the submit button?<a class="iphorm-help-anchor" name="styling-submit" id="styling-submit">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>In the form settings go to <span class="ifb-bold">Settings &rarr; General &rarr; More options</span> you will see
an option called <span class="ifb-bold">Submit button text</span>, enter the text into the field that you
would like for your submit button.</p>

<h3><span>How do I change the (required) text?<a class="iphorm-help-anchor" name="styling-required" id="styling-required">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>In the form builder, go to the form label settings at <span class="ifb-bold">Settings &rarr; Style &rarr; Labels</span>,
you will see an option called <span class="ifb-bold">Required indicator text</span>, enter your custom text in this field.</p>

<h2>On your website<a class="iphorm-help-anchor" name="faq-website" id="faq-website">&nbsp;</a></h2>

<h3><span>How do I put my form into a lightbox (popup)?<a class="iphorm-help-anchor" name="website-lightbox" id="website-lightbox">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>There are three different ways to do this, depending on where you want to display the trigger to show the form.</p>

<h4>Inside a page / post</h4>
<p>When editing or adding the page/post, click the Quform icon above the visual editor. A popup should
appear where you can select the form you want to insert. There is an option under this that you can
tick to have the form display in a popup instead of in the page content. Once you click insert, the
popup will close and a shortcode will appear inside the visual editor. You can change the text between
the opening and closing shortcodes to the HTML or text you would like to trigger the popup window to
show your form.</p>
<h5>Fancybox options (advanced)</h5>
<p>Advanced users may want to pass options to the Fancybox script. You can do this by adding another
attribute to the opening shortcode, called "options" and pass in a JSON formatted string of options.
For example, to set the overlay opacity to 0.8, use the code below:</p>
<pre>[iphorm_popup id=1 name="Contact us" <strong>options="{ overlayOpacity: 0.8 }"</strong>]
Contact us[/iphorm_popup]</pre>
<p>Note: we have added code to automatically resize the Fancybox window to wrap your form size. If you need
to set the exact size of Fancybox you will need to disable this by passing in 2 additional options, see below.</p>
<pre>{ width: 400, height: 400, autoDimensions: false<strong>, onStart: null, onComplete: null</strong> }</pre>
<p>See the <a href="http://fancybox.net/api" class="iphorm-external">Fancybox Options API</a> for a list of all available options.</p>

<h4>As a widget<a class="iphorm-help-anchor" name="website-lightbox-widget-options" id="website-lightbox-widget-options">&nbsp;</a></h4>
<p>On the WordPress menu, go to <span class="ifb-bold">Appearances &rarr; Widgets</span>, you should
see a widget named <span class="ifb-bold">Quform Popup</span> in the Available Widgets area.
Drag the widget to one of the widget-enabled areas on the right hand side. You can then optionally
enter a title for the widget, choose the form you want to show and enter the HTML or text content
to trigger the popup.</p>
<h5>Fancybox options (advanced)</h5>
<p>Advanced users may want to pass options to the Fancybox script. You can do this by entering
 a JSON formatted string of options to the <span class="ifb-bold">Fancybox options</span> field.
For example, to set the overlay opacity to 0.8, use the code below:</p>
<pre>{ overlayOpacity: 0.8 }</pre>
<p>Note: we have added code to automatically resize the Fancybox window to wrap your form size. If you need
to set the exact size of Fancybox you will need to disable this by passing in 2 additional options, see below.</p>
<pre>{ width: 400, height: 400, autoDimensions: false<strong>, onStart: null, onComplete: null</strong> }</pre>
<p>See the <a href="http://fancybox.net/api" class="iphorm-external">Fancybox Options API</a> for a list of all available options.</p>

<h4>Inside a WordPress template PHP file</h4>
<p>You can also add the form in a popup to one of your WordPress template PHP files. The PHP function to
use is shown below and it accepts 3 parameters:</p>
<pre><code>iphorm_popup($formId, $content, $options)</code> </pre>
<ul>
    <li>$formId - The form ID [integer]</li>
    <li>$content - The text/HTML to trigger the popup [string]</li>
    <li>$options - JSON formatted options for the Fancybox script [string] (optional)</li>
</ul>
<p>To safely add the code you should
also wrap it in an <code>if</code> statement to check that the function exists, so that if the plugin
is deactivated you don't get a PHP fatal error on your website. Below is a simple example.</p>
<h5>Simple example</h5>
<pre>&lt;?php if (function_exists('iphorm_popup')) echo iphorm_popup(1, 'Contact us'); ?&gt;</pre>
<p>In the above example, replace <code>1</code> with your form unique ID which you can find in the list
of your created forms or at the top of the form builder. The second parameter is a string containing
the HTML or text that will trigger the popup to show the form.</p>
<h5>Advanced example</h5>
<pre>&lt;?php if (function_exists('iphorm_popup')) echo iphorm_popup(8, 'Click here to show the form',
'{ overlayOpacity: 0.8 }'); ?&gt;</pre>
<p>In the above example, replace <code>8</code> with your form unique ID which you can find in the list
of your created forms or at the top of the form builder. The second parameter is a string containing
the HTML or text that will trigger the popup to show the form. The third parameter is a JSON
formatted string that will be passed to the Fancybox script, this particular example will
make overlay opacity 0.8.</p>

<p>Note: we have added code to automatically resize the Fancybox window to wrap your form size. If you need
to set the exact size of Fancybox you will need to disable this by passing in 2 additional options, see below.</p>
<pre>{ width: 400, height: 400, autoDimensions: false<strong>, onStart: null, onComplete: null</strong> }</pre>

<p>See the <a href="http://fancybox.net/api" class="iphorm-external">Fancybox Options API</a> for a list of all available options.</p>

<h4>Lightbox troubleshooting</h4>
<p>If your popup does not work or when you click the link or it takes you to another page, then you
may have a JavaScript error on the page, please check and resolve any errors.</p>
<p>In the Quform global settings at <span class="ifb-bold">Quform &rarr; Settings</span> on
the WordPress menu, check that "Disable Fancybox output" is unticked and check that "Enable Fancybox"
is ticked.</p>
<p>Another possibility is that you already have Fancybox loaded in your theme for another reason,
if this is the case it could be conflicting with the Quform Fancybox script. You could try ticking the box "Disable Fancybox output" in the Quform global
settings at <span class="ifb-bold">Quform &rarr; Settings</span> on the WordPress menu.</p>
<p>For further help, see the section at the bottom of this page "Need more support?".</p>

<h3><span>Can I integrate the form with Google AdWords conversion tracking?<a class="iphorm-help-anchor" name="website-google" id="website-google">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>You can make it so that you can track the form submissions by adding tracking code to your success message. I'd suggest you make a separate HTML page with
only your conversion tracking code on it. Then in the success message for the form you can set it up to load a hidden iframe that will track the conversion.
For example, in the success message content box enter this:</p>
<pre>
Thanks for your message, etc.
&lt;iframe style="width: 0px; height: 0px;" src="http://www.yourdomain.com/path_to_file_with_code"&gt;&lt;/iframe&gt;
</pre>
<p>Then create your HTML page with your tracking code on it and upload it to <code>http://www.yourdomain.com/path_to_file_with_code</code></p>

<h3><span>Can I integrate the form with MailChimp?<a class="iphorm-help-anchor" name="website-mailchimp" id="website-mailchimp">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>It is not yet possible to do this from inside the form builder user interface, but it's possible by writing custom PHP code to hook into the form processing. We
have created a guide for this on our website at: <a class="iphorm-external" href="http://www.themecatcher.net/iphorm-form-builder/mailchimp.php">http://www.themecatcher.net/iphorm-form-builder/mailchimp.php</a></p>
<p>We are planning to make this an addon in the future.</p>

<h3><span>Can I integrate the form with Aweber?<a class="iphorm-help-anchor" name="website-aweber" id="website-aweber">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>It is not yet possible to do this from inside the form builder user interface, but it's possible by writing custom PHP code to hook into the form processing. We
have created a guide for this on our website at: <a class="iphorm-external" href="http://www.themecatcher.net/iphorm-form-builder/aweber.php">http://www.themecatcher.net/iphorm-form-builder/aweber.php</a></p>
<p>We are planning to make this an addon in the future.</p>

<h2>Email<a class="iphorm-help-anchor" name="faq-email" id="faq-email">&nbsp;</a></h2>

<h3><span>How do I customize the notifcation email?<a class="iphorm-help-anchor" name="email-notif" id="email-notif">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>To customize the email, in the Form Builder go to <span class="ifb-bold">Settings &rarr; Email &rarr; Notification email settings</span>
and tick the box <span class="ifb-bold">Customize email content</span>, a box will appear where you can
enter your custom content. See the <a href="<?php echo iphorm_help_link('settings-email#notification-email-content'); ?>">help for this section</a> for more information.
</p>

<h3><span>How do I send an autoreply?<a class="iphorm-help-anchor" name="email-autoreply" id="email-autoreply">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>To enable the sending of an autoreply email, you should have at least one Email Address element
in your form and then, in the Form Builder, go to <span class="ifb-bold">Settings &rarr; Email &rarr; Autoreply email settings</span>.
Tick the box <span class="ifb-bold">Send autoreply email</span> and then you can configure the autoreply
using the new options that appear.</p>

<h3><span>How do I customize the autoreply email?<a class="iphorm-help-anchor" name="email-cust-autoreply" id="email-cust-autoreply">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>In the Form Builder, go to <span class="ifb-bold">Settings &rarr; Email &rarr; Autoreply email settings</span>.
Make sure the box <span class="ifb-bold">Send autoreply email</span> is ticked and then you can configure the autoreply
content in the field <span class="ifb-bold">Email content</span>. See
the <a href="<?php echo iphorm_help_link('settings-email#autoreply-email-content'); ?>">help for this section</a> for more information.</p>

<h3><span>How do I use SMTP to send the email?<a class="iphorm-help-anchor" name="email-smtp" id="email-smtp">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>There are two ways: setting this globally for every form or setting it in the form settings.</p>

<p>To set it up globally for every form go to, <span class="ifb-bold">Quform &rarr; Settings</span> on
the WordPress admin navigation and go to the section <span class="ifb-bold">Email sending settings</span>.
Select SMTP from the dropdown menu, you will be presented with a list of text fields where you can
enter your SMTP server information. Every form will now use these settings by default.If you
start getting an "Error submitting the form" your SMTP settings may be incorrect.</p>

<p>To set it up for a single form, in the Form Builder, go to <span class="ifb-bold">Settings &rarr; Email &rarr; Email sending settings</span>.
Select SMTP from the dropdown menu, you will be presented with a list of text fields where you can
enter your SMTP server information. Save the form and it will now send via your SMTP server. If you
start getting an "Error submitting the form" your SMTP settings may be incorrect.</p>

<h2>Entries<a class="iphorm-help-anchor" name="faq-entries" id="faq-entries">&nbsp;</a></h2>

<h3><span>How do I change the layout of the entries list?<a class="iphorm-help-anchor" name="entry-layout" id="entry-layout">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>While looking at the entries list, click Edit Table Layout in the header navigation, you will be
taken to the form Entries settings. To show an element in the table, drag it to the Active columns list,
to hide an element from the list, drag it to the Inactive columns list.</p>

<h3><span>How do I show/hide form values on the view entry page?<a class="iphorm-help-anchor" name="entry-hide" id="entry-hide">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>You need to specify in the element settings whether you want to save the value to the database or not.
This is usually found under the <span class="ifb-bold">Optional</span> tab in the element settings and it's called
<span class="ifb-bold">Save value to the database</span>, tick or untick this to toggle the setting.</p>

<h3><span>Can I export my entries to a spreadsheet e.g. Excel?<a class="iphorm-help-anchor" name="entry-export" id="entry-export">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>Yes! In the WordPress admin menu go to <span class="ifb-bold">Quform &rarr; Export</span>. On this page
you can select the form that you would like to export entries from. When you choose the form a list of
the form fields will appear and you can choose which fields to include in the exported file. You can also
choose the date range in which to export entries from, only entries submitted between the start and end
date will be included in the exported file. Click the Download button to download the entries, the
file is a CSV (comma separated values) file which can be opened in any good spreadsheet software.</p>

<h2>Translating<a class="iphorm-help-anchor" name="faq-translating" id="faq-translating">&nbsp;</a></h2>

<h3><span>How do I translate the plugin?<a class="iphorm-help-anchor" name="translate" id="translate">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>See our <a href="http://www.themecatcher.net/iphorm-form-builder/translate.php" class="iphorm-external">step-by-step translating guide</a>.</p>

<h2>Theming<a class="iphorm-help-anchor" name="faq-theming" id="faq-theming">&nbsp;</a></h2>

<h3><span>How do I create a theme?<a class="iphorm-help-anchor" name="create-theme" id="create-theme">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>See the instructions on our <a href="http://www.themecatcher.net/iphorm-form-builder/theme-instructions.php" class="iphorm-external">theme instructions web page</a>.</p>

<h3><span>Can I sell my theme?<a class="iphorm-help-anchor" name="sell-theme" id="sell-theme">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>Yes, we recommend CodeCanyon of course but you are free to sell anywhere. Be sure to
make it clear to your customers that they will require our Quform WordPress plugin to use it.</p>

<h3><span>What skills do I require?<a class="iphorm-help-anchor" name="skill-theme" id="skill-theme">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>You will have to have a good CSS knowledge to make a theme, and if you require graphics for
your theme you will need to be able to make these graphics. You will not need to touch any HTML,
PHP or Javascript.</p>

<h3><span>How long will it take?<a class="iphorm-help-anchor" name="long-theme" id="long-theme">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>It depends on the complexity of your design so times may vary. All the CSS layout and alignments
are controlled elsewhere so all you need to do is make the form elements look pretty via the theme CSS.</p>

<h3><span>How many can I make?<a class="iphorm-help-anchor" name="many-theme" id="many-theme">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>You are free to make as many as you like. You can even make variations of the same theme, for example
a light and dark version of the same style or perhaps one version with rounded corners and one with square
edges.</p>

<h3><span>Will ThemeCatcher help promote my theme?<a class="iphorm-help-anchor" name="#promote-theme" id="#promote-theme">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>If we like your design we will feature it on our website and on the Quform website. So we
recommend you pay close attention to making a pixel perfect design.</p>

<h2>Troubleshooting<a class="iphorm-help-anchor" name="faq-troubleshooting" id="faq-troubleshooting">&nbsp;</a></h2>

<h3><span>There are big gaps between my form elements and my form does not work properly<a class="iphorm-help-anchor" name="bad-formatter" id="bad-formatter">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>Your WordPress theme possibly has a function to allow use of a [raw] shortcode, which messes with the default
filters that WordPress applies to the post content and causes the extra space. The solution
is simple: put the Quform shortcode inside the [raw] shortcode, e.g.</p>
<pre><strong>[raw]</strong> [iphorm id=1 name="Contact form"] <strong>[/raw]</strong></pre>

<h3><span>Found a bug?<a class="iphorm-help-anchor" name="bug" id="bug">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>Please  <a class="iphorm-external" href="http://www.themecatcher.net/support.php">bug report form</a>.</p>

<h3><span>Need more support?<a class="iphorm-help-anchor" name="more-support" id="more-support">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
<p>The fastest way to get support is to contact us using the contact form on
our <a href="http://codecanyon.net/user/ThemeCatcher" class="iphorm-external">CodeCanyon profile page</a>.</p>

</div>