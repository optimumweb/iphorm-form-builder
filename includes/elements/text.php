<?php if (!defined('IPHORM_VERSION')) exit; ?><div class="iphorm-element-wrap iphorm-element-wrap-text <?php echo $name; ?>-element-wrap iphorm-clearfix iphorm-labels-<?php echo $labelPlacement; ?> <?php echo ($element->getRequired()) ? 'iphorm-element-required' : 'iphorm-element-optional'; ?>" <?php echo $element->getCss('outer'); ?>>
    <div class="iphorm-element-spacer iphorm-element-spacer-text <?php echo $name; ?>-element-spacer">
        <?php if (strlen($label = $element->getLabel())) : ?>
            <label for="<?php echo $uniqueId; ?>" <?php echo $element->getCss('label', $labelCss); ?>>
                <?php echo $label; ?>
                <?php if ($element->getRequired() && strlen($requiredText)) : ?>
                    <span class="iphorm-required"><?php echo esc_html($requiredText); ?></span>
                <?php endif; ?>
                <?php include IPHORM_INCLUDES_DIR . '/elements/_tooltip-icon.php'; ?>
            </label>
        <?php endif; ?>
        <div class="iphorm-input-wrap iphorm-input-wrap-text <?php echo $name; ?>-input-wrap" <?php echo $element->getCss('inner', $leftMarginCss); ?>>
            <input class="iphorm-element-text <?php echo $tooltipInputClass; ?> <?php echo $name; ?>" id="<?php echo $uniqueId; ?>" type="text" name="<?php echo $name; ?>" <?php echo $tooltipTitle; ?> value="<?php echo esc_attr($element->getValue()); ?>" <?php echo $element->getCss('input'); ?> />
            <?php include IPHORM_INCLUDES_DIR . '/elements/_description.php'; ?>
        </div>
        <?php include IPHORM_INCLUDES_DIR . '/elements/_errors.php'; ?>
    </div>
    <?php include IPHORM_INCLUDES_DIR . '/elements/_clear-default-value.php'; ?>
</div>