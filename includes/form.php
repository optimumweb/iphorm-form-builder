<?php
if (!defined('IPHORM_VERSION')) exit;
$formId = $form->getId();
$formUniqueId = $form->getUniqId();
$useAjax = $form->getUseAjax();
$formClasses = array();
if ($form->getUseUniformJs()) {
    $formClasses[] = "iphorm-uniform-theme-{$form->getUniformJsTheme()}";
}
if (strlen($theme = $form->getTheme())) {
    $theme = explode('|', $theme);
    $formClasses[] = "iphorm-theme-{$theme[0]}-{$theme[1]}";
}
if ($form->hasConditionalLogic()) {
    $formClasses[] = 'iphorm-has-logic';
}
$requiredText = $form->getRequiredText();
?>
<div id="iphorm-outer-<?php echo $formUniqueId; ?>" class="iphorm-outer iphorm-outer-<?php echo $formId; ?> <?php echo join(' ', $formClasses); ?>" <?php echo $form->getCss('formOuter'); ?>>
    <script type="text/javascript">
	<!--
	<?php if (($recaptchaElement = $form->getRecaptchaElement()) instanceof iPhorm_Element_Recaptcha) : ?>
	var RecaptchaOptions = {
	    theme : '<?php echo $recaptchaElement->getRecaptchaTheme(); ?>',
	    lang: '<?php echo $recaptchaElement->getRecaptchaLang(); ?>'
	};
	<?php endif; ?>
	    jQuery(document).ready(function($) {
			<?php if ($form->hasConditionalLogic()) : ?>
			    iPhorm.logic[<?php echo $formId; ?>] = <?php echo $form->getConditionalLogicJson(); ?>;
			<?php endif; ?>

	        <?php if ($useAjax) : ?>
	        	$('#iphorm-<?php echo $formUniqueId; ?>').iPhorm(<?php echo $form->getJsConfig(); ?>);
	        <?php endif; ?>

	        <?php if ($form->getUseTooltips()) : ?>
	        if ($.isFunction($.fn.qtip)) {
	            $('.iphorm-tooltip-hover', iPhorm.instance.$form).qtip({
	                style: {
	                    classes: '<?php echo $form->getTooltipClasses(); ?>'
	                },
	                position: {
	                    my: '<?php echo $form->getTooltipMy(); ?>',
	                    at: '<?php echo $form->getTooltipAt(); ?>'
	                }
	            });
	            $('.iphorm-tooltip-click', iPhorm.instance.$form).qtip({
	                style: {
	                    classes: '<?php echo $form->getTooltipClasses(); ?>'
	                },
	                position: {
	                    my: '<?php echo $form->getTooltipMy(); ?>',
	                    at: '<?php echo $form->getTooltipAt(); ?>'
	                },
	                show: {
	                    event: 'focus'
	                },
	                hide: {
	                    event: 'unfocus'
	                }
	            });
	            $('.iphorm-tooltip-icon-hover', iPhorm.instance.$form).qtip({
	                style: {
	                    classes: '<?php echo $form->getTooltipClasses(); ?>'
	                },
	                position: {
	                    my: '<?php echo $form->getTooltipMy(); ?>',
	                    at: '<?php echo $form->getTooltipAt(); ?>'
	                },
	                content: {
	                    text: function (api) {
	                        return $(this).find('.iphorm-tooltip-icon-content').html();
	                    }
	                }
	            });
	            $('.iphorm-tooltip-icon-click', iPhorm.instance.$form).qtip({
	                style: {
	                    classes: '<?php echo $form->getTooltipClasses(); ?>'
	                },
	                position: {
	                    my: '<?php echo $form->getTooltipMy(); ?>',
	                    at: '<?php echo $form->getTooltipAt(); ?>'
	                },
	                show: {
	                    event: 'click'
	                },
	                hide: {
	                    event: 'unfocus'
	                },
	                content: {
	                    text: function (api) {
	                        return $(this).find('.iphorm-tooltip-icon-content').html();
	                    }
	                }
	            });
	            $('.iphorm-labels-inside > .iphorm-element-spacer > label').hover(function () {
	                $(this).siblings('.iphorm-input-wrap').find('.iphorm-tooltip-hover').qtip('show');
	            }, function () {
	            	$(this).siblings('.iphorm-input-wrap').find('.iphorm-tooltip-hover').qtip('hide');
	            });
	        }
	        <?php endif; ?>

	        <?php if ($form->getUseUniformJs()) : ?>
	        if ($.isFunction($.fn.uniform)) {
	            $('select, input:checkbox, input:radio', iPhorm.instance.$form).uniform({context: iPhorm.instance.$form});
	        }
	        <?php endif; ?>

	        if ($.isFunction($.fn.inFieldLabels)) {
	            $('.iphorm-labels-inside:not(.iphorm-element-wrap-recaptcha) > .iphorm-element-spacer > label', iPhorm.instance.$form).inFieldLabels();
	        }

	        <?php if (!get_option('iphorm_disable_jqueryui_output') && $form->hasDatepickerElement()) : ?>
	            if ($.isFunction($.fn.datepicker)) {
	            	<?php if (strlen($form->getjQueryUITheme())) : ?>
	                    if (!$('#iphorm-jqueryui-theme').length) {
	                        var themeUrl = iphormL10n.plugin_url + '/js/jqueryui/themes/<?php echo $form->getjQueryUITheme(); ?>/jquery-ui-1.8.16.custom.css';
	                        $('head').append('<link id="iphorm-jqueryui-theme" rel="stylesheet" href="' + themeUrl + '" type="text/css" />');
	                    }
	                <?php endif; ?>
	                <?php if (strlen($form->getjQueryUIL10n())) : ?>
	                     $.getScript('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/i18n/jquery.ui.datepicker-<?php echo $form->getjQueryUIL10n(); ?>.js');
	                <?php endif; ?>
	            }
	        <?php endif; ?>

	        $('.iphorm-group-row > div:last-child:not(:first-child)', iPhorm.instance.$form).add('.iphorm-group-row:last-child', iPhorm.instance.$form).addClass('last-child');

	        <?php if ($form->hasConditionalLogic()) : ?>
	            iPhorm.instance.applyAllLogic(true);
	            $('#iphorm-outer-<?php echo $formUniqueId; ?>').css('visibility', 'visible');
	        <?php endif; ?>
	    }); // end document.ready()
	//-->
	</script>
    <form id="iphorm-<?php echo $formUniqueId; ?>" class="iphorm" action="" method="post" enctype="multipart/form-data">
        <div class="iphorm-inner iphorm-inner-<?php echo $formId; ?>" <?php echo $form->getCss('formInner'); ?>>
            <input type="hidden" name="iphorm_id" value="<?php echo esc_attr($formId); ?>" />
            <input type="hidden" name="iphorm_uid" value="<?php echo esc_attr($formUniqueId); ?>" />
            <input type="hidden" name="form_url" value="<?php echo esc_attr(iphorm_get_current_url()); ?>" />
            <input type="hidden" name="referring_url" value="<?php echo esc_attr(iphorm_get_http_referer()); ?>" />
            <input type="hidden" name="post_id" value="<?php echo esc_attr(iphorm_get_current_post_id()); ?>" />
            <input type="hidden" name="post_title" value="<?php echo esc_attr(iphorm_get_current_post_title()); ?>" />
            <?php if ($form->hasConditionalLogic()) : ?>
            <input type="hidden" name="hcle" value="" />
            <?php endif; ?>
            <?php if (strlen(($formTitle = $form->getTitle()))) : ?>
                <h3 class="iphorm-title" <?php echo $form->getCss('title'); ?>><?php echo do_shortcode($formTitle); ?></h3>
            <?php endif; ?>
            <?php if (strlen(($formDescription = $form->getDescription()))) : ?>
                <p class="iphorm-description" <?php echo $form->getCss('description'); ?>><?php echo do_shortcode($formDescription); ?></p>
            <?php endif; ?>
            <?php if ($form->getSuccessMessagePosition() == 'above') : ?>
            	<?php if ($form->getSubmitted() && isset($successMessage) && strlen($successMessage)) : ?>
            	    <div class="iphorm-success-message" <?php echo $form->getCss('success'); ?>><?php echo $successMessage; ?></div>
            	<?php else : ?>
            		<div class="iphorm-success-message <?php if (!$form->getSubmitted()) echo 'iphorm-hidden'; ?>" <?php echo $form->getCss('success'); ?>></div>
            	<?php endif; ?>
            <?php endif; ?>
            <div class="iphorm-elements iphorm-elements-<?php echo $formId; ?> iphorm-clearfix" <?php echo $form->getCss('elements'); ?>>
                <?php
                    $columnData = array();
                    $elements = $form->getElements();
                    $labelData = array(array(
                        'placement' => $form->getLabelPlacement(),
                        'width' => $form->getLabelWidth()
                    ));
                    $tooltipData = array(array(
                        'type' => $form->getTooltipType(),
                        'event' => $form->getTooltipEvent()
                    ));

                    while (list($key, $element) = each($elements)) {
                        $elementClass = get_class($element);

                        // Label data
                        $currentLabelData = end($labelData);
                        $labelPlacement = $currentLabelData['placement'];
                        $labelWidth = $currentLabelData['width'];

                        // Tooltip data
                        $currentTooltipData = end($tooltipData);
                        $tooltipType = $currentTooltipData['type'];
                        $tooltipEvent = $currentTooltipData['event'];

                        // Per-element data
                        if ($elementClass != 'iPhorm_Element_Groupstart') {
                            // Labels
                            if ($element->getLabelPlacement() != 'inherit') {
                                $labelPlacement = $element->getLabelPlacement();
                                if ($labelPlacement == 'left') {
                                    $labelWidth = strlen($element->getLabelWidth()) ? $element->getLabelWidth() : $labelWidth;
                                }
                            }
                            // Tooltips
                            if ($element->getTooltipType() != 'inherit') $tooltipType = $element->getTooltipType();
                            if ($element->getTooltipEvent() != 'inherit') $tooltipEvent = $element->getTooltipEvent();
                        }

                        // Label CSS styles
                        $labelCss = ($labelPlacement == 'left' && strlen($labelWidth)) ? array('width' => $labelWidth) : null;
                        $leftMarginCss = ($labelPlacement == 'left' && strlen($labelWidth)) ? array('margin-left' => $labelWidth) : null;

                        // Tooltip settings
                        if (($form->getUseTooltips() && strlen($element->getTooltip()) && $tooltipType == 'field')) {
                            $tooltipInputClass = 'iphorm-tooltip iphorm-tooltip-' . $tooltipEvent;
                            $tooltipTitle = 'title="' . esc_attr($element->getTooltip()) . '"';
                        } else {
                            $tooltipInputClass = '';
                            $tooltipTitle = '';
                        }

                        // Other common variables
                        $uniqueId = $element->getUniqueId();
                        $name = $element->getName();

                        // Display each element
                        switch ($elementClass) {
                            case 'iPhorm_Element_Captcha':
                                include IPHORM_INCLUDES_DIR . '/elements/captcha.php';
                                break;
                            case 'iPhorm_Element_Checkbox':
                                include IPHORM_INCLUDES_DIR . '/elements/checkbox.php';
                                break;
                            case 'iPhorm_Element_Date':
                                include IPHORM_INCLUDES_DIR . '/elements/date.php';
                                break;
                            case 'iPhorm_Element_Email':
                            case 'iPhorm_Element_Text':
                                include IPHORM_INCLUDES_DIR . '/elements/text.php';
                                break;
                            case 'iPhorm_Element_File':
                                include IPHORM_INCLUDES_DIR . '/elements/file.php';
                                break;
                            case 'iPhorm_Element_Groupend':
                                include IPHORM_INCLUDES_DIR . '/elements/groupend.php';
                                // We've ended a group, remove the last added group info
                                array_pop($columnData);
                                // Change back to the previous label data
                                array_pop($labelData);
                                // Change back to previous tooltip data
                                array_pop($tooltipData);
                                break;
                            case 'iPhorm_Element_Groupstart':
                                include IPHORM_INCLUDES_DIR . '/elements/groupstart.php';
                                // We've started a new group, so save the group info
                                $columnData[] = array('count' => 0, 'target' => $element->getNumberOfColumns());
                                // Save the label data for this group
                                $labelData[] = array(
                                    'placement' => ($element->getLabelPlacement() == 'inherit') ? $labelPlacement : $element->getLabelPlacement(),
                                    'width' => strlen($element->getLabelWidth()) ? $element->getLabelWidth() : $labelWidth
                                );
                                // Save tooltip data for this group
                                $tooltipData[] = array(
                                    'type' => ($element->getTooltipType() == 'inherit') ? $tooltipType : $element->getTooltipType(),
                                    'event' => ($element->getTooltipEvent() == 'inherit') ? $tooltipEvent : $element->getTooltipEvent()
                                );
                                break;
                            case 'iPhorm_Element_Hidden':
                                include IPHORM_INCLUDES_DIR . '/elements/hidden.php';
                                break;
                            case 'iPhorm_Element_Honeypot':
                                include IPHORM_INCLUDES_DIR . '/elements/honeypot.php';
                                break;
                            case 'iPhorm_Element_Html':
                                include IPHORM_INCLUDES_DIR . '/elements/html.php';
                                break;
                            case 'iPhorm_Element_Password':
                                include IPHORM_INCLUDES_DIR . '/elements/password.php';
                                break;
                            case 'iPhorm_Element_Radio':
                                include IPHORM_INCLUDES_DIR . '/elements/radio.php';
                                break;
                            case 'iPhorm_Element_Recaptcha':
                                include IPHORM_INCLUDES_DIR . '/elements/recaptcha.php';
                                break;
                            case 'iPhorm_Element_Select':
                                include IPHORM_INCLUDES_DIR . '/elements/select.php';
                                break;
                            case 'iPhorm_Element_Textarea':
                                include IPHORM_INCLUDES_DIR . '/elements/textarea.php';
                                break;
                            case 'iPhorm_Element_Time':
                                include IPHORM_INCLUDES_DIR . '/elements/time.php';
                                break;
                        }

                        // For every non-group element, check if we are at the end of the group row and start a new row if needed
                        if (!in_array($elementClass, array('iPhorm_Element_Groupstart', 'iPhorm_Element_Hidden'))) {
                            if (count($columnData)) {
                                $endIndex = count($columnData) - 1;
                                $next = current($elements);
                                $columnData[$endIndex]['count']++;

                                if (($columnData[$endIndex]['count'] == $columnData[$endIndex]['target']) && !($next instanceof iPhorm_Element_Groupend)) {
                                    echo '</div><div class="iphorm-group-row iphorm-clearfix iphorm-group-row-' . $columnData[$endIndex]['target'] . 'cols">';
                                    $columnData[$endIndex]['count'] = 0;
                                }
                            }
                        }
                    }
                ?>
                <div class="iphorm-submit-wrap iphorm-submit-wrap-<?php echo $formId; ?> iphorm-clearfix" <?php echo $form->getCss('submitOuter'); ?>>
                	<div class="iphorm-submit-input-wrap iphorm-submit-input-wrap-<?php echo $formId; ?>" <?php echo $form->getCss('submit'); ?>>
                        <button class="iphorm-submit-element" type="submit" name="iphorm_submit" <?php echo $form->getCss('submitButton'); ?>><span <?php echo $form->getCss('submitSpan'); ?>><em <?php echo $form->getCss('submitEm'); ?>><?php echo esc_html($form->getSubmitButtonText()); ?></em></span></button>
                    </div>
                    <div class="iphorm-loading-wrap"><span class="iphorm-loading"><?php esc_html_e('Please wait...', 'iphorm'); ?></span></div>
                </div>
            </div>
            <?php if (!strlen(get_option('iphorm_licence_key'))) : ?>
                <div>
                    <a href="http://www.themecatcher.net/iphorm-form-builder/buy.php"><?php esc_html_e('Powered by Quform (unlicensed)', 'iphorm'); ?></a>
                </div>
            <?php elseif ($form->getShowReferralLink()) : ?>
                <div class="iphorm-referral-link">
                    <?php
                        $referralUrl = 'http://www.themecatcher.net/iphorm-form-builder/buy.php';
                        $referralUsername = strlen($form->getReferralUsername()) ? $form->getReferralUsername() : 'ThemeCatcher';
                        $referralUrl .= '?ref=' . $referralUsername;
                    ?>
                    <a href="<?php echo esc_attr($referralUrl); ?>"><?php echo $form->getReferralText(); ?></a>
                </div>
            <?php endif; ?>
            <?php if ($form->swfUploadEnabled()) : ?>
                <div class="iphom-upload-progress-wrap">
                    <div class="iphorm-upload-progress-bar-wrap">
                        <div class="iphorm-upload-progress-bar"></div>
                    </div>
                    <div class="iphorm-upload-info iphorm-clearfix">
                        <div class="iphorm-upload-filename"></div>
                        <div class="iphorm-upload-error"></div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($form->getSuccessMessagePosition() == 'below') : ?>
            	<?php if ($form->getSubmitted() && isset($successMessage) && strlen($successMessage)) : ?>
            	    <div class="iphorm-success-message" <?php echo $form->getCss('success'); ?>><?php echo $successMessage; ?></div>
            	<?php else : ?>
            		<div class="iphorm-success-message <?php if (!$form->getSubmitted()) echo 'iphorm-hidden'; ?>" <?php echo $form->getCss('success'); ?>></div>
            	<?php endif; ?>
            <?php endif; ?>
        </div>
        <?php if (current_user_can('iphorm_build_form') && $form->getId() > 0) : ?>
        <div class="iphorm-edit-form-wrap">
            <a class="iphorm-edit-form" href="<?php echo admin_url('/admin.php?page=iphorm_form_builder&amp;id=' . $formId);?>"><?php esc_html_e('Edit this form', 'iphorm'); ?></a>
        </div>
        <?php endif; ?>
    </form>
    <script type="text/javascript">
	<!--
	jQuery('#iphorm-outer-<?php echo $formUniqueId; ?> script').remove();
	//-->
	</script>
</div>