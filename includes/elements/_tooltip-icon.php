<?php
if (!defined('IPHORM_VERSION')) exit;
if ($form->getUseTooltips() && strlen($element->getTooltip()) && $tooltipType == 'icon') : ?>
    <span class="iphorm-tooltip-icon iphorm-tooltip-icon-<?php echo $tooltipEvent; ?>"><span class="iphorm-tooltip-icon-content"><?php echo $element->getTooltip(); ?></span></span>
<?php endif;?>