<?php
if (!defined('IPHORM_VERSION')) exit;
$time1224 = $element->getTime1224();
$value = $element->getValue();
$minuteGranularity = $element->getMinuteGranularity();
?>
<div class="iphorm-element-wrap iphorm-element-wrap-time <?php echo $name; ?>-element-wrap iphorm-clearfix iphorm-labels-<?php echo $labelPlacement; ?> <?php echo ($element->getRequired()) ? 'iphorm-element-required' : 'iphorm-element-optional'; ?>" <?php echo $element->getCss('outer'); ?>>
    <div class="iphorm-element-spacer iphorm-element-spacer-time <?php echo $name; ?>-element-spacer">
        <?php if (strlen($label = $element->getLabel())) : ?>
            <label <?php echo $element->getCss('label', $labelCss); ?>>
                <?php echo $label; ?>
                <?php if ($element->getRequired() && strlen($requiredText)) : ?>
                    <span class="iphorm-required"><?php echo esc_html($requiredText); ?></span>
                <?php endif; ?>
                <?php include IPHORM_INCLUDES_DIR . '/elements/_tooltip-icon.php'; ?>
            </label>
        <?php endif; ?>
        <div class="iphorm-input-wrap iphorm-input-wrap-date <?php echo $name; ?>-input-wrap" <?php echo $element->getCss('inner', $leftMarginCss); ?>>
            <select name="<?php echo $name; ?>[hour]" class="<?php echo $name; ?>-input-hour" <?php echo $element->getCss('timeHour'); ?>>
                <?php if ($time1224 == '24') : ?>
                    <?php foreach (range(0, 23) as $hour) : ?>
                        <?php $hour = str_pad($hour, 2, '0', STR_PAD_LEFT); ?>
                        <option value="<?php echo $hour; ?>" <?php selected($value['hour'], $hour); ?>><?php echo $hour; ?></option>
                    <?php endforeach; ?>
                <?php else : ?>
                    <?php foreach (range(1, 12) as $hour) : ?>
                        <?php $hour = str_pad($hour, 2, '0', STR_PAD_LEFT); ?>
                        <option value="<?php echo $hour; ?>" <?php selected($value['hour'], $hour); ?>><?php echo $hour; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <select name="<?php echo $name; ?>[minute]" class="<?php echo $name; ?>-input-minute" <?php echo $element->getCss('timeMinute'); ?>>
                <?php foreach (range(0, 59) as $min) : ?>
                    <?php if ($min % $minuteGranularity == 0) : ?>
                        <?php $min = str_pad($min, 2, '0', STR_PAD_LEFT); ?>
                        <option value="<?php echo $min; ?>" <?php selected($value['minute'], $min); ?>><?php echo $min; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            <?php if ($time1224 == '12') : ?>
            <select name="<?php echo $name; ?>[ampm]"  class="<?php echo $name; ?>-input-ampm" <?php echo $element->getCss('timeAmPm'); ?>>
                <option value="am" <?php selected($value['ampm'], 'am'); ?>><?php echo esc_html($element->getAmString()); ?></option>
                <option value="pm" <?php selected($value['ampm'], 'pm'); ?>><?php echo esc_html($element->getPmString()); ?></option>
            </select>
            <?php else : ?>
                <input type="hidden" name="<?php echo $name; ?>[ampm]" value="am" />
            <?php endif; ?>
            <?php include IPHORM_INCLUDES_DIR . '/elements/_description.php'; ?>
        </div>
        <?php include IPHORM_INCLUDES_DIR . '/elements/_errors.php'; ?>
    </div>
</div>