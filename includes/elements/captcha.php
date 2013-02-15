<?php
if (!defined('IPHORM_VERSION')) exit;
$value = $element->getValue();
$captchaConfig = array(
    'uniqId' => $formUniqueId,
    'tmpDir' => iphorm_get_temp_dir(),
    'options' => $element->getOptions()
);
$captchaConfig = base64_encode(iphorm_json_encode($captchaConfig));
?>
<div class="iphorm-element-wrap iphorm-element-wrap-captcha <?php echo $name; ?>-element-wrap iphorm-clearfix iphorm-labels-<?php echo $labelPlacement; ?> <?php echo ($element->getRequired()) ? 'iphorm-element-required' : 'iphorm-element-optional'; ?>" <?php echo $element->getCss('outer'); ?>>
    <div class="iphorm-element-spacer iphorm-element-spacer-captcha <?php echo $name; ?>-element-spacer">
        <?php if ($label = $element->getLabel()) : ?>
            <label for="<?php echo $uniqueId; ?>" <?php echo $element->getCss('label', $labelCss); ?>>
                <?php echo $label; ?>
                <?php if ($element->getRequired() && strlen($requiredText)) : ?>
                    <span class="iphorm-required"><?php echo esc_html($requiredText); ?></span>
                <?php endif; ?>
                <?php include IPHORM_INCLUDES_DIR . '/elements/_tooltip-icon.php'; ?>
            </label>
        <?php endif; ?>
        <div class="iphorm-input-wrap iphorm-input-wrap-captcha <?php echo $name; ?>-input-wrap" <?php echo $element->getCss('inner', $leftMarginCss); ?>>
            <input class="iphorm-element-captcha <?php echo $tooltipInputClass; ?> <?php echo $name; ?>" id="<?php echo $uniqueId; ?>" type="text" name="<?php echo $name; ?>" <?php echo $tooltipTitle; ?> value="<?php echo esc_attr($value); ?>" <?php echo $element->getCss('input'); ?> />
            <?php include IPHORM_INCLUDES_DIR . '/elements/_description.php'; ?>
        </div>
        <div class="iphorm-captcha-image-wrap iphorm-clearfix <?php echo $name; ?>-captcha-image-wrap" <?php echo $element->getCss(null, $leftMarginCss); ?>>
            <div class="ifb-captcha-image-inner">
                <img id="iphorm-<?php echo $uniqueId; ?>-captcha-image" class="iphorm-captcha-image" src="<?php echo IPHORM_PLUGIN_URL . '/includes/captcha.php?c=' . $captchaConfig . '&amp;t=' . microtime(true); ?>" alt="" />
            </div>
        </div>

        <script type="text/javascript">
        <!--
        jQuery(document).ready(function ($) {
            $('#iphorm-<?php echo $uniqueId; ?>-captcha-image').hover(function () {
                $(this).stop().fadeTo('slow', '0.3');
            }, function () {
                $(this).stop().fadeTo('slow', '1.0');
            }).click(function () {
                var newSrc = $(this).attr('src').replace(/&t=.+/, '&t=' + new Date().getTime());
                $(this).attr('src', newSrc);
            });
        });
        //-->
        </script>
        <?php include IPHORM_INCLUDES_DIR . '/elements/_errors.php'; ?>
    </div>
</div>