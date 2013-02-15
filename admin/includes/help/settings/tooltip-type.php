<?php if (!defined('IPHORM_VERSION')) exit; ?><h4>Tooltip trigger</h4>
<p>Choose what the user will be interacting with to show the tooltip. The Field type will
show the tooltip when the user interacts with the field, using the trigger events specified in the setting
below. The Help icon type will add an additional help icon next to the element label and this will
be used to show tooltips instead. Inherit means that the setting will be inherited from the global
tooltip settings which can be configured at <span class="ifb-bold">Settings &rarr; Style &rarr; Tooltips</span>.
Note: the following elements are not compatible with the <span class="ifb-bold">Field type</span>:</p>
<ul>
    <li>reCAPTCHA</li>
    <li>Date</li>
    <li>Time</li>
    <li>File Upload</li>
    <li>Checkboxes</li>
    <li>Multiple Choice</li>
</ul>

<h4>Tooltip event</h4>
<p>Choose the event that will trigger the tooltip to show. The Hover event means that the tooltip
will be shown when the user hovers the Field or Help icon (chosen above) with the mouse. The
Click event means the tooltip will be shown when the user clicks the Field or Help icon.
Inherit means that the setting will be inherited from the global
tooltip settings which can be configured at <span class="ifb-bold">Settings &rarr; Style &rarr; Tooltips</span>.</p>