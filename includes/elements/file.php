<?php
if (!defined('IPHORM_VERSION')) exit;
$allowedExtensions = $element->getFileUploadValidator()->getAllowedExtensions();

$swfUploadEnabled = $element->getEnableSwfUpload();
$swfUploadAllowedExtensions = '*.*';
if (count($allowedExtensions)) {
    $swfUploadDialogText = __('Allowed Files', 'iphorm');
    $swfUploadAllowedExtensions = '';
    foreach ($allowedExtensions as $allowedExtension) {
        $swfUploadAllowedExtensions .= '*.' . $allowedExtension . '; ';
    }
    $swfUploadAllowedExtensions = substr($swfUploadAllowedExtensions, 0, -2);
} else {
    $swfUploadDialogText = __('All Files', 'iphorm');
}
?>
<div class="iphorm-element-wrap iphorm-element-wrap-file <?php echo $name; ?>-element-wrap iphorm-clearfix iphorm-labels-<?php echo $labelPlacement; ?> <?php echo ($element->getRequired()) ? 'iphorm-element-required' : 'iphorm-element-optional'; ?>" <?php echo $element->getCss('outer'); ?>>
    <div class="iphorm-element-spacer iphorm-element-spacer-file <?php echo $name; ?>-element-spacer">
        <?php if (strlen($label = $element->getLabel())) : ?>
            <label <?php echo $element->getCss('label', $labelCss); ?>>
                <?php echo $label; ?>
                <?php if ($element->getRequired() && strlen($requiredText)) : ?>
                    <span class="iphorm-required"><?php echo esc_html($requiredText); ?></span>
                <?php endif; ?>
                <?php include IPHORM_INCLUDES_DIR . '/elements/_tooltip-icon.php'; ?>
            </label>
        <?php endif; ?>
        <div class="iphorm-input-outer-wrap <?php echo $name; ?>-input-outer-wrap" <?php echo $element->getCss(null, $leftMarginCss); ?>>
            <?php $uploadNumFields = (int) $element->getUploadNumFields();
                if ($element->getIsMultiple() && $uploadNumFields > 0) : ?>
                    <?php for ($i = 0; $i < $uploadNumFields; $i++) : ?>
                        <div class="iphorm-input-wrap iphorm-input-wrap-file iphorm-clearfix <?php echo $name; ?>-input-wrap" <?php echo $element->getCss('inner', $leftMarginCss); ?>>
                            <span class="iphorm-element-file-inner"><input class="iphorm-element-file <?php echo $tooltipInputClass; ?> <?php echo $name; ?>" type="file" name="<?php echo $name; ?>[]" <?php echo $tooltipTitle; ?> tabindex="-1" /></span>
                        </div>
                    <?php endfor; ?>
                    <?php if ($element->getUploadUserAddMore()) : ?>
                        <?php $uploadAddAnotherText = strlen($element->getUploadAddAnotherText()) ? $element->getUploadAddAnotherText() : __('Upload another', 'iphorm'); ?>
                        <div class="iphorm-hidden iphorm-add-another-upload <?php echo $name; ?>-add-another-upload iphorm-clearfix">
                            <span class="iphorm-add-another-upload-button"><?php echo esc_html($uploadAddAnotherText); ?></span>
                        </div>
                        <script type="text/javascript">
                        <!--
                        jQuery(document).ready(function ($) {
                            $('.<?php echo $name; ?>-add-another-upload', iPhorm.instance.$form).show().find('span').click(function (e) {
                                var $newFileElement = $('<div class="iphorm-input-wrap iphorm-input-wrap-file iphorm-clearfix <?php echo $name; ?>-input-wrap"><span class="iphorm-element-file-inner"><input class="iphorm-element-file <?php echo $tooltipInputClass; ?> <?php echo $name; ?>" type="file" name="<?php echo $name; ?>[]" <?php echo $tooltipTitle; ?> tabindex="-1" /></span></div>');
                                $('.<?php echo $name; ?>-input-outer-wrap .iphorm-input-wrap:last').after($newFileElement);
                                $newFileElement.addClass('iphorm-add-another-file-wrap').show();

                                <?php if ($form->getUseUniformJs()) : ?>
                                if ($.isFunction($.fn.uniform)) {
                                    $newFileElement.find('input:file').uniform({
                                        fileDefaultText: '<?php echo $element->getDefaultText(); ?>',
                                        fileBtnText: '<?php echo $element->getBrowseText(); ?>'
                                    });
                                }
                                <?php endif; ?>
                            });
                        });
                        //-->
                        </script>
                <?php endif; ?>
            <?php else : ?>
                <div class="iphorm-input-wrap iphorm-input-wrap-file iphorm-clearfix <?php echo $name; ?>-input-wrap" <?php echo $element->getCss('inner'); ?>>
                    <span class="iphorm-element-file-inner"><input class="iphorm-element-file <?php echo $tooltipInputClass; ?> <?php echo $name; ?>" type="file" name="<?php echo $name; ?>" <?php echo $tooltipTitle; ?> tabindex="-1" /></span>
                </div>
            <?php endif; ?>
            <?php if ($form->getUseUniformJs()) : ?>
                <script type="text/javascript">
                <!--
                jQuery(document).ready(function ($) {
                    if ($.isFunction($.fn.uniform)) {
                        $('.<?php echo $name; ?>-element-wrap input:file', iPhorm.instance.$form).uniform({
                            fileDefaultText: '<?php echo $element->getDefaultText(); ?>',
                            fileBtnText: '<?php echo $element->getBrowseText(); ?>'
                        });
                    }
                });
                //-->
                </script>
            <?php endif; ?>
            <script type="text/javascript">
            <!--
            jQuery(document).ready(function ($) {
              	$('.<?php echo $name; ?>-input-wrap', iPhorm.instance.$form).show();
            });
            //-->
            </script>
            <?php if ($useAjax && $swfUploadEnabled) : ?>
                <div id="<?php echo $uniqueId; ?>-swfupload" class="iphorm-swfupload">
                	<div class="iphorm-clearfix">
                        <div id="<?php echo $uniqueId; ?>-file-queue" class="iphorm-file-queue iphorm-clearfix"></div>
                        <div id="<?php echo $uniqueId; ?>-file-queue-errors" class="iphorm-queue-errors iphorm-hidden"></div>
                        <div class="iphorm-swfupload-browse-wrap iphorm-clearfix">
                            <div class="iphorm-swfupload-browse" id="<?php echo $uniqueId; ?>-browse"><?php echo $element->getBrowseText(); ?>
                                <div class="iphorm-swfupload-object" id="<?php echo $uniqueId; ?>-object"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                <!--
                jQuery(document).ready(function ($) {
                    iPhorm.instance.addUploader({
                        id: <?php echo $element->getId(); ?>,
                        name: '<?php echo $name; ?>',
                        uniqueId: '<?php echo $uniqueId; ?>',
                        fileTypes: '<?php echo $swfUploadAllowedExtensions; ?>',
                        fileTypesDescription: '<?php echo $swfUploadDialogText; ?>',
                        fileSizeLimit : "<?php echo $element->getFileUploadValidator()->getMaximumFileSize(); ?>B",
                        fileUploadLimit : <?php echo $element->getAllowMultipleUploads() ? 0 : 1; ?>
                    });
                });                
                //-->
                </script>
            <?php endif; ?>
            <?php include IPHORM_INCLUDES_DIR . '/elements/_description.php'; ?>
        </div>
        <?php include IPHORM_INCLUDES_DIR . '/elements/_errors.php'; ?>
    </div>
</div>