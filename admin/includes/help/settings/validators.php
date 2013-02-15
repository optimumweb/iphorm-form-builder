<?php if (!defined('IPHORM_VERSION')) exit; ?><h4>Validators</h4>
<p>Validators can be used to strip harmful or unexpected data from the submitted form data.
See below for an explanation of what each included filter does and their options.</p>

<h5>Adding a validator</h5>
<p>To add a validator, click the button of the validator you want to add, for example, to add the Digits validator,
click the Digits button.</p>

<h5>Removing a validator</h5>
<p>To remove a validator, click the <img src="<?php echo IPHORM_PLUGIN_URL; ?>/admin/images/small-delete-round-for-help.png" /> on the validator.</p>

<h5>Included validators</h5>
<p>Some validators may be not available for certain elements.</p>
<h6>Alpha Numeric</h6>
<p>The alpha numeric validator checks that the value contains only alphabet or digit characters.</p>
<p class="iphorm-header7">Options</p>
<table class="iphorm-help-options-table">
    <tr>
        <th>Option</th>
        <th>Default</th>
        <th>Description</th>
    </tr>
    <tr>
        <td>Allow whitespace</td>
        <td>unchecked</td>
        <td>Whether to allow whitespace such as spaces and tabs</td>
    </tr>
</table>
<h6>Alpha</h6>
<p>The alpha validator checks that the value contains only alphabet characters.</p>
<p class="iphorm-header7">Options</p>
<table class="iphorm-help-options-table">
    <tr>
        <th>Option</th>
        <th>Default</th>
        <th>Description</th>
    </tr>
    <tr>
        <td>Allow whitespace</td>
        <td>unchecked</td>
        <td>Whether to allow whitespace such as spaces and tabs</td>
    </tr>
</table>
<h6>Digits</h6>
<p>The digits validator checks that the value contains only digits.</p>
<p class="iphorm-header7">Options</p>
<table class="iphorm-help-options-table">
    <tr>
        <th>Option</th>
        <th>Default</th>
        <th>Description</th>
    </tr>
    <tr>
        <td>Allow whitespace</td>
        <td>unchecked</td>
        <td>Whether to allow whitespace such as spaces and tabs</td>
    </tr>
</table>
<h6>Email</h6>
<p>The email validator checks that the value is a valid email address.</p>
<h6>Greater Than</h6>
<p>The greater than validator checks that the value is numerically greater than the given minimum.</p>
<p class="iphorm-header7">Options</p>
<table class="iphorm-help-options-table">
    <tr>
        <th>Option</th>
        <th>Default</th>
        <th>Description</th>
    </tr>
    <tr>
        <td>Minimum</td>
        <td>0</td>
        <td>Minimum allowed value</td>
    </tr>
</table>
<h6>Identical</h6>
<p>The identical validator checks that the value is identical to the given token.</p>
<p class="iphorm-header7">Options</p>
<table class="iphorm-help-options-table">
    <tr>
        <th>Option</th>
        <th>Default</th>
        <th>Description</th>
    </tr>
    <tr>
        <td>Token</td>
        <td>&nbsp;</td>
        <td>Token to match against the value</td>
    </tr>
</table>
<h6>Less Than</h6>
<p>The less than validator checks that the value is numerically less than the given maximum.</p>
<p class="iphorm-header7">Options</p>
<table class="iphorm-help-options-table">
    <tr>
        <th>Option</th>
        <th>Default</th>
        <th>Description</th>
    </tr>
    <tr>
        <td>Maximum</td>
        <td>10</td>
        <td>Maximum allowed value</td>
    </tr>
</table>
<h6>Length</h6>
<p>The length validator checks that the length of the value is between the given maximum and minimum.</p>
<p class="iphorm-header7">Options</p>
<table class="iphorm-help-options-table">
    <tr>
        <th>Option</th>
        <th>Default</th>
        <th>Description</th>
    </tr>
    <tr>
        <td>Minimum length</td>
        <td>0</td>
        <td>Minimum allowed length</td>
    </tr>
    <tr>
        <td>Maximum length</td>
        <td>&nbsp;</td>
        <td>Maximum allowed length</td>
    </tr>
</table>
<h6>Regex</h6>
<p>The regex validator checks that the value matches the given regular expression.</p>
<p class="iphorm-header7">Options</p>
<table class="iphorm-help-options-table">
    <tr>
        <th>Option</th>
        <th>Default</th>
        <th>Description</th>
    </tr>
    <tr>
        <td>Pattern</td>
        <td>&nbsp;</td>
        <td>The regular expression pattern to match</td>
    </tr>
</table>