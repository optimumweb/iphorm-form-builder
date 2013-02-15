<?php
if (!defined('IPHORM_VERSION')) exit;
$errors = $element->getErrors();
$count = count($errors);
?>
<div class="iphorm-errors-wrap <?php if (!$count) echo 'iphorm-hidden'; ?>" <?php echo $element->getCss(null, $leftMarginCss); ?>>
    <?php if ($count) :?>
    <div class="iphorm-errors-list">
        <?php foreach ($errors as $error) : ?>
            <div class="iphorm-error"><?php echo esc_html($error); ?></div>
            <?php break; ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>