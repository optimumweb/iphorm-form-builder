<?php
if (!defined('IPHORM_VERSION')) exit;
$value = $element->getValue();
$months = iphorm_get_all_months();
$sy = $element->getStartYear();
$ey = $element->getEndYear();
$showDateHeadings = $element->getShowDateHeadings();
if ($sy > $ey) {
    $dpMinYear = $ey;
    $dpMaxYear = $sy;
} else {
    $dpMinYear = $sy;
    $dpMaxYear = $ey;
}
?>
<div class="iphorm-element-wrap iphorm-element-wrap-date <?php echo $name; ?>-element-wrap iphorm-clearfix iphorm-labels-<?php echo $labelPlacement; ?> <?php echo ($element->getRequired()) ? 'iphorm-element-required' : 'iphorm-element-optional'; ?>" <?php echo $element->getCss('outer'); ?>>
    <div class="iphorm-element-spacer iphorm-element-spacer-date <?php echo $name; ?>-element-spacer">
        <?php if (strlen($label = $element->getLabel())) : ?>
            <label <?php echo $element->getCss('label', $labelCss); ?>>
                <?php echo $label; ?>
                <?php if ($element->getRequired() && strlen($requiredText)) : ?>
                    <span class="iphorm-required"><?php echo esc_html($requiredText); ?></span>
                <?php endif; ?>
                <?php include IPHORM_INCLUDES_DIR . '/elements/_tooltip-icon.php'; ?>
            </label>
        <?php endif; ?>
        <div id="<?php echo $uniqueId; ?>" class="iphorm-input-wrap iphorm-input-wrap-date <?php echo $name; ?>-input-wrap" <?php echo $element->getCss('inner', $leftMarginCss); ?>>
        	<div class="iphorm-clearfix">
                <div class="iphorm-input-wrap-date-select-wrap">
                    <?php ob_start(); ?>
                    <select id="<?php echo $uniqueId; ?>_day" name="<?php echo $name; ?>[day]" class="<?php echo $name; ?>-input-day" <?php echo $element->getCss('dateDay'); ?>>
                        <?php if ($showDateHeadings) : ?><option value=""><?php echo esc_html($element->getDayHeading()); ?></option><?php endif; ?>
                        <?php foreach (range(1, 31) as $day) : ?>
                            <option value="<?php echo $day; ?>" <?php selected($value['day'], $day); ?>><?php echo $day; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php $daySelect = ob_get_clean(); ?>
                    <?php ob_start(); ?>
                    <select id="<?php echo $uniqueId; ?>_month" name="<?php echo $name; ?>[month]" class="<?php echo $name; ?>-input-month" <?php echo $element->getCss('dateMonth'); ?>>
                        <?php if ($showDateHeadings) : ?><option value=""><?php echo esc_html($element->getMonthHeading()); ?></option><?php endif; ?>
                        <?php foreach ($months as $key => $month) : ?>
                            <option value="<?php echo $key; ?>" <?php selected($value['month'], $key); ?>><?php echo $element->getMonthsAsNumbers() ? $key : esc_html($month); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php $monthSelect = ob_get_clean(); ?>
                    <?php
                    if ($element->getFieldOrder() != 'us') {
                        echo $daySelect, $monthSelect;
                    } else {
                        echo $monthSelect, $daySelect;
                    }
                    ?>
                    <select id="<?php echo $uniqueId; ?>_year" name="<?php echo $name; ?>[year]" class="<?php echo $name; ?>-input-year" <?php echo $element->getCss('dateYear'); ?>>
                        <?php if ($showDateHeadings) : ?><option value=""><?php echo esc_html($element->getYearHeading()); ?></option><?php endif; ?>
                        <?php if ($sy > $ey) : ?>
                            <?php for ($i = $sy; $i >= $ey; $i--) : ?>
                                <option value="<?php echo $i; ?>" <?php selected($value['year'], $i); ?>><?php echo $i; ?></option>
                            <?php endfor; ?>
                        <?php else : ?>
                            <?php for ($i = $sy; $i <= $ey; $i++) : ?>
                                <option value="<?php echo $i; ?>" <?php selected($value['year'], $i); ?>><?php echo $i; ?></option>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <?php if ($element->getShowDatepicker()) : ?>
                    <input type="hidden" class="iphorm-datepicker" name="iphorm_datepicker_<?php echo $uniqueId; ?>" value="" />
                    <div class="iphorm-datepicker-icon"></div>
                    <script type="text/javascript">
                    <!--
                    jQuery(document).ready(function ($) {
                        iPhorm.instance.addDatepicker('<?php echo $uniqueId; ?>', <?php echo apply_filters('iphorm_datepicker_options_' . $element->getName(), "{
                            minDate: new Date($dpMinYear, 1 - 1, 1),
                            maxDate: new Date($dpMaxYear, 12 - 1, 31)
                        }", $dpMinYear, $dpMaxYear, $element); ?>);
                    });
                    //-->
                    </script>
                <?php endif; ?>
            </div>
            <?php include IPHORM_INCLUDES_DIR . '/elements/_description.php'; ?>
        </div>
        <?php include IPHORM_INCLUDES_DIR . '/elements/_errors.php'; ?>
    </div>
</div>