jQuery(document).ready(function ($) {
	$('.iphorm-delete-form').click(function () {
		return confirm(iphormAdminL10n.single_delete_message);
	});
	
	$('.iphorm-delete-entry').click(function () {
		return confirm(iphormAdminL10n.single_delete_entry_message);
	});
	
	$('.iphorm-bulk-delete-go').click(function () {
		if ($('input[name="form[]"]:checked').length > 0) {
			if ($('#iphorm-bulk-action').val() == 'delete') {
				return confirm(iphormAdminL10n.plural_delete_message);
			}
		} else {
			return false;
		}
	});
	
	$('.iphorm-bulk-delete-go2').click(function () {
		if ($('input[name="form[]"]:checked').length > 0) {
			if ($('#iphorm-bulk-action2').val() == 'delete') {
				return confirm(iphormAdminL10n.plural_delete_message);
			}
		} else {
			return false;
		}
	});
	
	$('.iphorm-bulk-delete-entry-go').click(function () {
		if ($('input[name="entry[]"]:checked').length > 0) {
			if ($('#iphorm-bulk-action').val() == 'delete') {
				return confirm(iphormAdminL10n.plural_delete_entry_message);
			}
		} else {
			return false;
		}
	});
	
	$('.iphorm-bulk-delete-entry-go2').click(function () {
		if ($('input[name="entry[]"]:checked').length > 0) {
			if ($('#iphorm-bulk-action2').val() == 'delete') {
				return confirm(iphormAdminL10n.plural_delete_entry_message);
			}
		} else {
			return false;
		}
	});
	
	function pulseIn($element, callback)
	{
		$element.animate({  			
			borderTopColor: '#0F83CA',
			borderRightColor: '#0F83CA',
			borderBottomColor: '#0F83CA',
			borderLeftColor: '#0F83CA'
		}, 300, function () {
			if (typeof callback === 'function') {
				callback.apply($element);
			}
		});
	}
	
	function pulseOut($element, callback)
	{
		$element.animate({  			
			borderTopColor: '#DDDDDD',
			borderRightColor: '#DDDDDD',
			borderBottomColor: '#DDDDDD',
			borderLeftColor: '#DDDDDD'
		}, 300, function () {
			if (typeof callback === 'function') {
				callback.apply($element);
			}
		});
	}
	
	if (pagenow == 'quform_page_iphorm_help') {
		if (document.location.hash && $(document.location.hash).length) {
			if (document.location.hash != '#top') {
				$('h3').removeAttr('style');
				pulseIn($(document.location.hash).parents('h3'), function () {
					pulseOut(this, function () {
						pulseIn(this);
					});
				});
			}
		}
		
		$('a[href*=#]').click(function(){			
		    var elemId = '#' + $(this).attr('href').split('#')[1];
		    if (elemId != '#top') {
				$('h3').removeAttr('style');
				pulseIn($(elemId).parents('h3'), function () {
					pulseOut(this, function () {
						pulseIn(this);
					});
				});
		    }
		});
	}
	
	$('.iphorm-export-data textarea').click(function () {
		$(this).select();
	});
	
	$('#iphorm-filter-epp').change(function () {
		$('form#iphorm-entries-filter').submit();
	});
	
	$('#global_email_sending_method').change(function () {
		if ($(this).val() == 'smtp') {
			$('.iphorm-show-if-smtp-on').show();
		} else {
			$('.iphorm-show-if-smtp-on').hide();
		}
	});
	
	var mouseInsideFormSwitcher = false;
    $('.iphorm-form-switcher-list').hover(function(){ 
        mouseInsideFormSwitcher=true; 
    }, function(){ 
        mouseInsideFormSwitcher=false; 
    });
    
    var mouseInsideFormSwitcherTrigger = false;
    $('#iphorm-form-switcher-trigger').hover(function(){ 
    	mouseInsideFormSwitcherTrigger=true; 
    }, function(){ 
    	mouseInsideFormSwitcherTrigger=false; 
    });
    
    $('#iphorm-form-switcher-trigger').click(function () {
    	var $list = $('.iphorm-form-switcher-list');
    	if ($list.is(':hidden')) {
    		$list.show();
    		$(this).removeClass('ifb-form-switcher-closed').addClass('ifb-form-switcher-open');
    	} else {
    		$list.hide();
    		$(this).removeClass('ifb-form-switcher-open').addClass('ifb-form-switcher-closed');
    	}
	});
    
    $('body').mouseup(function(){ 
        if(!mouseInsideFormSwitcher && !mouseInsideFormSwitcherTrigger) {
        	$('.iphorm-form-switcher-list').hide();
        	$('#iphorm-form-switcher-trigger').removeClass('ifb-form-switcher-open').addClass('ifb-form-switcher-closed');
        }
    });
    
    $('a.iphorm-external').click(function () {
    	var href = $(this).attr('href');
    	if (href.length) {
    		window.open(href);
    	}
    	return false;
    });
    
    var verifying = false;
    $('#verify-purchase-code').click(function () {
    	var purchaseCode = $('#purchase_code').val();
    	if (purchaseCode.length) {
	    	if (!verifying) {
	    		verifying = true;
	    		$('.iphorm-verify-loading').show();
	        	$.ajax({
	        		type: 'POST',
	        		url: ajaxurl,
	        		data: {
	        			action: 'iphorm_verify_purchase_code',
        				_ajax_nonce: iphormAdminL10n.verify_nonce,
        				purchase_code: purchaseCode
	        		},
	        		dataType: 'json',
	        		success: function (response) {
	        			$('.iphorm-verify-loading').hide();
	        			if (typeof response === null) {	        				
	        				addVerificationMessage(iphormAdminL10n.error_verifying, 'error');
	        			} else if (typeof response === 'object') {
	        				if (response.type === 'success') {
	        					addVerificationMessage(response.message, 'success');
	        				} else if (response.type === 'error') {
	        					addVerificationMessage(response.message, 'error');
	        				}
	        				
	        				if (typeof response.status === 'string') {
	        					if (response.status === 'valid' && $('.iphorm-valid-licence-wrap').is(':hidden')) {
	        						$('.iphorm-invalid-licence-wrap').fadeOut('slow', function () {
	        							$('.iphorm-valid-licence-wrap').fadeIn('slow');
	        						});
	        					} else if (response.status === 'invalid' && $('.iphorm-invalid-licence-wrap').is(':hidden')) {
	        						$('.iphorm-valid-licence-wrap').fadeOut('slow', function () {
	        							$('.iphorm-invalid-licence-wrap').fadeIn('slow');
	        						});
	        					}
	        				}
	        			}
	        			
	        			verifying = false;
	        		},
	        		error: function () {
	        			$('.iphorm-verify-loading').hide();
	        			addVerificationMessage(iphormAdminL10n.error_verifying, 'error');
	        			verifying = false;
	        		}
	        	});
	    	} else {
	    		alert(iphormAdminL10n.wait_verifying);
	    	}
    	}
    	
    	return false;
    }); // End verify purchase code
    
    if (pagenow === 'quform_page_iphorm_export') {
    	$('#export_entries_form_id').change(function () {
    		$('#iphorm-export-entries-fields-wrap').hide();
			var $fields = $('#iphorm-export-entries-fields').empty(),
			$spinner = $('.iphorm-export-entries-loading');
			$('#export_all_fields').attr('checked', false);
			
    		if ($(this).val() != '') {
    			$spinner.show();
    			$.ajax({
	        		type: 'POST',
	        		url: ajaxurl,
	        		data: {
	        			action: 'iphorm_get_export_field_list_ajax',
        				form_id: $(this).val()
	        		},
	        		dataType: 'json',
	        		success: function (response) {
	        			$spinner.hide();
	        			if (typeof response === null) {	        				
	        				alert(iphormAdminL10n.generic_error_try_again);
	        			} else if (typeof response === 'object') {
	        				if (response.type === 'success') {
	        					if (response.data.length) {
	        						for (var i = 0; i < response.data.length; i++) {
	        							$fields.append('<div class="iphorm-export-single-field"><label for="export_field_' + i + '"><input class="iphorm-export-field" type="checkbox" name="export_fields[]" id="export_field_' + i + '" value="' + response.data[i].value + '" /> ' + response.data[i].label + '</label></div>');
	        						}
	        					}
	        					
	        					$('#iphorm-export-entries-fields-wrap').show();
	        				}
	        			}
	        		},
	        		error: function () {
	        			$spinner.hide();
	        			alert(iphormAdminL10n.generic_error_try_again);
	        		}
	        	});
    		}
    	});
    	
    	$('#export_all_fields').click(function () {
    		if ($(this).is(':checked')) {
    			$('.iphorm-export-field').attr('checked', true);
    		} else {
    			$('.iphorm-export-field').attr('checked', false);
    		}
    	});
    	
    	var dates = $('#from, #to').datepicker({
    		dateFormat: 'yy-mm-dd',
    		onSelect: function( selectedDate ) {
	    		var option = this.id == "from" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings
				);
	    		dates.not( this ).datepicker( "option", option, date );
			}
		});
    }
    
    function addVerificationMessage(text, type)
    {
    	$('.iphorm-success-message, .iphorm-error-message').remove();
    	$('.iphorm-verify-purchase-code-wrap').after('<div class="iphorm-' + type + '-message">' + text + '</div>');    	
    }
    
    iphormPreload([
    	'/button-orange-hover.png',
    	'/button-grey-hover.png',
		'/small-spinner.gif',
		'/iphorm-warning.png',
		'/iphorm-success.png',
		'/button-blue-hover.png',
		'/help-menu-sub-level-hover.png',
		'/button-orange.png',
		'/default-loading.gif',
    ], iphormAdminL10n.admin_images_url);
}); // End document.ready

window.iphormPreloadedImages = [];
window.iphormPreload = function (images, prefix) {
	for (var i = 0; i < images.length; i++) {
		var elem = document.createElement('img');
		elem.src = prefix ? prefix + images[i] : images[i] ;
		window.iphormPreloadedImages.push(elem);
	}
};