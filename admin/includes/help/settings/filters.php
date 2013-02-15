<?php if (!defined('IPHORM_VERSION')) exit; ?><h4>Filters</h4>
<p>Filters can be used to strip harmful or unexpected data from the submitted form data.
See below for an explanation of what each included filter does and their options.</p>

<h5>Adding a filter</h5>
<p>To add a filter, click the button of the filter you want to add, for example, to add the Trim filter,
click the Trim button.</p>

<h5>Removing a filter</h5>
<p>To remove a filter, click the <img src="<?php echo IPHORM_PLUGIN_URL; ?>/admin/images/small-delete-round-for-help.png" /> on the filter.</p>

<h5>Included filters</h5>
<p>Some filters may be not available for certain elements.</p>
<h6>Alpha Numeric</h6>
<p>The alpha numeric filter removes any characters that are not alphabet characters or digits.</p>
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
<p>The alpha filter removes any non-alphabet characters.</p>
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
<p>The digits filter removes any characters that are not digits.</p>
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
<h6>Regex</h6>
<p>The regex filter removes any characters that match the given regular expression.</p>
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
<h6>Strip Tags</h6>
<p>The strip tags filter removes any HTML tags.</p>
<p class="iphorm-header7">Options</p>
<table class="iphorm-help-options-table">
    <tr>
        <th>Option</th>
        <th>Default</th>
        <th>Description</th>
    </tr>
    <tr>
        <td>Allowable tags</td>
        <td>&nbsp;</td>
        <td>A list of any allowed tags e.g. <code>&lt;p&gt;&lt;br&gt;&lt;span&gt;</code></td>
    </tr>
</table>
<h6>Trim</h6>
<p>The trim filter removes any whitespace from the start and end of the value.</p>