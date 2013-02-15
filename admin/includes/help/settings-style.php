<?php
if (!defined('IPHORM_VERSION')) exit;
include IPHORM_ADMIN_INCLUDES_DIR . '/help/_nav-settings.php';
?>
<div class="iphorm-help-right">
<h2>Style settings</h2>

<h3><span>Style</span></h3>
<h4>Theme</h4>
<p>The theme you chose defines the look of your form, choose which theme you'd like.
You can also add your own themes by following the instructions <a href="<?php echo iphorm_help_link('faq#create-theme'); ?>">here</a>.
If you select None, the form will have the minimal style possible.</p>

<h3><span>Uniform</span></h3>
<h4>Use Uniform</h4>
<p>Tick the box to enable the Uniform jQuery plugin (http://www.uniformjs.com). The plugin
makes form inputs such as radio buttons, checkboxes, dropdown menus look consistent in all
browsers and much better than the default browser styling for these inputs. The plugin
is enabled by default.</p>

<h4>Theme</h4>
<p>Choose the uniform theme you want to use, we recommend checking them all to see what suits
your website.</p>

<h3><span>Datepicker</span></h3>
<h4>Theme</h4>
<p>There are 24 themes for different date picker styles. We recommend checking them out to see what suits
your website. Select one to use from the dropdown menu. You can try out the themes from <a onclick="window.open(this.href); return false;" href="http://jqueryui.com/demos/datepicker/">this website</a>.</p>

<h4>Locale</h4>
<p>The datepicker will be translated into the language you choose and the date settings will be appropriate for your region.</p>

<h3><span>Labels</span></h3>
<h4>Label placement</h4>
<p>Choose whether you want the labels above, left or inside the inputs. If you choose left, you
will also be able to specify the width of the label to help control your form layout.</p>

<h4>Required indicator text</h4>
<p>Override/translate the text indicating the element is required. By default this is (required),
but you may want to make it an asterisk * for example.</p>

<h3><span>Tooltips</span></h3>
<h4>Enable tooltips</h4>
<p>Tick the box to enable tooltips which will show a tooltip on an element with set tooltip text.
You can set the tooltip text of an element in the element settings.</p>

<h4>Trigger</h4>
<p>Choose what the user will be interacting with to show the tooltip. The Field type will
show the tooltip when the user interacts with the field, using the trigger events specified in the setting
below. The Help icon type will add an additional help icon next to the element label and this will
be used to show tooltips instead.</p>

<h4>Event</h4>
<p>Choose the event that will trigger the tooltip to show. The Hover event means that the tooltip
will be shown when the user hovers the Field or Help icon (chosen above) with the mouse. The
Click event means the tooltip will be shown when the user clicks the Field or Help icon.</p>

<h4>Tooltip style</h4>
<h5>Style</h5>
<p>Choose from built-in tooltip styles or choose Custom class to be able to enter the name of your
own tooltip custom class.</p>
<h5>Tip position</h5>
<p>Choose the position of the "tip" on the tooltip.</p>
<h5>Position on input</h5>
<p>Choose which part of the input the tooltip points to.</p>
<h5>CSS3 Shadow</h5>
<p>Enable or disable the CSS3 shadow effect on the tooltip. Some of the built in styles may already
have this effect and changing it may have no effect.</p>
<h5>CSS3 Rounded Corners</h5>
<p>Enable or disable the CSS3 rounded corner effect on the tooltip. Some of the built in styles may already
have this effect and changing it may have no effect.</p>

<h3><span>Global styling</span></h3>
<p>In this section you can specify settings and styles that will apply to all elements. You will be
able to override most of the styles inside the individual element settings.</p>

<h4>Element background color</h4>
<p>Choose the hex color that will appear as a background to each element. The value should
include the hash e.g. #fc0000</p>

<h4>Element border color</h4>
<p>Choose the hex color that will appear as a border to each element. The value should
include the hash e.g. #fc0000</p>

<h4>Element input text color</h4>
<p>Choose the hex color for the input text of each element, i.e. the text inside a single line or
paragraph element. The value should
include the hash e.g. #fc0000</p>

<h4>Label text color</h4>
<p>Choose the hex color for the label text of each element. The value should
include the hash e.g. #fc0000</p>

<h4>Add a CSS style</h4>
<p>Click the button referring to the part of the form you want to add CSS styles to. A new row should
appear inside the "Global CSS Styles" section. Click the +CSS button to show the box for adding
your own CSS. There is no limit to the CSS you are allowed to enter here. Enter CSS without a selector or curly brackets
and have each style on it's own line ending with a semi-colon. The code below
is a good example of what you should be entering.</p>
<pre>padding: 10px;
font-size: 15px;
font-weight: bold;</pre>
</div>