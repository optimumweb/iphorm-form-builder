<?php
if (!defined('IPHORM_VERSION')) exit;
if ($element->getEnableWrapper()) : ?>
<div class="iphorm-element-wrap iphorm-element-wrap-html <?php echo $name; ?>-element-wrap iphorm-clearfix">
    <div class="iphorm-element-spacer iphorm-element-spacer-html <?php echo $name; ?>-element-spacer">
        <?php echo do_shortcode($element->getContent()); ?>
    </div>
</div>
<?php else :
    echo do_shortcode($element->getContent());
endif; ?>