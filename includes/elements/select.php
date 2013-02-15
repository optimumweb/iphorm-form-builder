<?php
if (!defined('IPHORM_VERSION')) exit;
$value = (array) $element->getValue();
?>
<div class="iphorm-element-wrap iphorm-element-wrap-select <?php echo $name; ?>-element-wrap iphorm-clearfix iphorm-labels-<?php echo $labelPlacement; ?> <?php echo ($element->getRequired()) ? 'iphorm-element-required' : 'iphorm-element-optional'; ?>" <?php echo $element->getCss('outer'); ?>>
    <div class="iphorm-element-spacer iphorm-element-spacer-select <?php echo $name; ?>-element-spacer">
        <?php if (strlen($label = $element->getLabel())) : ?>
            <label for="<?php echo $uniqueId; ?>" <?php echo $element->getCss('label', $labelCss); ?>>
                <?php echo $label; ?>
                <?php if ($element->getRequired() && strlen($requiredText)) : ?>
                    <span class="iphorm-required"><?php echo esc_html($requiredText); ?></span>
                <?php endif; ?>
                <?php include IPHORM_INCLUDES_DIR . '/elements/_tooltip-icon.php'; ?>
            </label>
        <?php endif; ?>
        <div class="iphorm-input-wrap iphorm-input-wrap-select <?php echo $name; ?>-input-wrap" <?php echo $element->getCss('inner', $leftMarginCss); ?>>
            <select class="iphorm-element-select <?php echo $tooltipInputClass; ?> <?php echo $name; ?>" name="<?php echo $name; ?>" id="<?php echo $uniqueId; ?>" <?php echo $tooltipTitle; ?> <?php echo $element->getCss('select'); ?>>
                <?php
                    $i = 0;
                    $options = $element->getOptions();
                    foreach ($options as $option) : ?>
                    <option value="<?php echo _wp_specialchars($option['value'], ENT_COMPAT, false, true); ?>" <?php echo (in_array($option['value'], $value)) ? 'selected="selected"' : ''; ?>><?php echo _wp_specialchars($option['label'], ENT_NOQUOTES, false, true); ?></option>
                <?php $i++; endforeach; ?>
            </select>
            <?php include IPHORM_INCLUDES_DIR . '/elements/_description.php'; ?>
        </div>
        <?php include IPHORM_INCLUDES_DIR . '/elements/_errors.php'; ?>
    </div>
</div>