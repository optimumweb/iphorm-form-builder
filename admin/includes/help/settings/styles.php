<?php if (!defined('IPHORM_VERSION')) exit; ?><h4>CSS styles <a class="iphorm-help-anchor" name="example-styles" id="example-styles"></a></h4>
<p>You can add CSS rules to most of the HTML elements surrounding the element to change the style.</p>

<h5>Adding a style</h5>
<p>To add a style, click the button that corresponds to the part of the element HTML that you would
like to style, for example, to style the label, click the Label button.</p>
<p>To add CSS styles, click the <span class="ifb-bold">CSS</span> of the newly added style to show the
box where you can add CSS. Now enter the styles without the CSS selector or curly brackets and each line
must end in a semi-colon. For example:</p>
<pre>border: 1px solid #222;
font-size: 15px;
margin-right: 4px;</pre>
<p>Once you save the form, the changes will appear on the form on your website.</p>

<h5>Removing a style</h5>
<p>To remove a style, click the <img src="<?php echo IPHORM_PLUGIN_URL; ?>/admin/images/small-delete-round-for-help.png" /> on the style.</p>

<h4>CSS selectors</h4>
<p>Each element in your form has unique class selectors that you can use to style the element individually.
These selectors are shown in this section, just copy the selector and paste it into your theme CSS file
to add a style to that part of the element.</p>