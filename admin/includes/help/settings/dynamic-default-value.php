<?php if (!defined('IPHORM_VERSION')) exit; ?><h4>Dynamic default value</h4>
<p>Allows the default value of the field to be set dynamically via a URL parameter, shortcode attribute, PHP function parameter or filter hook.</p>
<h4>Parameter name</h4>
<p>Set the name of the parameter to use as the default value, examples below.</p>
<h5>URL parameter</h5>
<p>You can pass in parameters to the URL to set the default value of fields. Once you've set your parameter
name in the above setting, use the code below to do this. In the following examples, I have set the
Parameter name to <span class="ifb-bold">my_parameter</span>, so you'll need to change this to the value
of your own parameter name.</p>
<h6>For Text, Paragraph, Email, Multiple Choice, Dropdown Menu and Hidden elements</h6>
<p>You can pass in text e.g.</p>
<pre>http://example.com/<strong>?my_parameter=Banana</strong></pre>
<p>Your element will now have the value <span class="ifb-bold">Banana</span> when loading the page. Note:
if your URL already has a ? in it, you should use an ampersand (&amp;) to add further parameters e.g.</p>
<pre>http://example.com/<strong>?p=1&amp;my_parameter=Banana&amp;my_parameter2=Apple</strong></pre>
<h6>Checkboxes element</h6>
<p>Pass in a comma separated list of values into your parameter, with <span class="ifb-bold">no spaces before or after the comma</span> (unless your option has them).</p>
<pre>http://example.com/<strong>?my_parameter=Option 1,Option 2</strong></pre>
<h6>Date element</h6>
<p>Pass in the date in the format DD,MM,YYYY e.g.</p>
<pre>http://example.com/<strong>?my_parameter=26,08,2001</strong></pre>
<h6>Time element</h6>
<p>Pass in the time in the format HH,MM,am/pm e.g.</p>
<pre>http://example.com/<strong>?my_parameter=12,25,am</strong></pre>

<h5>Shortcode attribute</h5>
<p>You can use a shortcode attribute called <span class="ifb-bold">values</span> to pass parameters to
the forms. Using the same rules for each element as specified above, only this time each parameter should
be separated by <span class="ifb-bold">&amp;amp;</span></p>
<pre>[iphorm id=1 name="Contact form" <strong>values="my_parameter=Banana&amp;amp;my_parameter2=Apple"</strong>]</pre>

<pre>[iphorm_popup id=1 name="Contact form" <strong>values="my_parameter=Banana&amp;amp;my_parameter2=Apple"</strong>]
Click me[/iphorm_popup]</pre>
<h5>Filter hook</h5>
<p>You can use a filter hook in a plugin or your theme PHP files to change the value. This will take precedence over
the other methods. The parameter $value passed to the function is any previous default value set from the URL or shortcode.</p>
<pre>&lt;?php
add_filter('iphorm_element_value_my_parameter', 'mytheme_set_parameter');

function mytheme_set_parameter($value)
{
	return 'New value';
}
?&gt;</pre>
<h5>PHP function parameter</h5>
<p>You can pass in dynamic values to the function call to <code>iphorm</code> and <code>iphorm_popup</code> functions. When using the
<code>iphorm</code> function, it's the second parameter (after your form ID). For the <code>iphorm_popup</code> function, it's the fourth parameter.
The values can be passed in as a string with each key/value pair separated by <code>&amp;amp;</code> or <code>&amp;</code> or you can also pass in
an array of key => value pairs. The key will be your parameter name. For example:</p>
<h6>Display the form with values in the given string</h6>
<pre>&lt;?php if (function_exists('iphorm')) echo iphorm(1, 'my_parameter=Banana&amp;amp;my_parameter2=Apple'); ?&gt;</pre>
<h6>Display the form with values in the given array</h6>
<pre>&lt;?php if (function_exists('iphorm')) echo iphorm(1, array(
    'my_parameter' =&gt; 'Banana',
    'my_parameter2' =&gt; 'Apple'
)); ?&gt;</pre>
<h6>Display the popup form with values in the given string</h6>
<pre>&lt;?php if (function_exists('iphorm_popup')) echo iphorm_popup(1, 'Click here to show the form', '', 'my_parameter=Banana&amp;amp;my_parameter2=Apple'); ?&gt;</pre>
<h6>Display the form with values in the given array</h6>
<pre>&lt;?php if (function_exists('iphorm_popup')) echo iphorm_popup(1, 'Click here to show the form', '', array(
    'my_parameter' =&gt; 'Banana',
    'my_parameter2' =&gt; 'Apple'
)); ?&gt;</pre>