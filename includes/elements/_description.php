<?php
if (!defined('IPHORM_VERSION')) exit;
if (strlen($description = $element->getDescription())) : ?>
    <p class="iphorm-description" <?php echo $element->getCss('elementDescription'); ?>><?php echo do_shortcode($description); ?></p>
<?php endif; ?>
