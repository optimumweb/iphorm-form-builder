<?php
if (!defined('IPHORM_VERSION')) exit;
$title = $element->getTitle();
$description = $element->getDescription();
?>
<div class="iphorm-group-wrap <?php echo $name; ?>-group-wrap iphorm-clearfix iphorm-labels-<?php echo $labelPlacement; ?> iphorm-group-style-<?php echo $element->getGroupStyle(); ?> iphorm-group-alignment-<?php echo $element->getColumnAlignment(); ?>" <?php echo $element->getCss('group'); ?>>
    <div class="iphorm-group-elements" <?php echo $element->getCss('groupElements'); ?>>
        <?php if (strlen($title) || strlen($description)) : ?>
        	<div class="iphorm-group-title-description-wrap iphorm-clearfix">
    			<?php if (strlen($title)) : ?>
                <div class="iphorm-group-title" <?php echo $element->getCss('groupTitle'); ?>><?php echo do_shortcode($title); ?></div>
                <?php endif; ?>
                <?php if (strlen($description)) : ?>
                    <p class="iphorm-group-description" <?php echo $element->getCss('description'); ?>><?php echo do_shortcode($description); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="iphorm-group-row iphorm-clearfix iphorm-group-row-<?php echo $element->getNumberOfColumns(); ?>cols">