<?php
if (!defined('IPHORM_VERSION')) exit;
if (!function_exists('recaptcha_get_html')) {
    include_once IPHORM_INCLUDES_DIR . '/recaptchalib.php';
}

$publicKey = get_option('iphorm_recaptcha_public_key');
$privateKey = get_option('iphorm_recaptcha_private_key');
$name = 'iphorm_' . $formId . '_' . $element->getId();
?>
<div class="iphorm-element-wrap iphorm-element-wrap-recaptcha <?php echo $name; ?>-element-wrap recaptcha_response_field-element-wrap iphorm-clearfix iphorm-labels-<?php echo $labelPlacement; ?> <?php echo ($element->getRequired()) ? 'iphorm-element-required' : 'iphorm-element-optional'; ?>" <?php echo $element->getCss('outer'); ?>>
    <div class="iphorm-element-spacer iphorm-element-spacer-captcha <?php echo $name; ?>-element-spacer recaptcha_response_field-element-spacer">
        <?php if (strlen($label = $element->getLabel())) : ?>
            <label for="recaptcha_response_field" <?php echo $element->getCss('label', $labelCss); ?>>
                <?php echo $label; ?>
                <?php if ($element->getRequired() && strlen($requiredText)) : ?>
                    <span class="iphorm-required"><?php echo esc_html($requiredText); ?></span>
                <?php endif; ?>
                <?php include IPHORM_INCLUDES_DIR . '/elements/_tooltip-icon.php'; ?>
            </label>
        <?php endif; ?>
        <div class="iphorm-input-wrap iphorm-input-wrap-recaptcha <?php echo $name; ?>-input-wrap recaptcha_response_field-input-wrap" <?php echo $element->getCss('inner', $leftMarginCss); ?>>
            <?php if (!strlen($publicKey) || !strlen($privateKey)) : ?>
                <?php esc_html_e('To use reCAPTCHA you must enter your API keys in the Quform settings page.', 'iphorm'); ?>
            <?php else : ?>
                <?php echo recaptcha_get_html($publicKey); ?>
            <?php endif; ?>
            <?php include IPHORM_INCLUDES_DIR . '/elements/_description.php'; ?>
        </div>
        <?php include IPHORM_INCLUDES_DIR . '/elements/_errors.php'; ?>
    </div>
</div>