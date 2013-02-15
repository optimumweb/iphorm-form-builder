<?php
if (!defined('IPHORM_VERSION')) exit;
include IPHORM_ADMIN_INCLUDES_DIR . '/help/_nav-basic.php';
?>
<div class="iphorm-help-right">
    <h2>Basics</h2>
    <p>Welcome to the Quform form builder help, this section contains the basics on how to get started
    building a form.</p>

    <h3><span>Creating a form<a class="iphorm-help-anchor" id="create-form" name="create-form">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
    <p>To create a form, find the Quform section on the WordPress admin navigation and click
    <span class="ifb-bold">Form Builder</span>. You will be prompted to enter a name for your new form, once you've done so, click OK or press Enter to continue.
    You can then start adding elements and configuring your form.</p>

    <h3><span>Adding an element<a class="iphorm-help-anchor" id="add-element" name="add-element">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
    <p>On the right hand side of the form builder there is a box containing buttons for every available element
    type you can add to your form. Click a button to add the element to the bottom of your form or drag and drop
    the button into the desired position within the form. For more information about each element and their
    configuration options, see the <a href="<?php echo iphorm_help_link('elements'); ?>">Elements help section</a>.</p>

    <h3><span>Configuring an element<a class="iphorm-help-anchor" id="configure-element" name="configure-element">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
    <p>To configure an element, hover over the element in your form, you should see a button appear called
    <span class="ifb-bold">Settings</span>, click it to show the element settings. For help on each element's settings,
    see the <a href="<?php echo iphorm_help_link('elements'); ?>">Elements help section</a>.</p>

    <h3><span>Moving an element<a class="iphorm-help-anchor" id="move-element" name="move-element">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
    <p>You can drag and drop an element to a different position within a form. There are two methods available
    to do this:</p>
    <ul>
        <li>Click and drag the move button at the top right of the element</li>
        <li>Click and drag the box surrounding the element preview when hovering a element</li>
    </ul>
    <p>An arrow will appear indicating the position the element will be placed. Release the mouse button to
    place the element.</p>

    <h3><span>Deleting an element<a class="iphorm-help-anchor" id="delete-element" name="delete-element">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
    <p>To delete an element, hover over the element and a bin icon should be visible in the top right corner.
    Click the bin and click "OK" to confirm.</p>

    <h3><span>Adding the form to your website<a class="iphorm-help-anchor" id="add-form-to-website" name="add-form-to-website">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
    <h4>Adding the form to a page (or post)</h4>
    <p>In the the edit page screen you will see the Quform icon above the content editor, click it.
    You will be able to choose from a list of all your saved forms, select the form you want to add and click
    the <span class="ifb-bold">Insert</span> button. Save the page and the form will now appear when viewed. The
    procedure for inserting a form into a post is exactly the same.</p>
    <h4>Adding the form as a widget</h4>
    <p>Go to Appearances &rarr; Widget in the WordPress navigation menu. Find the widget named <span class="ifb-bold">Quform Form</span>
    and drag it to your widget-enabled area. Select one of your forms from the list and click <span class="ifb-bold">Save</span>.</p>
    <h4>Adding the form to a theme PHP file</h4>
    <p>You will need the unique ID number of your form to do this, you can find this number at the top of the form builder
    when editing a form or on the list of forms. Once you have it, insert the code below to your WordPress theme PHP file and replace
    <span class="ifb-bold">FORM_ID</span> with the unique ID number.</p>
    <pre>&lt;?php if (function_exists('iphorm')) echo iphorm(FORM_ID); ?&gt;</pre>

    <h3><span>Activating a form<a class="iphorm-help-anchor" id="activate-form" name="activate-form">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
    <p>To activate a form, go to the form list by going to <span class="ifb-bold">Quform &rarr; Forms</span> in the WordPress navigation menu.
    Find the form you want to activate in the list, hover it and click <span class="ifb-bold">Activate</span>. By
    default new forms are already activated.</p>

    <h3><span>Deactivating a form<a class="iphorm-help-anchor" id="deactivate-form" name="deactivate-form">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
    <p>To deactivate a form, go to the form list by going to <span class="ifb-bold">Quform &rarr; Forms</span> in the WordPress navigation menu.
    Find the form you want to deactivate in the list, hover it and click <span class="ifb-bold">Deactivate</span>. Deactivated forms
    will not be displayed on your website.</p>

    <h3><span>Viewing submitted form entries<a class="iphorm-help-anchor" id="view-entries" name="view-entries">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
    <p>To view submitted form entries, you can go to <span class="ifb-bold">Quform &rarr; Entries</span> on the WordPress admin navigation,
    you will be taken to a page of the list of entries for one of your forms. If you want to switch to
    see the entries of another form, use the <span class="ifb-bold">Switch Form</span> button at the top.</p>

    <p>Alternatively, you can go to, <span class="ifb-bold">Quform &rarr; Forms</span> on the WordPress admin navigation,
    you will be taken to a page of the list of forms, hover over the form in the list and click <span class="ifb-bold">Entries</span>.</p>

    <h3><span>Viewing a form entry<a class="iphorm-help-anchor" id="view-entry" name="view-entry">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
    <p>At the list of submitted form entries, over over the entry and click <span class="ifb-bold">View</span>.</p>

    <h3><span>Deleting a form entry<a class="iphorm-help-anchor" id="delete-entry" name="delete-entry">&nbsp;</a><a href="#top" class="iphorm-top-link">Top</a></span></h3>
    <p>To delete a form entry, at the list of entries hover the entry and click <span class="ifb-bold">Delete</span>. To delete
    multiple entries, check the box at the start of the entry row within the list for each entry you
    want to delete. Then under the Bulk Actions drop down list, choose Delete, then click Apply.</p>
</div>