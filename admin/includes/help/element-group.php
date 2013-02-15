<?php
if (!defined('IPHORM_VERSION')) exit;
include IPHORM_ADMIN_INCLUDES_DIR . '/help/_nav-elements.php';
?>
<div class="iphorm-help-right">
<h2>Group Element</h2>
<p>The group element is used to create a grouping of elements. The group can have a specified
number of columns and be styled with CSS to create complex forms. You can also place groups within
groups for unlimited flexibility.</p>
<h3><span>Configuration options</span></h3>
<h4>Name</h4>
<p>The name of the group, only shown inside the form builder to help you identify groups.</p>

<h4>Title</h4>
<p>The title of the group, shown on the form at the top of the group.</p>

<h4>Description</h4>
<p>The description of the group, shown below the title on the form. Useful for giving instructions
to the form user.</p>

<h4>Number of columns</h4>
<p>The number of columns determines the how many elements should be display per row inside the group. After
this number of elements, further elements will appear on the line below.</p>

<h4>Column alignment</h4>
<p>The column alignment determines how the columns of the groups are displayed. If it's set to
proportional, then all elements or groups in each row will be evenly spaced out. Proportional
is a good choice for groups used for form layout.</p>
<p>Float left means that each column is compacted as small as possible, that is, each column tightly
wraps the column content and the next column starts immediately. This is useful if you want to have
two or more elements next to each other without a lot of spacing, such as First Name / Last Name
groups.</p>

<h4>Label placement</h4>
<p>Choose whether you want the labels above, left or inside the inputs. If you choose left, you
will also be able to specify the width of the label to help control your form layout. By default
this inherits the value set in <span class="ifb-bold">Form Builder &rarr; Settings &rarr; Style &rarr; Labels</span></p>

<h4>Group style</h4>
<p>Choose whether this is a plain or bordered group. Plain groups have no additional styling, bordered groups
have a border and some inside padding.</p>

<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/tooltip-type.php'; ?>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/conditional-logic.php'; ?>

<h4>Border color</h4>
<p>The color of the border of the group, in hex e.g. #D2D2D2. Click the field for a color picker.</p>

<h4>Background color</h4>
<p>The color of the background of the group, in hex e.g. #D2D2D2. Click the field for a color picker.</p>
<?php include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings/styles.php'; ?>
</div>