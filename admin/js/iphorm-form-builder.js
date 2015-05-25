/**
 * iPhorm Form Builder for WordPress plugin
 * 
 * @copyright Copyright (c) 2011 ThemeCatcher (http://www.themecatcher.net)
 */
;(function ($, window) {
	var	$form,
	$elementsList,
	$messageArea;
	
	window.iPhorm = iPhorm = {
		form: {},
		logicableElements: [],
		
		init: function (form) {
			$form = $('#ifb');			
			if (!$form.length) {
				return;
			}
			
			iPhorm.form = form;
			
			if (form.id == 0) {
				$('body').addClass('iphorm-overlay-active');
				$('#ifb-top').addClass('ifb-new-form');
				$('#ifb-new-form-name-overlay').fadeIn(1000);
				$('#new_form_name').focus().keyup(function (event) {
					if (event.keyCode == 13) {
						$('.ifb-new-form-name-ok').click();
					}
				});
				$(document).bind('keyup.iphorm', function (event) {
					if (event.keyCode == 27) {
						$('.ifb-new-form-name-close').click();
						$(document).unbind('keyup.iphorm');
					}
				});
				
				$('.ifb-new-form-name-ok').click(function () {
					var val = $('#new_form_name').val();
					if (val.length) {
						$('#name').val(val);
						iPhorm.updateFormName();
					}
				});
				
				$('.ifb-new-form-name-ok, .ifb-new-form-name-close').click(function () {
					$('body').removeClass('iphorm-overlay-active');
					$('#ifb-new-form-name-overlay').hide();
					$('#ifb-elements-empty').add($('.iphorm-current-form')).add($('.ifb-iphorm-title-form-name')).fadeIn(1000);
				});
			} else {
				$('#ifb-top').addClass('ifb-saved-form');
				$('.iphorm-current-form').add($('.ifb-iphorm-title-form-name')).fadeIn(1000);
				if (form.elements.length == 0) {
					$('#ifb-elements-empty').fadeIn(1000);
				}
			}
			
			// Prevent the enter key from doing weird stuff
			$form.submit(function(e) { e.preventDefault(); }).attr('autocomplete', 'off');
			
			// Fix for JSON.stringify if prototype.js is loaded
			if (typeof Array.prototype.toJSON == 'function') {
				delete Array.prototype.toJSON;
			}			
			
			$elementsList = $('#ifb-elements-wrap'),
			$messageArea = $('#ifb-message-area');
			
			$(window).bind('scroll.iphorm resize.iphorm', iPhorm.positionMessageBox);
			$(window).bind('scroll.iphorm resize.iphorm', iPhorm.positionRightColumn);
			$(window).bind('scroll.iphorm resize.iphorm', iPhorm.showScrollTopButton);
			
			$('#ifb-tabs').fptabs('.ifb-tabs-panel', {
				tabs: '> .ifb-tabs-nav > li',
				current: 'ifb-current-tab',
				onBeforeClick: function (event, index) {
					if (index == 1) {
						iPhorm.update();
						iPhorm.updateSettingsDependencies();
					}
				}
			});
			
			$('#ifb-settings-tabs').fptabs('.ifb-tabs-panel', { tabs: '> .ifb-tabs-nav > li', current: 'ifb-current-tab' });
					
			$('#ifb-add-element-tabs').fptabs('.ifb-tabs-panel', { tabs: '> .ifb-tabs-nav > li', current: 'ifb-current-tab' });
			
			$('.ifb-tooltip').live('click', function (event) {
				$(this).qtip({
					overwrite: false, // Make sure the tooltip won't be overridden once created
			        show: {
			           event: event.type, // Use the same show event as the one that triggered the event handler
			           ready: true // Show the tooltip as soon as it's bound, vital so it shows up the first time you hover!
			        },
			        hide: {
		        		event: 'unfocus'
			        },
					style: {
						classes: 'ui-tooltip-dark'
					},
					content: {
						text: function (api) {
							return $(this).find('.ifb-tooltip-content').html();
						}
					}
				}, event);
			});
			
			$('.ifb-simple-tooltip').live('mouseover', function (event) {
				$(this).qtip({
					overwrite: false, // Make sure the tooltip won't be overridden once created
			        show: {
			           event: event.type, // Use the same show event as the one that triggered the event handler
			           ready: true // Show the tooltip as soon as it's bound, vital so it shows up the first time you hover!
			        },
					style: {
						classes: 'ui-tooltip-dark'
					},
					content: {
						text: false
					}
				}, event);
			});
			
			$('#element_background_colour, #element_border_colour, #element_text_colour, #label_text_colour').ColorPicker({
				onSubmit: function(hsb, hex, rgb, el) {
					$(el).val('#' + hex);
					$(el).ColorPickerHide();
				},
				onBeforeShow: function () {
					$(this).ColorPickerSetColor(this.value);
				},
				onChange: function (hsb, hex, rgb) {
					$($(this).data('colorpicker').el).val('#'+hex);
				}
			})
			.bind('keyup', function(){
				$(this).ColorPickerSetColor(this.value);
			});
			
			$('#ifb-first-save-close').click(function () {
				$('#iphorm-add-to-website').removeClass('ifb-add-to-website-open').addClass('ifb-add-to-website-closed');
				$('#ifb-first-save-message').hide();
			});
			
			$('.ifb-message-more').live('click', function () {
				$(this).parent().find('.ifb-message-more-content').fadeIn('slow');
				return false;
			});
			
			$('h3.ifb-show-atw-content').click(function () {
				$(this).next().slideToggle(400);
			});
			
			$('.ifb-show-first-time-save').live('click', function () {
				if (!iPhorm.isScrolledIntoView($('#iphorm-add-to-website'))) {
					$.smoothScroll({
						scrollTarget: $('#iphorm-add-to-website'),
						offset: -50,
						speed: 1000,
						afterScroll: function () {
							$('#iphorm-add-to-website').click();
						}
					});
				} else {
					$('#iphorm-add-to-website').click();
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
		    
		    $('#iphorm-add-to-website').click(function () {
		    	var $message = $('#ifb-first-save-message');
		    	if ($message.is(':hidden')) {
		    		$message.fadeIn();
		    		$(this).removeClass('ifb-add-to-website-closed').addClass('ifb-add-to-website-open');
		    	} else {
		    		$message.hide();
		    		$(this).removeClass('ifb-add-to-website-open').addClass('ifb-add-to-website-closed');
		    	}
		    });
		    
		    $('#ifb-scroll-top').click(function () {
		    	$.smoothScroll({
					scrollTarget: $('#ifb-top'),
					offset: -50,
					speed: 1000
				});

		    	return false;
		    });
		    
			if (form.elements.length) {
				$form.addClass('ifb-has-elements');
				// Click to edit element label
				for (var i = 0; i < form.elements.length; i++) {
					var element = form.elements[i];
					(function (e) {
						$('.ifb-preview-label-content', '#ifb-element-wrap-' + e.id).editable(function (value, settings) {
							iPhorm.savePreviewLabel(value, iPhorm.getElementById(e.id));
							return value;
						}, {
							onblur: 'submit',							
							onreset: function (settings, self) {
								iPhorm.savePreviewLabel(self.revert, iPhorm.getElementById(e.id));
							},
							placeholder: ''
						});
					})(element);
					
					switch (element.type) {
						case 'select':
						case 'radio':
						case 'checkbox':
							iPhorm.logicableElements.push(element);
						break;
					}					
				}
				
				iPhorm.syncAllLogic(false);
			} else {
				$form.addClass('ifb-no-elements');
			}						
									
			iPhorm.updateFormTitle();			
			// Click to edit element title
			$('#ifb-title').editable(function (value, settings) {
				$('#title').val(value);
				return value;
			}, {
				onblur: 'submit',							
				onreset: function (settings, self) {
					$('#title').val(self.revert);
				},
				placeholder: ''
			});
			
			iPhorm.updateFormDescription();
			// Click to edit element description
			$('#ifb-description').editable(function (value, settings) {
				$('#description').val(value);
				return value;
			}, {
				type: 'textarea',
				onblur: 'submit',							
				onreset: function (settings, self) {
					$('#description').val(self.revert);
				},
				height: 60,
				placeholder: ''
			});
			
			$('#ifb-current-form-name').editable(function (value, settings) {
				$('#name').val(value);
				iPhorm.updateFormName();
				return value;
			}, {
				onblur: 'submit',							
				onreset: function (settings, self) {
					$('#name').val(value);
					iPhorm.updateFormName();
				},
				placeholder: ''
			});
			
			for (var i = 0; i < form.conditional_recipients.length; i++) {
				iPhorm.addConditionalRecipient(form.conditional_recipients[i]);
			}
						
			iPhorm.updateTooltipStyle();
			
			for (var field in iPhorm.form.db_fields) {
				iPhorm.addDbField(field, iPhorm.form.db_fields[field]);
			}
												
			$('.ifb-element-settings-tabs').fptabs('.ifb-tabs-panel', { tabs: '> .ifb-tabs-nav > li', current: 'ifb-current-tab' });
			
			// Make the elements sortable
			$('#ifb-elements-wrap').sortable({
				placeholder: 'ifb-sortable-placeholder',
				stop: function (event, ui) {
					var elementType = ui.item.data('type');
					if (typeof elementType === 'string') {
						var index = ui.item.index();
						ui.item.remove();
						iPhorm.addElement(elementType, index, iPhorm.sortElements);						
					} else {
						iPhorm.sortElements();
					}
				},
				delay: 100,
				revert: true,
				handle: '.ifb-move-link, .ifb-element-preview, .ifb-element-preview span.ifb-handle, p.ifb-recaptcha-empty',
				start: function (e, ui) {
			        ui.placeholder.html('<span/>');
			    },
			    tolerance: 'pointer',
			    opacity: 0.4
			});
			
			// Make the right hand add element buttons draggable to the element list
			$('.ifb-add-element-ul div').draggable({
				connectToSortable: '#ifb-elements-wrap',
				helper: 'clone',
				delay: 100,
				start: function (event, ui) {
					if (typeof document.selection === 'object') {
						document.selection.empty();
					}
				}
			}).disableSelection();
			
			// Entries table layout sortable
			$('#ifb-active-columns').sortable({
				connectWith: '#ifb-inactive-columns',
				placeholder: 'ifb-columnsort-ph',
				revert: true,
				//tolerance: 'pointer',
				opacity: 0.4
			});
			
			$('#ifb-inactive-columns').sortable({
				connectWith: '#ifb-active-columns',
				placeholder: 'ifb-columnsort-ph',
				revert: true,
				//tolerance: 'pointer',
				opacity: 0.4
			});
			
			iPhorm.updateSettingsDependencies();
			
			if (window.location.hash == '#ifb-settings-entries') {
				$('#ifb-tabs').data('tabs').click(1);
				$('#ifb-settings-tabs').data('tabs').click(3);
			}

			$('.ifb-wrap').show();
			$(window).resize();
		},
		
		/**
		 * Add an element to the form
		 * 
		 * Gets the element HTML via Ajax and inserts it into the element list. Also
		 * adds the element to the form object.
		 * 
		 * @param string type The type of element to add
		 * @param int position The position of the element in the list
		 * @param function callback Callback executed after element has been added
		 * @param object element Type element object (if converting)
		 */
		addElement: function (type, position, callback, element) {
			if (type == 'group') {
				gsPosition = (typeof position == 'number') ? position : null;
				gePosition = (typeof position == 'number') ? position + 1 : null;
				iPhorm.addElement('groupstart', gsPosition, function () {
					iPhorm.addElement('groupend', gePosition, callback);
				});				
				return;
			}
			
			// Set the form tab active
			$('#ifb-tabs').data('tabs').click(0);
			
			if (iPhorm.form.elements.length == 0) {
				$('#ifb-elements-empty').hide();
				$form.removeClass('ifb-no-elements').addClass('ifb-has-elements');
			}
			
			element = element || {
				id: iPhorm.getNextElementId(),
				type: type
			};
			
			var errorCallback = function () {
				this.remove();
				
				var checkIfEmpty = function () {
					if (iPhorm.form.elements.length == 0) {
						$('#ifb-elements-empty').show();
						$form.removeClass('ifb-has-elements').addClass('ifb-no-elements');
					}
				};
				
				if (type == 'groupend') {
					// If adding the groupend element failed, delete the corresponding groupstart
					iPhorm.deleteElement(element.id-1, true, function () {
						checkIfEmpty();
					});
				} else {
					checkIfEmpty();
				}
			};
			
			var $placeholder = iPhorm.getPlaceholder('element');
			
			if (typeof position !== 'number') {
				position = iPhorm.form.elements.length;
			}
			
			if (position === 0) {
				$elementsList.prepend($placeholder);
			} else if (position == iPhorm.form.elements.length) {
				$elementsList.append($placeholder);
			} else {
				$elementsList.find('.ifb-element-wrap:nth-child(' + position + ')').after($placeholder);
			}
			
			iPhorm.setLabelPlacement();
			
			$.ajax({
				type: 'POST',
				async: false,
				url: ajaxurl,
				context: $placeholder,
				data: {
			       action: 'iphorm_get_element',
			       element: JSON.stringify(element),
			       form: JSON.stringify(iPhorm.form)
				},
				dataType: 'json',
				success: function (response) {
					if (response === null) {
						errorCallback.apply(this);
						iPhorm.formatAddMessage(iphormL10n.error_adding_element, 'error', 10);
					} else if (typeof response === 'object') {
						if (response.type == 'success') {
							element = response.data.element;
							this.replaceWith(response.data.html);
							$('#ifb-element-settings-tabs-' + element.id).fptabs('.ifb-tabs-panel', { tabs: '> .ifb-tabs-nav > li', current: 'ifb-current-tab' });
							$('#ifb-element-wrap-' + element.id).fadeIn('slow');
							
							iPhorm.form.elements.splice(position, 0, element);
							
							if (element.type == 'radio' || element.type == 'select') {
								// Add this element to the conditional recipient element lists
								$('#ifb-conditional-recipient-list > li').each(function () {
									$(this).find('.ifb-conditional-element').append($('<option/>', { value: element.id, text: iPhorm.getShortenedAdminLabel(element) }));
								});
							}
							
							// Click to edit element label
							$('.ifb-preview-label-content', '#ifb-element-wrap-' + element.id).editable(function (value, settings) {
								iPhorm.savePreviewLabel(value, element);
								return value;
							}, {
								onblur: 'submit',							
								onreset: function (settings, self) {
									iPhorm.savePreviewLabel(self.revert, element);
								},
								placeholder: ''
							});
							
							// Add default filters and validators, sync conditional logic
							switch (element.type) {
								case 'text':
								case 'textarea':
									iPhorm.addFilter(element, 'trim');
									iPhorm.syncLogic(element);
									break;
								case 'email':
									iPhorm.addFilter(element, 'trim');
									iPhorm.addValidator(element, 'email');
									iPhorm.syncLogic(element);
									break;
								case 'checkbox':
								case 'select':
								case 'radio':
									iPhorm.logicableElements.push(element);
									iPhorm.syncAllLogic();
									break;
								default:
									iPhorm.syncLogic(element);
									break;
							}
							
							if (element.save_to_database == true) {
								iPhorm.addEntryLayoutColumn(element);
							}
							
							if (response.message) {						
								iPhorm.addResponseMessage(response.message);
							}
							
							if (typeof callback === 'function') {
								callback.call();
							}
						} else if (response.type == 'error') {
							errorCallback.apply(this);
							if (response.message) {
								iPhorm.addResponseMessage(response.error);
							}
						}
					}
				},
				error: function () {
					errorCallback.apply(this);
					iPhorm.formatAddMessage(iphormL10n.error_adding_element, 'error', 10);
				}
			});
		},
		
		deleteElement: function (id, force, callback) {
			if (!force && !confirm(iphormL10n.confirm_delete_element)) {
				return;
			}
			
			var element;			
			for (var i = 0; i < iPhorm.form.elements.length; i++) {
				if (iPhorm.form.elements[i].id == id) {
					element = iPhorm.form.elements[i];
					iPhorm.form.elements.splice(i, 1);
				}
			}
			
			$('#ifb-element-wrap-' + id).fadeOut('slow').hide(0, function() {				
				if (element.type == 'groupstart') {
					iPhorm.deleteElement(element.id+1, true);
				} else if (element.type == 'groupend') {
					iPhorm.deleteElement(element.id-1, true);
				}				

				$(this).remove();
								
				if (iPhorm.form.elements.length == 0) {
					$('#ifb-elements-empty').fadeIn();
					$form.removeClass('ifb-has-elements').addClass('ifb-no-elements');
				}
				
				if (!force) {
					iPhorm.addMessage(iphormL10n.element_deleted, 'success', 5);
				}
				
				iPhorm.removeEntryLayoutColumn(element);
				
				switch (element.type) {
					case 'select':
					case 'checkbox':
					case 'radio':
						iPhorm.deleteLogicableElement(element);
						iPhorm.deleteDependentLogicRules(element);
						iPhorm.syncAllLogic(false, true);
					break;
				}
				
				if (typeof callback === 'function') {
					callback.apply(this);
				}
			});
			
			// Check if there are any conditional rules on this element and delete them
			$('#ifb-conditional-recipient-list > li').each(function () {
				if ($(this).find('.ifb-conditional-element').val() == id) {
					iPhorm.deleteConditionalRecipient($(this).data('id'));
				}
			});
		},
		
		/**
		 * Convert an element to another type
		 * 
		 * @param object element The original element
		 * @param string target Type The name of the target element type
		 */
		convertElement: function (element, targetList) {
			var targetType = $(targetList).val();
			if (targetType == '' || !confirm(iphormL10n.confirm_convert_element)) {
				return;
			}
			
			var convertIt = function (element) {
				var clone = $.extend(true, {}, element),
				position = iPhorm.getElementPosition(element);
				clone.id = iPhorm.getNextElementId();
				clone.type = targetType;

				iPhorm.deleteElement(element.id, true, function () {
					iPhorm.addElement(null, position, null, clone);
				});	
			};

			switch (element.type) {
				case 'radio':
					if (targetType == 'select' || targetType == 'checkbox') {
						convertIt(element);
					}
					break;
				case 'select':
					if (targetType == 'radio' || targetType == 'checkbox') {
						convertIt(element);
					}
					break;
				case 'checkbox':
					if (targetType == 'radio' || targetType == 'select') {
						convertIt(element);
					}
					break;
			}
		},
		
		/**
		 * Save the form
		 */
		save: function (nonce, onSuccess, onError) {			
			iPhorm.update();
			
			$.ajax({
				type: 'POST',
				async: false,
				url: ajaxurl,
				data: {
			       action: 'iphorm_save_form_ajax',
			       _ajax_nonce: nonce,
			       form: JSON.stringify(iPhorm.form)
				},
				dataType: 'json',
				success: function (response) {
					if (response === null) {
						iPhorm.formatAddMessage(iphormL10n.error_saving_form, 'error', 10);
						
						if (typeof onError === 'function') {
							onError.apply(this);
						}
					} else if (typeof response === 'object') {
						if (response.type == 'success') {
							var oldId = iPhorm.form.id;
							iPhorm.form.id = response.data.id;
							$('.ifb-update-form-id').text(iPhorm.form.id);
							
							if (oldId === 0) {
								$('#ifb-top').removeClass('ifb-new-form').addClass('ifb-saved-form');
								var $entriesLink = $('#iphorm-builder-to-entries-link'),
								entriesLinkHref = $entriesLink.attr('href'),
								$reloadLink = $('#iphorm-reload-link'),
								reloadLinkHref = $reloadLink.attr('href');
								$entriesLink.attr('href', entriesLinkHref.replace(/id=\d+/, 'id=' + iPhorm.form.id));
								$reloadLink.attr('href', reloadLinkHref.replace(/id=\d+/, 'id=' + iPhorm.form.id));
							}
							
							if (response.message) {
								iPhorm.addResponseMessage(response.message);
							}
							
							if (typeof onSuccess === 'function') {
								onSuccess.apply(this);
							}
						} else if (response.type == 'error') {
							if (response.message) {
								iPhorm.addResponseMessage(response.message);
							}
							
							if (typeof onError === 'function') {
								onError.apply(this);
							}
						}
					}
				},
				error: function () {
					iPhorm.formatAddMessage(iphormL10n.error_saving_form, 'error', 10);
					
					if (typeof onError === 'function') {
						onError.apply(this);
					}
				}
			});
		},
		
		saveForm: function (button, nonce)
		{
			var $save = $(button).find('.ifb-save').hide(),
			$saving = $(button).find('.ifb-saving').css('display', 'block'),
			$saved = $(button).find('.ifb-saved'),
			$saveFailed = $(button).find('.ifb-save-failed');
			
			var onSuccess = function () {				
				$saving.hide();
				$saved.css('display', 'block');
				setTimeout(function () {
					$saved.hide();
					$save.css('display', 'block');
				}, 1250);
			};
			
			var onError = function () {
				$saving.hide();
				$saveFailed.css('display', 'block');
				setTimeout(function () {
					$saveFailed.hide();
					$save.css('display', 'block');
				}, 1250);
			};
			
			iPhorm.save(nonce, onSuccess, onError);
		},
			    
	    saveElementSettings: function (button, nonce) {
			var $save = $(button).find('.ifb-save').hide(),
			$saving = $(button).find('.ifb-saving').css('display', 'block'),
			$saved = $(button).find('.ifb-saved'),
			$saveFailed = $(button).find('.ifb-save-failed');
			
			var onSuccess = function () {
				$saving.hide();
				$saved.css('display', 'block');
				setTimeout(function () {
					$saved.hide();
					$save.css('display', 'block');
				}, 1250);
			};
			
			var onError = function () {
				$saving.hide();
				$saveFailed.show();
				setTimeout(function () {
					$saveFailed.hide();
					$save.css('display', 'block');
				}, 1250);
			};
			
			iPhorm.save(nonce, onSuccess, onError);
	    },
	    
	    saveAndCloseElementSettings: function (nonce, id) {
	    	iPhorm.hideSettings(id);			
			iPhorm.save(nonce);
	    },
		
		/**
		 * Preview the form
		 */
		preview: function ()
		{
			iPhorm.update();
			window.open(iphormL10n.preview_url);
		},
		
		/**
		 * Get a given parameter from the URL
		 */
		getQueryParameter: function (key, default_) {
			if (default_==null) default_="";
			  key = key.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
			  var regex = new RegExp("[\\?&]"+key+"=([^&#]*)");
			  var qs = regex.exec(window.location.href);
			  if(qs == null)
			    return default_;
			  else
			    return qs[1];
		},
		
		/**
		 * Update the form object to match the input values
		 */
		update: function () {
			var form = this.form;
			
			// Global form settings
			form.name = $('#name').val();
			form.title = $('#title').val();
			form.description = $('#description').val();
			form.active = $('#active').is(':checked');
			form.send_notification = $('#send_notification').is(':checked');
			form.subject = $('#subject').val();
			form.customise_email_content = $('#customise_email_content').is(':checked');
			form.notification_format = $('#notification_format').val();
			form.notification_email_content = $('#notification_email_content').val();
			form.notification_reply_to_element = $('#notification_reply_to_element').val();
			form.notification_from_type = $('#notification_from_type').val();
			form.from_email = $('#from_email').val();
			form.from_name = $('#from_name').val();
			form.notification_from_element = $('#notification_from_element').val();
			form.send_autoreply = $('#send_autoreply').is(':checked');
			form.autoreply_recipient_element = $('#autoreply_recipient_element').val();
			form.autoreply_subject = $('#autoreply_subject').val();
			form.autoreply_format = $('#autoreply_format').val();
			form.autoreply_email_content = $('#autoreply_email_content').val();
			form.autoreply_from_type = $('#autoreply_from_type').val();
			form.autoreply_from_email = $('#autoreply_from_email').val();
			form.autoreply_from_name = $('#autoreply_from_name').val();
			form.autoreply_from_element = $('#autoreply_from_element').val();
			form.recipients = [];
			$('#recipients > li').each(function () {
				var email = $(this).find('input[name="ifb_recipient_email"]').val();
				if (email.length > 0) {
					form.recipients.push(email);
				}
			});			
			form.conditional_recipients = [];
			$('#ifb-conditional-recipient-list > li').each(function () {
				var conditionalRecipient = {
					id: $(this).data('id'),
					recipient: $(this).find('.ifb-conditional-recipient').val(),
					element: $(this).find('.ifb-conditional-element').val(),
					operator: $(this).find('.ifb-conditional-operator').val(),
					value: $(this).find('.ifb-conditional-value').val()
				};
				
				form.conditional_recipients.push(conditionalRecipient);
			});
			
			form.email_sending_method = $('#email_sending_method').val();
			form.smtp_host = $('#smtp_host').val();
			form.smtp_port = $('#smtp_port').val();
			form.smtp_encryption = $('#smtp_encryption').val();
			form.smtp_username = $('#smtp_username').val();
			form.smtp_password = $('#smtp_password').val();
			form.label_placement = $('#label_placement').val();
			form.label_width = $('#label_width').val();
			form.success_type = $('#success_type').val();
			form.success_message = $('#success_message').val();
			form.success_message_position = $('#success_message_position').val();
			form.success_message_timeout = $('#success_message_timeout').val();
			form.success_redirect_type = $('#success_redirect_type').val();
			if (form.success_redirect_type.length == 0) {
				form.success_redirect_value = '';
			} else if (form.success_redirect_type == 'page') {
				form.success_redirect_value = $('#success_redirect_page').val();
			} else if (form.success_redirect_type == 'post') {
				form.success_redirect_value = $('#success_redirect_post').val();
			} else if (form.success_redirect_type == 'url') {
				form.success_redirect_value = $('#success_redirect_url').val();
			}
			form.submit_button_text = $('#submit_button_text').val();
			form.use_ajax = $('#use_ajax').is(':checked');
			form.show_referral_link = $('#show_referral_link').is(':checked');
			form.referral_text = $('#referral_text').val();
			form.referral_username = $('#referral_username').val();
			form.use_honeypot = $('#use_honeypot').is(':checked');
			form.conditional_logic_animation = $('#conditional_logic_animation').is(':checked');
			form.center_fancybox = $('#center_fancybox').is(':checked');
			form.required_text = $('#required_text').val();
			form.theme = $('#theme').val();
			form.use_uniformjs = $('#use_uniformjs').is(':checked');
			form.uniformjs_theme = $('#uniformjs_theme').val();
			form.jqueryui_theme = $('#jqueryui_theme').val();
			form.jqueryui_l10n = $('#jqueryui_l10n').val();
			form.use_tooltips = $('#use_tooltips').is(':checked');
			form.tooltip_type = $('#tooltip_type').val();
			form.tooltip_event = $('#tooltip_event').val();
			form.tooltip_style = $('#tooltip_style').val();
			form.tooltip_custom = $('#tooltip_custom').val();
			form.tooltip_my = $('#tooltip_my').val();
			form.tooltip_at = $('#tooltip_at').val();
			form.tooltip_rounded = $('#tooltip_rounded').is(':checked');
			form.tooltip_shadow = $('#tooltip_shadow').is(':checked');
			form.element_background_colour = $('#element_background_colour').val();
			form.element_border_colour = $('#element_border_colour').val();
			form.element_text_colour = $('#element_text_colour').val();
			form.label_text_colour = $('#label_text_colour').val();
			iPhorm.updateGlobalStyles();
			form.save_to_database = $('#save_to_database').is(':checked');
			form.entries_table_layout.active = [];
			$('#ifb-active-columns > li > div').each(function () {
				var entry = {
					type: $(this).data('type'),
					label: $(this).text(),
					id: $(this).data('id')
				};
				form.entries_table_layout.active.push(entry);
			});
			form.entries_table_layout.inactive = [];
			$('#ifb-inactive-columns > li > div').each(function () {
				var entry = {
					type: $(this).data('type'),
					label: $(this).text(),
					id: $(this).data('id')
				};
				form.entries_table_layout.inactive.push(entry);
			});
			form.use_wp_db = $('#use_wp_db').is(':checked');
			form.db_host = $('#db_host').val();
			form.db_username = $('#db_username').val();
			form.db_password = $('#db_password').val();
			form.db_name = $('#db_name').val();
			form.db_table = $('#db_table').val();
            form.send_to_podio = $('#send_to_podio').is(':checked');
            form.podio_app_id = $('#podio_app_id').val();
            form.podio_app_token = $('#podio_app_token').val();
            form.alert_with_twilio = $('#alert_with_twilio').is(':checked');
            form.twilio_alert_number = $('#twilio_alert_number').val();
            form.twilio_alert_msg = $('#twilio_alert_msg').val();
			iPhorm.updateDbFields();
			
			// Per element settings
			for (var i = 0; i < form.elements.length; i++) {
				var element = form.elements[i];
				
				switch (element.type) {
					case 'text':
						// Settings
						element.label = $('#label_'+element.id).val();
						element.description = $('#description_'+element.id).val();
						element.required = $('#required_'+element.id).is(':checked');
						
						// More settings
						element.default_value = $('#default_value_'+element.id).val();
						element.dynamic_default_value = $('#dynamic_default_value_'+element.id).is(':checked');
						element.dynamic_key = $('#dynamic_key_'+element.id).val();
						element.clear_default_value = $('#clear_default_value_'+element.id).is(':checked');
						element.reset_default_value = $('#reset_default_value_'+element.id).is(':checked');
						element.tooltip = $('#tooltip_'+element.id).val();
						element.admin_label = $('#admin_label_'+element.id).val();
                        element.podio_id = $('#podio_id_'+element.id).val();
                        element.podio_data_type = $('#podio_data_type_'+element.id).val();
                        element.input_mask = $('#input_mask_'+element.id).val();
						element.required_message = $('#required_message_'+element.id).val();
						element.is_hidden = $('#is_hidden_'+element.id).is(':checked');
						element.save_to_database = $('#save_to_database_'+element.id).is(':checked');
						element.label_placement = $('#label_placement_'+element.id).val();
						element.label_width = $('#label_width_'+element.id).val();
						element.tooltip_type = $('#tooltip_type_'+element.id).val();
						element.tooltip_event = $('#tooltip_event_'+element.id).val();
						element.prevent_duplicates = $('#prevent_duplicates_'+element.id).is(':checked');
						element.duplicate_found_message = $('#duplicate_found_message_'+element.id).val();
						iPhorm.updateLogic(element);

						// Advanced
						iPhorm.updateFilters(element);
						iPhorm.updateValidators(element);
						iPhorm.updateStyles(element);
						break;
					case 'textarea':
						// Settings
						element.label = $('#label_'+element.id).val();
						element.description = $('#description_'+element.id).val();
						element.required = $('#required_'+element.id).is(':checked');
						
						// More settings
						element.default_value = $('#default_value_'+element.id).val();
						element.dynamic_default_value = $('#dynamic_default_value_'+element.id).is(':checked');
						element.dynamic_key = $('#dynamic_key_'+element.id).val();
						element.clear_default_value = $('#clear_default_value_'+element.id).is(':checked');
						element.reset_default_value = $('#reset_default_value_'+element.id).is(':checked');
						element.tooltip = $('#tooltip_'+element.id).val();
						element.admin_label = $('#admin_label_'+element.id).val();
                        element.podio_id = $('#podio_id_'+element.id).val();
                        element.podio_data_type = $('#podio_data_type_'+element.id).val();
                        element.input_mask = $('#input_mask_'+element.id).val();
						element.required_message = $('#required_message_'+element.id).val();
						element.is_hidden = $('#is_hidden_'+element.id).is(':checked');
						element.save_to_database = $('#save_to_database_'+element.id).is(':checked');
						element.label_placement = $('#label_placement_'+element.id).val();
						element.label_width = $('#label_width_'+element.id).val();
						element.tooltip_type = $('#tooltip_type_'+element.id).val();
						element.tooltip_event = $('#tooltip_event_'+element.id).val();
						element.prevent_duplicates = $('#prevent_duplicates_'+element.id).is(':checked');
						element.duplicate_found_message = $('#duplicate_found_message_'+element.id).val();
						iPhorm.updateLogic(element);
						
						// Advanced
						iPhorm.updateFilters(element);
						iPhorm.updateValidators(element);
						iPhorm.updateStyles(element);
						break;
					case 'email':
						// Settings
						element.label = $('#label_'+element.id).val();
						element.description = $('#description_'+element.id).val();
						element.required = $('#required_'+element.id).is(':checked');
						
						// More settings
						element.default_value = $('#default_value_'+element.id).val();
						element.dynamic_default_value = $('#dynamic_default_value_'+element.id).is(':checked');
						element.dynamic_key = $('#dynamic_key_'+element.id).val();
						element.clear_default_value = $('#clear_default_value_'+element.id).is(':checked');
						element.reset_default_value = $('#reset_default_value_'+element.id).is(':checked');
						element.tooltip = $('#tooltip_'+element.id).val();
						element.admin_label = $('#admin_label_'+element.id).val();
                        element.podio_id = $('#podio_id_'+element.id).val();
                        element.podio_data_type = $('#podio_data_type_'+element.id).val();
                        element.input_mask = $('#input_mask_'+element.id).val();
						element.required_message = $('#required_message_'+element.id).val();
						element.is_hidden = $('#is_hidden_'+element.id).is(':checked');
						element.save_to_database = $('#save_to_database_'+element.id).is(':checked');
						element.label_placement = $('#label_placement_'+element.id).val();
						element.label_width = $('#label_width_'+element.id).val();
						element.tooltip_type = $('#tooltip_type_'+element.id).val();
						element.tooltip_event = $('#tooltip_event_'+element.id).val();
						element.prevent_duplicates = $('#prevent_duplicates_'+element.id).is(':checked');
						element.duplicate_found_message = $('#duplicate_found_message_'+element.id).val();
						iPhorm.updateLogic(element);
						
						// Advanced
						iPhorm.updateFilters(element);
						iPhorm.updateValidators(element);
						iPhorm.updateStyles(element);
						break;
					case 'select':
						// Settings
						element.label = $('#label_'+element.id).val();
						element.description = $('#description_'+element.id).val();
						element.required = $('#required_'+element.id).is(':checked');
						iPhorm.updateOptions(element);
						
						// More settings
						element.tooltip = $('#tooltip_'+element.id).val();
						element.admin_label = $('#admin_label_'+element.id).val();
                        element.podio_id = $('#podio_id_'+element.id).val();
                        element.podio_data_type = $('#podio_data_type_'+element.id).val();
                        element.input_mask = $('#input_mask_'+element.id).val();
						element.required_message = $('#required_message_'+element.id).val();
						element.is_hidden = $('#is_hidden_'+element.id).is(':checked');
						element.save_to_database = $('#save_to_database_'+element.id).is(':checked');
						element.label_placement = $('#label_placement_'+element.id).val();
						element.label_width = $('#label_width_'+element.id).val();
						element.tooltip_type = $('#tooltip_type_'+element.id).val();
						element.tooltip_event = $('#tooltip_event_'+element.id).val();
						element.prevent_duplicates = $('#prevent_duplicates_'+element.id).is(':checked');
						element.duplicate_found_message = $('#duplicate_found_message_'+element.id).val();
						iPhorm.updateLogic(element);
						element.dynamic_default_value = $('#dynamic_default_value_'+element.id).is(':checked');
						element.dynamic_key = $('#dynamic_key_'+element.id).val();
						
						// Advanced
						iPhorm.updateStyles(element);
						break;
					case 'checkbox':
						// Settings
						element.label = $('#label_'+element.id).val();
						element.description = $('#description_'+element.id).val();
						element.required = $('#required_'+element.id).is(':checked');
						iPhorm.updateOptions(element);
						element.options_layout = $('#options_layout_' + element.id).val();
						element.tooltip = $('#tooltip_'+element.id).val();
						
						// More settings
						element.admin_label = $('#admin_label_'+element.id).val();
                        element.podio_id = $('#podio_id_'+element.id).val();
                        element.podio_data_type = $('#podio_data_type_'+element.id).val();
                        element.input_mask = $('#input_mask_'+element.id).val();
						element.required_message = $('#required_message_'+element.id).val();
						element.is_hidden = $('#is_hidden_'+element.id).is(':checked');
						element.save_to_database = $('#save_to_database_'+element.id).is(':checked');
						element.label_placement = $('#label_placement_'+element.id).val();
						element.label_width = $('#label_width_'+element.id).val();
						element.tooltip_type = $('#tooltip_type_'+element.id).val();
						element.tooltip_event = $('#tooltip_event_'+element.id).val();
						element.prevent_duplicates = $('#prevent_duplicates_'+element.id).is(':checked');
						element.duplicate_found_message = $('#duplicate_found_message_'+element.id).val();
						iPhorm.updateLogic(element);
						element.dynamic_default_value = $('#dynamic_default_value_'+element.id).is(':checked');
						element.dynamic_key = $('#dynamic_key_'+element.id).val();
						
						// Advanced
						iPhorm.updateStyles(element);
						break;
					case 'radio':
						// Settings
						element.label = $('#label_'+element.id).val();
						element.description = $('#description_'+element.id).val();
						element.required = $('#required_'+element.id).is(':checked');
						iPhorm.updateOptions(element);
						element.options_layout = $('#options_layout_' + element.id).val();
						element.tooltip = $('#tooltip_'+element.id).val();
						
						// More settings
						element.admin_label = $('#admin_label_'+element.id).val();
                        element.podio_id = $('#podio_id_'+element.id).val();
                        element.podio_data_type = $('#podio_data_type_'+element.id).val();
                        element.input_mask = $('#input_mask_'+element.id).val();
						element.required_message = $('#required_message_'+element.id).val();
						element.is_hidden = $('#is_hidden_'+element.id).is(':checked');
						element.save_to_database = $('#save_to_database_'+element.id).is(':checked');
						element.label_placement = $('#label_placement_'+element.id).val();
						element.label_width = $('#label_width_'+element.id).val();
						element.tooltip_type = $('#tooltip_type_'+element.id).val();
						element.tooltip_event = $('#tooltip_event_'+element.id).val();
						element.prevent_duplicates = $('#prevent_duplicates_'+element.id).is(':checked');
						element.duplicate_found_message = $('#duplicate_found_message_'+element.id).val();
						iPhorm.updateLogic(element);
						element.dynamic_default_value = $('#dynamic_default_value_'+element.id).is(':checked');
						element.dynamic_key = $('#dynamic_key_'+element.id).val();
						
						// Advanced
						iPhorm.updateStyles(element);
						break;
					case 'file':
						// Settings
						element.label = $('#label_'+element.id).val();
						element.description = $('#description_'+element.id).val();
						element.required = $('#required_'+element.id).is(':checked');
						element.enable_swf_upload = $('#enable_swf_upload_'+element.id).is(':checked');
						element.allow_multiple_uploads = $('#allow_multiple_uploads_'+element.id).is(':checked');
						element.upload_num_fields = $('#upload_num_fields_'+element.id).val();
						element.upload_user_add_more = $('#upload_user_add_more_'+element.id).is(':checked');
						element.upload_add_another_text = $('#upload_add_another_text_'+element.id).val();
						element.upload_allowed_extensions = $('#upload_allowed_extensions_'+element.id).val();
						element.upload_maximum_size = $('#upload_maximum_size_'+element.id).val();
						
						// More settings
						element.tooltip = $('#tooltip_'+element.id).val();
						element.admin_label = $('#admin_label_'+element.id).val();
                        element.podio_id = $('#podio_id_'+element.id).val();
                        element.podio_data_type = $('#podio_data_type_'+element.id).val();
                        element.input_mask = $('#input_mask_'+element.id).val();
						element.is_hidden = $('#is_hidden_'+element.id).is(':checked');
						element.save_to_database = $('#save_to_database_'+element.id).is(':checked');
						element.label_placement = $('#label_placement_'+element.id).val();
						element.label_width = $('#label_width_'+element.id).val();
						element.add_as_attachment = $('#add_as_attachment_'+element.id).is(':checked');
						element.save_to_server = $('#save_to_server_'+element.id).is(':checked');
						element.save_path = $('#save_path_'+element.id).val();
						element.browse_text = $('#browse_text_'+element.id).val();
						element.default_text = $('#default_text_'+element.id).val();
						element.tooltip_type = $('#tooltip_type_'+element.id).val();
						element.tooltip_event = $('#tooltip_event_'+element.id).val();
						element.messages = {
							not_uploaded_with_filename: $('#not_uploaded_with_filename_'+element.id).val(),
		                    not_uploaded: $('#not_uploaded_'+element.id).val(),
		                    too_big_with_filename: $('#too_big_with_filename_'+element.id).val(),
		                    too_big: $('#too_big_'+element.id).val(),
		                    not_allowed_type_with_filename: $('#not_allowed_type_with_filename_'+element.id).val(),
		                    not_allowed_type: $('#not_allowed_type_'+element.id).val(),
		                    field_required: $('#field_required_'+element.id).val(),
		                    one_required: $('#one_required_'+element.id).val(),
		                    only_partial_with_filename: $('#only_partial_with_filename_'+element.id).val(),
		                    only_partial: $('#only_partial_'+element.id).val(),
		                    no_file: $('#no_file_'+element.id).val(),
		                    missing_temp_folder: $('#missing_temp_folder_'+element.id).val(),
		                    failed_to_write: $('#failed_to_write_'+element.id).val(),
		                    stopped_by_extension: $('#stopped_by_extension_'+element.id).val(),
		                    unknown_error: $('#unknown_error_'+element.id).val()
						};
						iPhorm.updateLogic(element);
						
						// Advanced
						iPhorm.updateStyles(element);
						break;
					case 'captcha':
						// Settings
						element.label = $('#label_'+element.id).val();
						element.description = $('#description_'+element.id).val();
						iPhorm.updateCaptchaOptions(element);
						
						// More settings
						element.tooltip = $('#tooltip_'+element.id).val();
						element.required_message = $('#required_message_'+element.id).val();
						element.invalid_message = $('#invalid_message_'+element.id).val();
						
						element.label_placement = $('#label_placement_'+element.id).val();
						element.label_width = $('#label_width_'+element.id).val();
						element.tooltip_type = $('#tooltip_type_'+element.id).val();
						element.tooltip_event = $('#tooltip_event_'+element.id).val();
						iPhorm.updateLogic(element);
						
						// Advanced
						iPhorm.updateStyles(element);
						break;
					case 'recaptcha':
						// Settings
						element.label = $('#label_'+element.id).val();
						element.description = $('#description_'+element.id).val();
						element.recaptcha_theme = $('#recaptcha_theme_'+element.id).val();
						element.recaptcha_lang = $('#recaptcha_lang_'+element.id).val();
						element.tooltip = $('#tooltip_'+element.id).val();
						
						// More settings
						element.admin_label = $('#admin_label_'+element.id).val();
                        element.podio_id = $('#podio_id_'+element.id).val();
                        element.podio_data_type = $('#podio_data_type_'+element.id).val();
                        element.input_mask = $('#input_mask_'+element.id).val();
						element.required_message = $('#required_message_'+element.id).val();
						element.label_placement = $('#label_placement_'+element.id).val();
						element.label_width = $('#label_width_'+element.id).val();
						element.tooltip_type = $('#tooltip_type_'+element.id).val();
						element.tooltip_event = $('#tooltip_event_'+element.id).val();
						iPhorm.updateLogic(element);
						element.messages = {
							'invalid-site-private-key': $('#invalid-site-private-key_'+element.id).val(),
							'invalid-request-cookie': $('#invalid-request-cookie_'+element.id).val(),
							'incorrect-captcha-sol': $('#incorrect-captcha-sol_'+element.id).val(),
							'recaptcha-not-reachable': $('#recaptcha-not-reachable_'+element.id).val()								
						};
						
						// Advanced
						iPhorm.updateStyles(element);
						break;
					case 'html':
						// Settings
						element.content = $('#content_'+element.id).val();
						element.enable_wrapper = $('#enable_wrapper_' + element.id).is(':checked');
						iPhorm.updateLogic(element);
						break;						
					case 'date':
						// Settings
						element.label = $('#label_'+element.id).val();
						element.description = $('#description_'+element.id).val();
						element.required = $('#required_'+element.id).is(':checked');
						element.tooltip = $('#tooltip_'+element.id).val();
						
						// More settings
						element.default_value = {
							day: $('#default_value_' + element.id + '_day').val(),
							month: $('#default_value_' + element.id + '_month').val(),
							year: $('#default_value_' + element.id + '_year').val()
						};
						element.show_date_headings = $('#show_date_headings_'+element.id).is(':checked');
						element.day_heading = $('#day_heading_' + element.id).val();
						element.month_heading = $('#month_heading_' + element.id).val();
						element.year_heading = $('#year_heading_' + element.id).val();
						element.start_year = $('#start_year_' + element.id).val();
						element.end_year = $('#end_year_' + element.id).val();
                        element.admin_label = $('#admin_label_'+element.id).val();
                        element.podio_id = $('#podio_id_'+element.id).val();
                        element.podio_data_type = $('#podio_data_type_'+element.id).val();
                        element.input_mask = $('#input_mask_'+element.id).val();
						element.required_message = $('#required_message_'+element.id).val();
						element.months_as_numbers = $('#months_as_numbers_'+element.id).is(':checked');
						element.field_order = $('#field_order_'+element.id).val();
						element.date_validator_message_invalid = $('#date_validator_message_invalid_'+element.id).val();
						element.date_format = $('#date_format_'+element.id).val();
						element.is_hidden = $('#is_hidden_'+element.id).is(':checked');
						element.save_to_database = $('#save_to_database_'+element.id).is(':checked');
						element.show_datepicker = $('#show_datepicker_'+element.id).is(':checked');
						element.label_placement = $('#label_placement_'+element.id).val();
						element.label_width = $('#label_width_'+element.id).val();
						element.tooltip_type = $('#tooltip_type_'+element.id).val();
						element.tooltip_event = $('#tooltip_event_'+element.id).val();
						element.prevent_duplicates = $('#prevent_duplicates_'+element.id).is(':checked');
						element.duplicate_found_message = $('#duplicate_found_message_'+element.id).val();
						iPhorm.updateLogic(element);
						element.dynamic_default_value = $('#dynamic_default_value_'+element.id).is(':checked');
						element.dynamic_key = $('#dynamic_key_'+element.id).val();
						
						// Advanced
						iPhorm.updateStyles(element);
						break;
					case 'time':
						// Settings
						element.label = $('#label_'+element.id).val();
						element.description = $('#description_'+element.id).val();
						element.required = $('#required_'+element.id).is(':checked');
						element.tooltip = $('#tooltip_'+element.id).val();
						
						// More settings
						element.default_value = {
							hour: $('#default_value_'+element.id+'_hour').val(),
							minute: $('#default_value_'+element.id+'_minute').val(),
							ampm: $('#default_value_'+element.id+'_ampm').val()
						};
						element.time_12_24 = $('#time_12_24_'+element.id).val();
						element.minute_granularity = $('#minute_granularity_'+element.id).val();
						element.time_format = $('#time_format_'+element.id).val();
						element.am_string = $('#am_string_'+element.id).val();
						element.pm_string = $('#pm_string_'+element.id).val();
						element.admin_label = $('#admin_label_'+element.id).val();
                        element.podio_id = $('#podio_id_'+element.id).val();
                        element.podio_data_type = $('#podio_data_type_'+element.id).val();
                        element.input_mask = $('#input_mask_'+element.id).val();
						element.required_message = $('#required_message_'+element.id).val();
						element.is_hidden = $('#is_hidden_'+element.id).is(':checked');
						element.save_to_database = $('#save_to_database_'+element.id).is(':checked');
						element.label_placement = $('#label_placement_'+element.id).val();
						element.label_width = $('#label_width_'+element.id).val();
						element.tooltip_type = $('#tooltip_type_'+element.id).val();
						element.tooltip_event = $('#tooltip_event_'+element.id).val();
						element.prevent_duplicates = $('#prevent_duplicates_'+element.id).is(':checked');
						element.duplicate_found_message = $('#duplicate_found_message_'+element.id).val();
						iPhorm.updateLogic(element);
						element.dynamic_default_value = $('#dynamic_default_value_'+element.id).is(':checked');
						element.dynamic_key = $('#dynamic_key_'+element.id).val();
						
						// Advanced
						iPhorm.updateStyles(element);
						break;
					case 'hidden':
						// Settings
						element.default_value = $('#default_value_'+element.id).val();
						element.label = $('#label_'+element.id).val();
                        element.podio_id = $('#podio_id_'+element.id).val();
                        element.podio_data_type = $('#podio_data_type_'+element.id).val();
                        element.input_mask = $('#input_mask_'+element.id).val();
						element.is_hidden = $('#is_hidden_'+element.id).is(':checked');
						element.save_to_database = $('#save_to_database_'+element.id).is(':checked');
						element.dynamic_default_value = $('#dynamic_default_value_'+element.id).is(':checked');
						element.dynamic_key = $('#dynamic_key_'+element.id).val();
						break;
					case 'password':
						// Settings
						element.label = $('#label_'+element.id).val();
						element.description = $('#description_'+element.id).val();
						element.required = $('#required_'+element.id).is(':checked');
						
						// More settings
						element.tooltip = $('#tooltip_'+element.id).val();
						element.admin_label = $('#admin_label_'+element.id).val();
                        element.podio_id = $('#podio_id_'+element.id).val();
                        element.podio_data_type = $('#podio_data_type_'+element.id).val();
                        element.input_mask = $('#input_mask_'+element.id).val();
						element.required_message = $('#required_message_'+element.id).val();
						element.is_hidden = $('#is_hidden_'+element.id).is(':checked');
						element.save_to_database = $('#save_to_database_'+element.id).is(':checked');
						element.label_placement = $('#label_placement_'+element.id).val();
						element.label_width = $('#label_width_'+element.id).val();
						element.tooltip_type = $('#tooltip_type_'+element.id).val();
						element.tooltip_event = $('#tooltip_event_'+element.id).val();
						element.prevent_duplicates = $('#prevent_duplicates_'+element.id).is(':checked');
						element.duplicate_found_message = $('#duplicate_found_message_'+element.id).val();
						iPhorm.updateLogic(element);
						element.dynamic_default_value = $('#dynamic_default_value_'+element.id).is(':checked');
						element.dynamic_key = $('#dynamic_key_'+element.id).val();
						
						// Advanced
						iPhorm.updateFilters(element);
						iPhorm.updateValidators(element);		
						iPhorm.updateStyles(element);
						break;
					case 'groupstart':
						element.name = $('#name_'+element.id).val();
						element.title = $('#title_'+element.id).val();
						element.description = $('#description_'+element.id).val();
						element.number_of_columns = $('#number_of_columns_'+element.id).val();
						element.column_alignment = $('#column_alignment_'+element.id).val();
						element.label_placement = $('#label_placement_'+element.id).val();
						element.label_width = $('#label_width_'+element.id).val();
						element.group_style = $('#group_style_'+element.id).val();
						element.tooltip_type = $('#tooltip_type_'+element.id).val();
						element.tooltip_event = $('#tooltip_event_'+element.id).val();
						element.border_colour = $('#border_colour_'+element.id).val();
						element.background_colour = $('#background_colour_'+element.id).val();
						iPhorm.updateLogic(element);
						iPhorm.updateStyles(element);
						break;
				}
			}
		},
		
		getNextElementId: function () {
			var id = 0;
			
			if (iPhorm.form.elements.length > 0) {
				for (var i = 0; i < iPhorm.form.elements.length; i++) {
					id = Math.max(id, iPhorm.form.elements[i].id);
				}
			}
			
			return id + 1;
		},
				
		getPlaceholder: function (type) {
			var classes = ['placeholder'];
			
			if (type) {
				classes.push(type + '-placeholder');
			}
			
			return $('<div class="' + classes.join(' ') + '"></div>');
		},
		
		getElementById: function (id) {
			for (var i = 0; i < iPhorm.form.elements.length; i++) {
				if (iPhorm.form.elements[i].id == id) {
					return iPhorm.form.elements[i];
				}
			}
			return null;
		},
		
		showSettings: function (id) {
			var $elementWrap = $('#ifb-element-wrap-'+id);
			
			if ($elementWrap.size()) {
				$elementWrap.find('.ifb-element-settings-inner').show();
				$elementWrap.find('.ifb-element-settings').fadeIn(500);
				$elementWrap.find('.ifb-settings-link').hide();
				$elementWrap.find('.ifb-close-link').show();
				$elementWrap.addClass('ifb-settings-open');
			}
		},
		
		hideSettings: function (id) {
			var $elementWrap = $('#ifb-element-wrap-'+id);
			
			if ($elementWrap.size()) {
				$elementWrap.find('.ifb-element-settings-inner').eq($('#ifb-element-settings-tabs-'+id).data('tabs').getIndex()).slideUp(400, function () {
					$elementWrap.find('.ifb-element-settings').hide();
					$elementWrap.find('.ifb-close-link').hide();
					$elementWrap.find('.ifb-settings-link').show();
					$elementWrap.removeClass('ifb-settings-open');
				});				
			}
		},
		
		toggleCustomiseValues: function (checked, element) {
			if (checked) {
				$('#options_td_'+element.id).addClass('ifb-customise-values');				
				element.customise_values = true;
			} else {
				$('#options_td_'+element.id).removeClass('ifb-customise-values');
				element.customise_values = false;
			}
			
			iPhorm.updateOptions(element);
		},
		
		clearDefaultOptions: function (element) {
			$('#ifb_options_' + element.id).find('.ifb-default-option').attr('checked', false);
			iPhorm.updateOptions(element);
		},
		
		updateOptions: function (element) {
			element.options = [];
			element.default_value = [];
			
			var $previewElement = $('#ifb_element_'+element.id);
			
			switch (element.type) {
				case 'select':					
					$previewElement.find('option').remove();
					
					$('#ifb_options_' + element.id + ' > li').each(function (index) {
						var label = $('.ifb-option-label', $(this)).val();
						if (!element.customise_values) {
							$('.ifb-option-value', $(this)).val(label);
						}
						var value = $('.ifb-option-value', $(this)).val();
						element.options.push({ label: label, value: value });
						
						if ($('.ifb-default-option', $(this)).is(':checked')) {
							element.default_value.push(value);
						}
						
						$previewElement.append($('<option />', { value: value, text: label }));		
					});
					
					if (element.default_value.length) {
						$previewElement.val(element.default_value);
						$('.ifb-clear-default-options', '#options_td_' + element.id).css('visibility', 'visible');
					} else {
						$('.ifb-clear-default-options', '#options_td_' + element.id).css('visibility', 'hidden');
					}
					break;
				case 'checkbox':
					var $options = $('#ifb_options_' + element.id + ' > li'),
					count = $options.length,
					$optionsOverflow = $('#ifb_options_overflow_' + element.id);
					$previewElement.find('li').remove();

					$options.each(function (index) {
						var label = $('.ifb-option-label', $(this)).val();
						if (!element.customise_values) {
							$('.ifb-option-value', $(this)).val(label);
						}
						var value = $('.ifb-option-value', $(this)).val();
						element.options.push({ label: label, value: value });
						
						if ($('.ifb-default-option', $(this)).is(':checked')) {
							element.default_value.push(value);
						}
						
						if (index < 5) {
							var $input = $('<input type="checkbox" name="ifb_element_'+element.id+'" disabled="disabled" />').val(value),
							$label = $('<label/>').html(label);
							
							$previewElement.append($('<li/>').append($input).append($label));
						}
					});
					
					if (count > 5) {
						$optionsOverflow.fadeIn('slow');
					} else {
						$optionsOverflow.hide();
					}
					
					$('input[name=ifb_element_'+element.id+']', $previewElement).val(element.default_value);
					break;
				case 'radio':
					var $options = $('#ifb_options_' + element.id + ' > li'),
					count = $options.length,
					$optionsOverflow = $('#ifb_options_overflow_' + element.id);
					$previewElement.find('li').remove();

					$options.each(function (index) {
						var label = $('.ifb-option-label', $(this)).val();
						if (!element.customise_values) {
							$('.ifb-option-value', $(this)).val(label);
						}
						var value = $('.ifb-option-value', $(this)).val();
						element.options.push({ label: label, value: value });
						
						if ($('.ifb-default-option', $(this)).is(':checked')) {
							element.default_value.push(value);
						}
						
						if (index < 5) {
							var $input = $('<input type="radio" name="ifb_element_'+element.id+'" disabled="disabled" />').val(value),
							$label = $('<label/>').html(label);
							
							$previewElement.append($('<li/>').append($input).append($label));
						}
						
						if (element.default_value.length) {
							$('.ifb-clear-default-options', '#options_td_' + element.id).css('visibility', 'visible');
						} else {
							$('.ifb-clear-default-options', '#options_td_' + element.id).css('visibility', 'hidden');
						}
					});
					
					if (count > 5) {
						$optionsOverflow.fadeIn('slow');
					} else {
						$optionsOverflow.hide();
					}
					
					$('input[name=ifb_element_'+element.id+']', $previewElement).val(element.default_value);
					break;
			}
			
			// Check if there are any active conditional rules for this element and update the values
			$('#ifb-conditional-recipient-list > li').each(function () {
				if ($(this).find('.ifb-conditional-element').val() == element.id) {
					var $values = $(this).find('.ifb-conditional-value');
					var value = $values.val();
					$values.empty();
					for (var i = 0; i < element.options.length; i++) {
						var option = element.options[i];
						$values.append($('<option/>', { value: option.value, text: option.label }));
					}
					$values.val(value);
				}
			});
		},
		
		addOption: function (button, element) {
			$(button).parent().after(iPhorm.getOptionHtml(element, ''));		
			iPhorm.updateOptions(element);
			iPhorm.updateLogicOptions(element);
		},
		
		getOptionHtml: function (element, label, value) {
			if (value === null || value === undefined) {
				value = label;
			}
				
			var defaultType = (element.type == 'checkbox') ? 'checkbox' : 'radio';
			return $('<li class="ifb-option-wrap" />')
				    .append('<input class="ifb-default-option" name="default_option_' + element.id + '" type="' + defaultType + '" onclick="iPhorm.updateOptions(iPhorm.getElementById('+element.id+'));" />')
				    .append($('<input class="ifb-option-label" type="text" onkeyup="iPhorm.updateOptions(iPhorm.getElementById('+element.id+'));" onblur="iPhorm.updateLogicOptions(iPhorm.getElementById('+element.id+'));" />').val(label))
					.append($('<input class="ifb-option-value" type="text" onkeyup="iPhorm.updateOptions(iPhorm.getElementById('+element.id+'));" onblur="iPhorm.updateLogicOptions(iPhorm.getElementById('+element.id+'));" />').val(value))
					.append('<span class="ifb-add-option" onclick="iPhorm.addOption(this, iPhorm.getElementById('+element.id+'));">+</span> <span class="ifb-remove-option" onclick="iPhorm.removeOption(this, iPhorm.getElementById('+element.id+'));">x</span>');
		},
		
		removeOption: function (button, element) {
			if ($('li', $(button).parent().parent()).size() > 1) {
				$(button).parent().remove();
			} else {
				iPhorm.addMessage(iphormL10n.at_least_one_option, 'error', 3);
			}
			
			iPhorm.updateOptions(element);
			iPhorm.updateLogicOptions(element);
		},
		
		/**
		 * Updates the element's preview label
		 * 
		 * @param object element
		 */
		updatePreviewLabel: function (element) {
			var $previewLabel = $('.ifb-preview-label', '#ifb-element-wrap-'+element.id),
			val = $('#label_' + element.id).val();
			
			$('.ifb-preview-label-content', '#ifb-element-wrap-'+element.id).html(val);
			
			if (val.length > 0) {
				$previewLabel.find('.ifb-required').show();
			} else {
				$previewLabel.find('.ifb-required').hide();
			}
			
			element.label = val;
		},
		
		/**
		 * Updates the element's label including in other places
		 * that don't require immediate feedback
		 * 
		 * @param object element
		 */
		updateElementLabel: function (element) {
			iPhorm.updatePreviewLabel(element);
			iPhorm.updateConditionalRecipientLabels(element);
			iPhorm.updateEntryLayoutColumnLabel(element);
			iPhorm.updateLogicRuleLabels(element);
		},
		
		updateAdminLabel: function (input, element) {
			var label = $(input).val();
			element.admin_label = label;
			
			iPhorm.updateConditionalRecipientLabels(element);
			iPhorm.updateEntryLayoutColumnLabel(element);
			iPhorm.updateLogicRuleLabels(element);
		},

        updatePodioId: function (input, element) {
            // do nothing
        },

        updatePodioDataType: function (input, element) {
            // do nothing
        },

        updateInputMask: function (input, element) {
            // do nothing
        },

		updateConditionalRecipientLabels: function (element) {
			if (element.type == 'radio' || element.type == 'select') {
				// Check for any conditional recipients using this element and update the label
				$('#ifb-conditional-recipient-list .ifb-conditional-element > option[value="'+element.id+'"]').each(function () {
					$(this)[0].text = iPhorm.getShortenedAdminLabel(element);
				});
			}
		},
		
		updateHiddenPreviewLabel: function (input, element) {
			var $previewLabel = $('.ifb-preview-label', '#ifb-element-wrap-'+element.id);
			var $hidden = $previewLabel.find('span.ifb-hidden-preview');
			$previewLabel.text($(input).val()).append($hidden);
		},
		
		updatePreviewDescription: function (element) {			
			var $previewDescription = $('.ifb-preview-description', '#ifb-element-wrap-'+element.id);
			
			var val = $('#description_' + element.id).val();
			$previewDescription.html(val);
			
			if (val.length > 0) {
				$previewDescription.show();
			} else {
				$previewDescription.hide();
			}
		},
		
		updateDefaultValue: function (input, element) {
			$('#ifb_element_'+element.id).val($(input).val());
		},
	    
	    updateGroupTitle: function (element) {
			var $titlePreview = $('#ifb-element-wrap-' + element.id + ' .ifb-preview-title'),
	    	val = $('#title_' + element.id).val();
	    	$titlePreview.html(val);
	    	
	    	if (val.length > 0) {
	    		$titlePreview.show();
	    	} else {
	    		$titlePreview.hide();
	    	}
	    },
		
		toggleElementRequired: function (element, checked) {
			if (checked) {
				$('#ifb-element-wrap-'+element.id).removeClass('ifb-element-optional');
				element.required = true;
			} else {
				$('#ifb-element-wrap-'+element.id).addClass('ifb-element-optional');
				element.required = false;
			}
		},
		
		updateRequiredText: function (input) {
			var requiredText = $(input).val();
			$('.ifb-preview-label span.ifb-required').text(requiredText);
			
			if (requiredText.length > 0) {
				$form.removeClass('ifb-no-required-text');
			} else {
				$form.addClass('ifb-no-required-text');
			}
		},
		
		setRecaptchaTheme: function (element, list) {
			var val = $(list).val();
			var $context = $('#ifb_element_'+element.id);
			$('.ifb-recaptcha-sample', $context).hide();
			
			switch (val) {
				case 'red':
				default:
					$('.ifb-recaptcha-sample-red', $context).show();
					break;
				case 'white':
					$('.ifb-recaptcha-sample-white', $context).show();
					break;
				case 'blackglass':
					$('.ifb-recaptcha-sample-black', $context).show();
					break;
				case 'clean':
					$('.ifb-recaptcha-sample-clean', $context).show();
					break;
			}
		},
		
		setLabelPlacement: function () {
			var val = $('#label_placement').val();
			iPhorm.form.label_placement = val;
			$('.ifb-element-wrap').removeClass('ifb-label-placement-left ifb-label-placement-above ifb-label-placement-inside');
			$('.ifb-element-wrap').addClass('ifb-label-placement-'+val);
			
			if (val == 'left') {
				$('.ifb-show-if-label-placement-left').show();
			} else {
				$('.ifb-show-if-label-placement-left').hide();
			}
		},
		
		setSaveToServer: function (element, checked) {
			if (checked) {
				$('.show-if-save-to-server', '#ifb-element-wrap-' + element.id).show();
			} else {
				$('.show-if-save-to-server', '#ifb-element-wrap-' + element.id).hide();
			}
		},
		
		addFilter: function (element, type) {
			var filter = {
				id: iPhorm.getNextFilterId(element),
				element_id: element.id,
				type: type
			};
			
			$.ajax({
				type: 'POST',
				async: false,
				url: ajaxurl,
				data: {
			       action: 'iphorm_get_filter',
			       filter: JSON.stringify(filter)
				},
				dataType: 'json',
				success: function (response) {
					if (response === null) {
						iPhorm.formatAddMessage(iphormL10n.error_adding_filter, 'error', 10);
					} else if (typeof response === 'object') {
						if (response.type == 'success') {
							$(response.data.html).hide().appendTo($('#ifb-filters-'+element.id)).fadeIn('slow');
							
							filter = response.data.filter;
							
							element.filters.push(filter);
	
							if (element.filters.length > 0) {
								$('#ifb-filters-empty-'+element.id).hide();
							}
						} else if (response.type == 'error') {
							if (response.message) {
								iPhorm.addResponseMessage(response.message);
							}
						}
					}
				},
				error: function () {
					iPhorm.formatAddMessage(iphormL10n.error_adding_filter, 'error', 10, 'Ajax request failed');
				}
			});
		},
				
		getNextFilterId: function (element) {
			var id = 0;
			
			if (element.filters.length > 0) {
				for (var i = 0; i < element.filters.length; i++) {
					id = Math.max(id, element.filters[i].id);
				}
			}
			
			return id + 1;
		},
		
		showFilterSettings: function (elementId, filterId) {
			var $filterWrap = $('#ifb-filter-wrap-'+elementId+'-'+filterId);
			
			if ($filterWrap.size()) {
				$filterWrap.find('.ifb-filter-settings').slideDown();
				$filterWrap.find('.ifb-filter-settings-link').hide();
				$filterWrap.find('.ifb-filter-close-link').show();
				$filterWrap.addClass('ifb-filter-settings-open');
			}
		},
		
		hideFilterSettings: function (elementId, filterId) {
			var $filterWrap = $('#ifb-filter-wrap-'+elementId+'-'+filterId);
			
			if ($filterWrap.size()) {
				$filterWrap.find('.ifb-filter-settings').slideUp();
				$filterWrap.find('.ifb-filter-close-link').hide();
				$filterWrap.find('.ifb-filter-settings-link').show();
				$filterWrap.removeClass('ifb-filter-settings-open');
			}
		},
		
		updateFilters: function (element) {
			for (var i = 0; i < element.filters.length; i++) {
				var filter = element.filters[i];
				
				switch (filter.type) {
					case 'alpha':
					case 'alphaNumeric':
					case 'digits':
						filter.allow_white_space = $('#f_allow_white_space_'+filter.element_id+'_'+filter.id).is(':checked');
						break;
					case 'stripTags':
						filter.allowable_tags = $('#f_allowable_tags_'+filter.element_id+'_'+filter.id).val();
						break;
					case 'regex':
						filter.pattern = $('#f_pattern_'+filter.element_id+'_'+filter.id).val();
						break;
				}
			}
		},
		
		deleteFilter: function (element, filterId) {			
			for (var i = 0; i < element.filters.length; i++) {
				if (element.filters[i].id == filterId) {
					element.filters.splice(i, 1);
				}
			}
			
			$('#ifb-filter-wrap-' + element.id + '-' + filterId).hide(0, function() {
				$(this).remove();
				
				if (element.filters.length == 0) {
					$('#ifb-filters-empty-' + element.id).fadeIn();
				}
			});			
		},
		
		addValidator: function (element, type) {
			var validator = {
				id: iPhorm.getNextValidatorId(element),
				element_id: element.id,
				type: type
			};
			
			$.ajax({
				type: 'POST',
				async: false,
				url: ajaxurl,
				data: {
			       action: 'iphorm_get_validator',
			       validator: JSON.stringify(validator)
				},
				dataType: 'json',
				success: function (response) {
					if (response === null) {
						iPhorm.formatAddMessage(iphormL10n.error_adding_validator, 'error', 10);
					} else if (typeof response === 'object') {
						if (response.type == 'success') {			
							$(response.data.html).hide().appendTo($('#ifb-validators-'+element.id)).fadeIn('slow');
							
							validator = response.data.validator;
							
							element.validators.push(validator);
	
							if (element.validators.length > 0) {
								$('#ifb-validators-empty-'+element.id).hide();
							}
						} else if (response.type == 'error') {
							if (response.message) {
								iPhorm.addResponseMessage(response.message);
							}
						}
					}
				},
				error: function () {
					iPhorm.formatAddMessage(iphormL10n.error_adding_validator, 'error', 10, 'Ajax request failed.');
				}
			});
		},
				
		getNextValidatorId: function (element) {
			var id = 0;
			
			if (element.validators.length > 0) {
				for (var i = 0; i < element.validators.length; i++) {
					id = Math.max(id, element.validators[i].id);
				}
			}
			
			return id + 1;
		},
		
		showValidatorSettings: function (elementId, validatorId) {
			var $validatorWrap = $('#ifb-validator-wrap-'+elementId+'-'+validatorId);
			
			if ($validatorWrap.size()) {
				$validatorWrap.find('.ifb-validator-settings').slideDown();
				$validatorWrap.find('.ifb-validator-settings-link').hide();
				$validatorWrap.find('.ifb-validator-close-link').show();
				$validatorWrap.addClass('ifb-validator-settings-open');
			}
		},
		
		hideValidatorSettings: function (elementId, validatorId) {
			var $validatorWrap = $('#ifb-validator-wrap-'+elementId+'-'+validatorId);
			
			if ($validatorWrap.size()) {
				$validatorWrap.find('.ifb-validator-settings').slideUp();
				$validatorWrap.find('.ifb-validator-close-link').hide();
				$validatorWrap.find('.ifb-validator-settings-link').show();
				$validatorWrap.removeClass('ifb-validator-settings-open');
			}
		},
		
		updateValidators: function (element) {
			for (var i = 0; i < element.validators.length; i++) {
				var validator = element.validators[i];
				switch (validator.type) {
					case 'alpha':
					case 'alphaNumeric':
					case 'digits':
						validator.allow_white_space = $('#v_allow_white_space_'+validator.element_id+'_'+validator.id).is(':checked');
						validator.messages.invalid = $('#v_invalid_'+validator.element_id+'_'+validator.id).val();
						break;
					case 'email':
						validator.messages.invalid = $('#v_invalid_'+validator.element_id+'_'+validator.id).val();
						break;
					case 'greaterThan':
						validator.min = $('#v_min_'+validator.element_id+'_'+validator.id).val();
						validator.messages.not_greater_than = $('#v_not_greater_than_'+validator.element_id+'_'+validator.id).val();
						break;
					case 'identical':
						validator.token = $('#v_token_'+validator.element_id+'_'+validator.id).val();
						validator.messages.not_match = $('#v_not_match_'+validator.element_id+'_'+validator.id).val();
						break;
					case 'lessThan':
						validator.max = $('#v_max_'+validator.element_id+'_'+validator.id).val();
						validator.messages.not_less_than = $('#v_not_less_than_'+validator.element_id+'_'+validator.id).val();
						break;
					case 'length':
						validator.min = $('#v_min_'+validator.element_id+'_'+validator.id).val();
						validator.max = $('#v_max_'+validator.element_id+'_'+validator.id).val();
						validator.messages.too_short = $('#v_too_short_'+validator.element_id+'_'+validator.id).val();
						validator.messages.too_long = $('#v_too_long_'+validator.element_id+'_'+validator.id).val();
						break;
					case 'regex':
						validator.pattern = $('#v_pattern_'+validator.element_id+'_'+validator.id).val();
						validator.messages.invalid = $('#v_invalid_'+validator.element_id+'_'+validator.id).val();
						break;
				}
			}
		},
		
		deleteValidator: function (element, validatorId) {			
			for (var i = 0; i < element.validators.length; i++) {
				if (element.validators[i].id == validatorId) {
					element.validators.splice(i, 1);
				}
			}
			
			$('#ifb-validator-wrap-' + element.id + '-' + validatorId).hide(0, function() {
				$(this).remove();
				
				if (element.validators.length == 0) {
					$('#ifb-validators-empty-' + element.id).fadeIn();
				}
			});			
		},
		
		addStyle: function (element, type) {
			var style = {
				id: iPhorm.getNextStyleId(element),
				element_id: element.id,
				type: type
			};
			
			$.ajax({
				type: 'POST',
				async: false,
				url: ajaxurl,
				data: {
			       action: 'iphorm_get_style',
			       style: JSON.stringify(style)
				},
				dataType: 'json',
				success: function (response) {
					if (response === null) {
						iPhorm.formatAddMessage(iphormL10n.error_adding_style, 'error', 10);
					} else if (typeof response === 'object') {
						if (response.type == 'success') {						
							$(response.data.html).hide().appendTo($('#ifb-styles-'+element.id)).fadeIn('slow');
							
							style = response.data.style;
							
							element.styles.push(style);
	
							if (element.styles.length > 0) {
								$('#ifb-styles-empty-'+element.id).hide();
							}
						} else if (response.type == 'error') {
							if (response.message) {
								iPhorm.addResponseMessage(response.message);
							}
						}
					}
				},
				error: function () {
					iPhorm.formatAddMessage(iphormL10n.error_adding_style, 'error', 10, 'Ajax request failed.');
				}
			});
		},
		
		getNextStyleId: function (element) {
			var id = 0;
			
			if (element.styles.length > 0) {
				for (var i = 0; i < element.styles.length; i++) {
					id = Math.max(id, element.styles[i].id);
				}
			}
			
			return id + 1;
		},
		
		showStyleSettings: function (elementId, styleId) {
			var $styleWrap = $('#ifb-style-wrap-'+elementId+'-'+styleId);
			
			if ($styleWrap.size()) {
				$styleWrap.find('.ifb-style-settings').slideDown();
				$styleWrap.find('.ifb-style-settings-link').hide();
				$styleWrap.find('.ifb-style-close-link').show();
				$styleWrap.addClass('ifb-style-settings-open');
			}
		},
		
		hideStyleSettings: function (elementId, styleId) {
			var $styleWrap = $('#ifb-style-wrap-'+elementId+'-'+styleId);
			
			if ($styleWrap.size()) {
				$styleWrap.find('.ifb-style-settings').slideUp();
				$styleWrap.find('.ifb-style-close-link').hide();
				$styleWrap.find('.ifb-style-settings-link').show();
				$styleWrap.removeClass('ifb-style-settings-open');
			}
		},
		
		updateStyles: function (element) {
			for (var i = 0; i < element.styles.length; i++) {
				var style = element.styles[i];				
				style.css = $('#s_css_' + style.element_id + '_' + style.id).val();
			}
		},
		
		deleteStyle: function (element, styleId) {			
			for (var i = 0; i < element.styles.length; i++) {
				if (element.styles[i].id == styleId) {
					element.styles.splice(i, 1);
				}
			}
			
			$('#ifb-style-wrap-' + element.id + '-' + styleId).hide(0, function() {
				$(this).remove();
				
				if (element.styles.length == 0) {
					$('#ifb-styles-empty-' + element.id).fadeIn();
				}
			});			
		},
		
		addGlobalStyle: function (type) {
			if (type == 'date') {
				iPhorm.addGlobalStyle('dateDay');
				iPhorm.addGlobalStyle('dateMonth');
				iPhorm.addGlobalStyle('dateYear');
				return;
			} else if (type == 'time') {
				iPhorm.addGlobalStyle('timeHour');
				iPhorm.addGlobalStyle('timeMinute');
				iPhorm.addGlobalStyle('timeAmPm');
				return;
			}
			
			var style = {
				id: iPhorm.getNextGlobalStyleId(),
				type: type
			};
			
			$.ajax({
				type: 'POST',
				async: false,
				url: ajaxurl,
				data: {
			       action: 'iphorm_get_global_style',
			       style: JSON.stringify(style)
				},
				dataType: 'json',
				success: function (response) {
					if (response === null) {
						iPhorm.formatAddMessage(iphormL10n.error_adding_style, 'error', 10);
					} else if (typeof response === 'object') {
						if (response.type == 'success') {						
							$(response.data.html).hide().appendTo($('#ifb-global-styles')).fadeIn('slow');
							
							style = response.data.style;
							
							iPhorm.form.styles.push(style);
	
							if (iPhorm.form.styles.length > 0) {
								$('.ifb-global-styles-empty').hide();
							}
						} else if (response.type == 'error') {
							if (response.message) {
								iPhorm.addResponseMessage(response.message);
							}
						}
					}
				},
				error: function () {
					iPhorm.formatAddMessage(iphormL10n.error_adding_style, 'error', 10, 'Ajax request failed.');
				}
			});
		},
		
		getNextGlobalStyleId: function () {
			var id = 0;
			
			if (iPhorm.form.styles.length > 0) {
				for (var i = 0; i < iPhorm.form.styles.length; i++) {
					id = Math.max(id, iPhorm.form.styles[i].id);
				}
			}
			
			return id + 1;
		},
		
		showGlobalStyleSettings: function (styleId) {
			var $styleWrap = $('#ifb-global-style-wrap-' + styleId);
			
			if ($styleWrap.size()) {
				$styleWrap.find('.ifb-style-settings').slideDown();
				$styleWrap.find('.ifb-style-settings-link').hide();
				$styleWrap.find('.ifb-style-close-link').show();
				$styleWrap.addClass('ifb-style-settings-open');
			}
		},
		
		hideGlobalStyleSettings: function (styleId) {
			var $styleWrap = $('#ifb-global-style-wrap-' + styleId);
			
			if ($styleWrap.size()) {
				$styleWrap.find('.ifb-style-settings').slideUp();
				$styleWrap.find('.ifb-style-close-link').hide();
				$styleWrap.find('.ifb-style-settings-link').show();
				$styleWrap.removeClass('ifb-style-settings-open');
			}
		},
		
		updateGlobalStyles: function () {
			for (var i = 0; i < iPhorm.form.styles.length; i++) {
				var style = iPhorm.form.styles[i];				
				style.css = $('#s_css_' + style.id).val();
			}
		},
		
		deleteGlobalStyle: function (styleId) {			
			for (var i = 0; i < iPhorm.form.styles.length; i++) {
				if (iPhorm.form.styles[i].id == styleId) {
					iPhorm.form.styles.splice(i, 1);
				}
			}
			
			$('#ifb-global-style-wrap-' + styleId).hide(0, function() {
				$(this).remove();
				
				if (iPhorm.form.styles.length == 0) {
					$('.ifb-global-styles-empty').fadeIn();
				}
			});			
		},
		
		updateCaptchaOptions: function (element) {
			element.options.length = $('#length_' + element.id).val();
			element.options.width = $('#width_' + element.id).val();
			element.options.height = $('#height_' + element.id).val();
			element.options.bgColour = $('#bg_colour_' + element.id).val();
			element.options.textColour = $('#text_colour_' + element.id).val();
			element.options.font = $('#font_' + element.id).val();
			element.options.minFontSize = $('#min_font_size_' + element.id).val();
			element.options.maxFontSize = $('#max_font_size_' + element.id).val();
			element.options.minAngle = $('#min_angle_' + element.id).val();
			element.options.maxAngle = $('#max_angle_' + element.id).val();
		},
		
		refreshCaptchaPreview: function (element) {
			this.updateCaptchaOptions(element);
			var config = btoa(JSON.stringify({uniqId: 1, tmpDir: iphormL10n.tmp_dir, preview: 1, options: element.options}));
			var time = new Date().getTime();
			
			$('#ifb_captcha_'+element.id).attr('src', iphormL10n.captcha_url + '?c=' + config + '&t=' + time);
		},
		
		toggleTooltipSettings: function (checked) {
			if (checked) {
				$('.show-if-tooltips-enabled').show();
			} else {
				$('.show-if-tooltips-enabled').hide();
			}
		},
		
		addRecipientField: function (element) {
			$(element).parent().after('<li><input name="ifb_recipient_email" type="text" /> <span class="ifb-small-add-button" onclick="iPhorm.addRecipientField(this); return false;">+</span> <span class="ifb-small-delete-button" onclick="iPhorm.removeRecipientField(this); return false;">x</span></li>');
		},
		
		removeRecipientField: function (element) {
			var $recipientList = $(element).parent().parent();
			if ($recipientList.children().size() > 1) { 
				$(element).parent().remove();
			}
		},
		
		toggleAllowMultipleUploads: function (element) {
			if ($('#allow_multiple_uploads_' + element.id).is(':checked')) {
				$('.show-if-allow-multiple-uploads', '#ifb-element-wrap-' + element.id).show();
				if ($('#upload_user_add_more_' + element.id).is(':checked')) {
					$('.show-if-upload-user-add-more', '#ifb-element-wrap-' + element.id).show();
				}
			} else {
				$('.show-if-allow-multiple-uploads', '#ifb-element-wrap-' + element.id).hide();
				$('.show-if-upload-user-add-more', '#ifb-element-wrap-' + element.id).hide();
			}
		},
		
		setMailTransport: function (select) {
			if ($(select).val() == 'smtp') {
				$('.ifb-show-if-smtp-on').show();
			} else {
				$('.ifb-show-if-smtp-on').hide();
			}
		},
		
		setSendNotification: function (checked) {
			if (checked) {
				this.form.send_notification = true;
				$('.ifb-show-if-send-notification-on').show();
			} else {
				this.form.send_notification = false;
				$('.ifb-show-if-send-notification-on').hide();
			}
		},
		
		setSendAutoreply: function (checked) {
			if (checked) {
				this.form.send_autoreply = true;
				$('.ifb-show-if-send-autoreply-on').show();
			} else {
				this.form.send_autoreply = false;
				$('.ifb-show-if-send-autoreply-on').hide();
			}
		},
		
		insertAtCursor: function(field, value) { 
	        //IE support 
	        if (document.selection)
	        { 
	            field.focus();
	            sel = document.selection.createRange(); 
	            sel.text = value;
	        }

	        //Mozilla/Firefox/Netscape 7+ support 
	        else if (field.selectionStart || field.selectionStart == '0')
	        {  
	            var startPos = field.selectionStart;
	            var endPos = field.selectionEnd; 
	            field.value = field.value.substring(0, startPos)+ value + field.value.substring(endPos, field.value.length);
	        }

	        else
	        { 
	            field.value += value; 
	        } 
	    },
		
	    insertVariable: function(selector, select) {
	    	var val = $(select).val();
	    	if (val.length) {
	    		this.insertAtCursor($(selector)[0], val);
	    		$(selector).focus();
	    		$(select).val('');
	    	}
	    },
	    
	    updateSettingsDependencies: function () {
	    	var $selects = $('.ifb-insert-variable').empty().append($('<option/>', { value: '', text: iphormL10n.insert_variable })),
	    	
	    	$autoreplyRecipient = $('#autoreply_recipient_element'),
	    	$notificationReplyTo = $('#notification_reply_to_element'),
	    	$notificationFrom = $('#notification_from_element'),
	    	$autoreplyFrom = $('#autoreply_from_element'),
	    	
	    	selectedAutoreplyRecipient = $autoreplyRecipient.val(),
	    	selectedNotificationReplyToElement = $notificationReplyTo.val(),
	    	selectedNotificationFromElement = $notificationFrom.val(),
	    	selectedAutoreplyFromElement = $autoreplyFrom.val(),
	    	
	    	$allEmailDependents = $autoreplyRecipient.add($notificationReplyTo).add($notificationFrom).add($autoreplyFrom);
	    	
	    	$allEmailDependents.empty();
	    	
	    	
	    	if (iPhorm.form.elements.length > 0) {
		    	var $elementOpts = $('<optgroup label="' + iphormL10n.submitted_form_value + '"/>');
		    	for (var i = 0; i < iPhorm.form.elements.length; i++) {
		    		var element = iPhorm.form.elements[i];
		    		
		    		if (element.type != 'html' && element.type != 'groupstart' && element.type != 'groupend') {
		    			$elementOpts.append($('<option/>', {value: '{' + iPhorm.getShortenedAdminLabel(element) + '|' + element.id + '}', text: iPhorm.getShortenedAdminLabel(element)}));
					}
		    		
		    		if (element.type == 'email') {
		    			$allEmailDependents.append($('<option/>', {value: element.id, text: iPhorm.getShortenedAdminLabel(element)}));
		    		}
		    	}
		    	
		    	if ($elementOpts.length > 0) {
		    		$selects.append($elementOpts);
		    	}
	    	}
	    	
	    	$selects.append($('<option/>', { value: '{ip}', text: iphormL10n.user_ip_address }))
			.append($('<option/>', { value: '{url}', text: iphormL10n.form_url }))
			.append($('<option/>', { value: '{referring_url}', text: iphormL10n.referring_url }))
			.append($('<option/>', { value: '{user_display_name}', text: iphormL10n.user_display_name }))
			.append($('<option/>', { value: '{user_email}', text: iphormL10n.user_email }))
			.append($('<option/>', { value: '{user_login}', text: iphormL10n.user_login }))
			.append($('<option/>', { value: '{post_id}', text: iphormL10n.form_post_page_id }))
			.append($('<option/>', { value: '{post_title}', text: iphormL10n.form_post_page_title }));
	    	
    		var $dateOpts = $('<optgroup label="' + iphormL10n.date_select_format + '"/>');
	    	for (var i in iphormL10n.date_formats) {
	    		$dateOpts.append($('<option/>', { value: '{submit_date|' + i + '}', text: iphormL10n.date_formats[i] }));
	    	}
	    	
	    	if ($dateOpts.length > 0) {
	    		$selects.append($dateOpts);
	    	}
	    	
    		var $timeOpts = $('<optgroup label="' + iphormL10n.time_select_format + '"/>');
	    	for (var i in iphormL10n.time_formats) {
	    		$timeOpts.append($('<option/>', { value: '{submit_time|' + i + '}', text: iphormL10n.time_formats[i] }));
	    	}
	    	
	    	if ($timeOpts.length > 0) {
	    		$selects.append($timeOpts);
	    	}
	    	
	    	if (!($autoreplyRecipient.children('option').size() > 0)) {
	    		$('.ifb-show-if-email-element').hide();
	    		$('.ifb-show-if-no-email-element').show();
	    	} else {
	    		$('.ifb-show-if-no-email-element').hide();
	    		$('.ifb-show-if-email-element').show();
	    		$autoreplyRecipient.val(selectedAutoreplyRecipient);
	    		$notificationReplyTo.val(selectedNotificationReplyToElement);
	    		$notificationFrom.val(selectedNotificationFromElement);
	    		$autoreplyFrom.val(selectedAutoreplyFromElement);
	    	}
	    	
	    	var multiElements = this.getMultiElements();
	    	if (multiElements.length > 0) {
	    		$('#ifb-add-conditional-recipient-button').show();
	    		$('#ifb-conditional-no-valid-elements').hide();
	    	} else {
	    		$('#ifb-add-conditional-recipient-button').hide();
	    		$('#ifb-conditional-no-valid-elements').show();
	    	}
	    },
	    
	    getNextConditionalRecipientId: function () {
	    	var id = 0;
			
			if (this.form.conditional_recipients.length > 0) {
				for (var i = 0; i < this.form.conditional_recipients.length; i++) {
					id = Math.max(id, this.form.conditional_recipients[i].id);
				}
			}
			
			return id + 1;
	    },
	    
	    addConditionalRecipient: function (existingConditionalRecipient) {
	    	$('#ifb-conditional-recipient-list-wrap').show();
	    	var multiElements = this.getMultiElements();
	    	var existing = typeof existingConditionalRecipient === 'object' ? true : false;
	    	
	    	var conditionalRecipient = existingConditionalRecipient || {
	    		id: this.getNextConditionalRecipientId(),
	    		recipient: 'email@example.com',
	    		element: multiElements[0].id,
	    		operator: 'eq',
	    		value: null
	    	};

	    	var $recipientLabel = $('<label>' + iphormL10n.send_to_email + '</label>');
	    	var $recipientElement = $('<input class="ifb-conditional-recipient" type="text"/>').val(conditionalRecipient.recipient);
	    	var $if = $('<span>' + iphormL10n.conditional_if + '</span>');
	    	var $elementSelect = $('<select/>', { onchange: 'iPhorm.updateConditionalElementValues(this, '+conditionalRecipient.id+');' }).addClass('ifb-conditional-element');
	    	for (var i = 0; i < multiElements.length; i++) {
	    		var multiElement = multiElements[i];
	    		$elementSelect.append($('<option/>', { value: multiElement.id, text: iPhorm.getShortenedAdminLabel(multiElement) }));
	    	}
	    	$elementSelect.val(conditionalRecipient.element);
	    	
	    	var $operatorSelect = $('<select/>').addClass('ifb-conditional-operator').append($('<option/>', { value: 'eq', text: iphormL10n.is_equal_to })).append($('<option/>', { value: 'neq', text: iphormL10n.is_not_equal_to })).val(conditionalRecipient.operator);
	    	
	    	var selectedElement = this.getElementById(conditionalRecipient.element);
	    	var $elementValues = $('<select/>').addClass('ifb-conditional-value');

	    	for (var i = 0; i < selectedElement.options.length; i++) {
	    		var option = selectedElement.options[i];
	    		$elementValues.append($('<option/>', { value: option.value, text: option.label }));
	    	}
	    	$elementValues.val(conditionalRecipient.value);
	    	
	    	var $deleteLink = $('<span class="ifb-small-delete-button" onclick="iPhorm.deleteConditionalRecipient('+conditionalRecipient.id+');">X</span>');
	    		    	
	    	$ruleLi = $('<li/>', { id: 'ifb-conditional-rule-' + conditionalRecipient.id }).append(
    			$recipientLabel,
    			$recipientElement,
    			$if,
    			$elementSelect,
    			$operatorSelect,
    			$elementValues,
    			$deleteLink
	    	).data('id', conditionalRecipient.id);
	    	
	    	$('#ifb-conditional-recipient-list').append($ruleLi);
	    	
	    	if (!existing) {
	    		this.form.conditional_recipients.push(conditionalRecipient);
	    	}
	    },
	    
	    deleteConditionalRecipient: function (id) {
	    	for (var i = 0; i < this.form.conditional_recipients.length; i++) {
				if (this.form.conditional_recipients[i].id == id) {
					this.form.conditional_recipients.splice(i, 1);
				}
			}

	    	$('#ifb-conditional-rule-' + id).hide(0, function () {
	    		$(this).remove();
	    		if ($('#ifb-conditional-recipient-list > li').length == 0) {
		    		$('#ifb-conditional-recipient-list-wrap').hide();
		    	}
	    	});	    	
	    },
	    
	    updateConditionalElementValues: function (select, ruleId) {
	    	var $ruleLi = $('#ifb-conditional-rule-' + ruleId);
    		var element = this.getElementById($ruleLi.find('.ifb-conditional-element').val());
    		if (element != null) {
    			var $valuesSelect = $ruleLi.find('.ifb-conditional-value');
    			$valuesSelect.empty();
    			for (var i = 0; i < element.options.length; i++) {
    				var option = element.options[i];
    				$valuesSelect.append($('<option/>', { value: option.value, text: option.value }));
    			}
    		}
	    },
	    
	    /**
	     * Returns all elements of type radio or select
	     * 
	     * @return array
	     */
	    getMultiElements: function () {
	    	var multiElements = [];
	    	
	    	for (var i = 0; i < this.form.elements.length; i++) {
	    		var element = this.form.elements[i];
	    		if (element.type == 'radio' || element.type == 'select') {
	    			multiElements.push(element);
	    		}
	    	}
	    	
	    	return multiElements;
	    },
	    
	    updateSuccessRedirectType: function () {
	    	var val = $('#success_redirect_type').val();
	    	
	    	if (!val.length) {
	    		$('#success_redirect_page').hide();
	    		$('#success_redirect_post').hide();
	    		$('#success_redirect_url').hide();
	    	} else if (val == 'page') {
	    		$('#success_redirect_page').show();
	    		$('#success_redirect_post').hide();
	    		$('#success_redirect_url').hide();
	    	} else if (val == 'post') {
	    		$('#success_redirect_page').hide();
	    		$('#success_redirect_post').show();
	    		$('#success_redirect_url').hide();
	    	} else if (val == 'url') {
	    		$('#success_redirect_page').hide();
	    		$('#success_redirect_post').hide();
	    		$('#success_redirect_url').show();
	    	}
	    },
	    
	    updateStartYear: function (input, element) {	    	
	    	var val = $(input).val();
	    	
	    	$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {
			       action: 'iphorm_get_start_year_ajax',
			       year: val
				},
				dataType: 'json',
				success: function (response) {
					if (response.type == 'success') {
						element.start_date = response.data;
						iPhorm.updateDatePreview(element);
						iPhorm.updateDateDefaultYear(element);
					}						
				}
			});
	    },
	    
	    updateEndYear: function (input, element) {
    		var val = $(input).val();
	    	
	    	$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {
			       action: 'iphorm_get_end_year_ajax',
			       year: val
				},
				dataType: 'json',
				success: function (response) {
					if (response.type == 'success') {
						element.end_date = response.data;
						iPhorm.updateDatePreview(element);
						iPhorm.updateDateDefault(element);
					}							
				}
			});
	    },
	    
	    updateDatePreview: function (element) {
	    	$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {
			       action: 'iphorm_get_date_years_ajax',
			       start_year: $('#start_year_'+element.id).val(),
			       end_year: $('#end_year_'+element.id).val()
				},
				dataType: 'json',
				success: function (response) {
					if (response.type == 'success') {
						// Save the current selected default date values
				    	var defaultDay = $('#default_value_' + element.id + '_day').val(),
				    	defaultMonth = $('#default_value_' + element.id + '_month').val(),
				    	defaultYear = $('#default_value_' + element.id + '_year').val();
				    	
						// Empty the drop downs
				    	var $day = $('#ifb_element_' + element.id + '_day').empty();
				    	var $month = $('#ifb_element_' + element.id + '_month').empty();
				    	var $year = $('#ifb_element_' + element.id + '_year').empty();
				    	var $defaultDay = $('#default_value_' + element.id + '_day').empty();
				    	var $defaultMonth = $('#default_value_' + element.id + '_month').empty();
				    	var $defaultYear = $('#default_value_' + element.id + '_year').empty();
				    	
				    	// Add headings if they are set
				    	if (element.show_date_headings) {
				    		var dayHeading = $('#day_heading_' + element.id).val() || iphormL10n.day,
				    		monthHeading = $('#month_heading_' + element.id).val() || iphormL10n.month,
				    		yearHeading = $('#year_heading_' + element.id).val() || iphormL10n.year;
				    		$day.add($defaultDay).append($('<option/>', { value: '', text: dayHeading }));
				    		$month.add($defaultMonth).append($('<option/>', { value: '', text: monthHeading }));
				    		$year.add($defaultYear).append($('<option/>', { value: '', text: yearHeading }));
				    	}
				    	
				    	// Add the days
				    	for (var i = 1; i <= 31; i++) {
				    		$day.add($defaultDay).append($('<option/>', { value: i, text: i }));
				    	}
				    	$day.add($defaultDay).val(defaultDay);
				    	
				    	// Add the months
				    	for (var i = 1; i <= 12; i++) {
				    		var monthText = ($('#months_as_numbers_' + element.id).is(':checked')) ? i : iphormL10n.months[i];				    		
				    		$month.add($defaultMonth).append($('<option/>', { value: i, text: monthText }));
				    	}
				    	$month.add($defaultMonth).val(defaultMonth);
				    	
				    	// Add the years
				    	var sy = response.data.start_year, ey = response.data.end_year;
				    	if (sy > ey) {
					    	for (var i = sy; i >= ey; i--) {
					    		$year.add($defaultYear).append($('<option/>', { value: i, text: i }));
					    	}
				    	} else {
				    		for (var i = sy; i <= ey; i++) {
					    		$year.add($defaultYear).append($('<option/>', { value: i, text: i }));
					    	}
				    	}
				    	$year.add($defaultYear).val(defaultYear);

				    	// Check if we need to swap day and month
				    	if ($('#field_order_' + element.id).val() != 'us') {
				    		$day.after($month);
				    		$defaultDay.after($defaultMonth);
				    	} else {
				    		$month.after($day);
				    		$defaultMonth.after($defaultDay);
				    	}
					}						
				}
			});
	    },
	    
	    updateDefaultDate: function (element) {
	    	$('#ifb_element_' + element.id + '_day').val($('#default_value_' + element.id + '_day').val());
	    	$('#ifb_element_' + element.id + '_month').val($('#default_value_' + element.id + '_month').val());
	    	$('#ifb_element_' + element.id + '_year').val($('#default_value_' + element.id + '_year').val());
	    },
	    
	    showDateHeadings: function (checked, element) {
	    	if (checked) {
	    		element.show_date_headings = true;
	    	} else {
	    		element.show_date_headings = false;
	    	}
	    	
	    	iPhorm.updateDatePreview(element);
	    },
	    	    
	    updateTimePreview: function (element) {
	    	var $defaultHour = $('#default_value_' + element.id + '_hour'),
	    	$defaultMinute = $('#default_value_' + element.id + '_minute'),
	    	$defaultAmpm = $('#default_value_' + element.id + '_ampm');
	    	
	    	var defaultHour = $defaultHour.val(),
	    	defaultMinute = $defaultMinute.val(),
	    	defaultAmpm = $defaultAmpm.val();
	    	
	    	var $hour = $('#ifb_element_' + element.id + '_hour').empty(),
	    	$minute = $('#ifb_element_' + element.id + '_minute').empty(),
	    	$ampm = $('#ifb_element_' + element.id + '_ampm').empty();
	    	
	    	$defaultHour.empty();
	    	$defaultMinute.empty();
	    	$defaultAmpm.empty();
	    	
	    	var is24hr = $('#time_12_24_' + element.id).val() == '24';
	    	
	    	// Add the hours
	    	if (is24hr) {
	    		$ampm.add($defaultAmpm).hide();
	    		for (var i = 0; i <= 23; i++) {
	    			var value = i < 10 ? '0'+i : ''+i;
	    			$hour.add($defaultHour).append($('<option/>', { value: value, text: value }));
		    	}
    		} else {
    			$ampm.add($defaultAmpm).show();
				for (var i = 1; i <= 12; i++) {
					var value = i < 10 ? '0'+i : ''+i;
	    			$hour.add($defaultHour).append($('<option/>', { value: value, text: value }));
		    	}
    		}
	    	$hour.add($defaultHour).val(defaultHour);
	    	
	    	var minuteGranularity = $('#minute_granularity_' + element.id).val();
	    	// Add the minutes
	    	for (var i = 0; i <= 59; i++) {
	    		if (i % minuteGranularity == 0) {
	    			var value = i < 10 ? '0'+i : ''+i;
	    			$minute.add($defaultMinute).append($('<option/>', { value: value, text: value }));
	    		}
	    	}
	    	$minute.add($defaultMinute).val(defaultMinute);
	    	
	    	var amString = $('#am_string_' + element.id).val() || iphormL10n.am_string,
	    	pmString = $('#pm_string_' + element.id).val() || iphormL10n.pm_string;
	    	
	    	$ampm.add($defaultAmpm).append($('<option/>', { value: 'am', text: amString }));
	    	$ampm.add($defaultAmpm).append($('<option/>', { value: 'pm', text: pmString }));
	    	
	    	// Set the default AM/PM
	    	$ampm.add($defaultAmpm).val(defaultAmpm);
	    },
	    
	    getAdminLabel: function (element) {	    	
	    	if (typeof element.admin_label === 'string' && element.admin_label.length > 0) {
	    		return element.admin_label;
	    	}
	    	
	    	if (typeof element.label === 'string' && element.label.length > 0) {
	    		return element.label;
	    	}
	    	
	    	return '';
	    },

        getPodioId: function (element) {
            return element.podio_id;
        },

        getPodioDataType: function (element) {
            return element.podio_data_type;
        },

        getInputMask: function (element) {
            return element.input_mask;
        },
	    
	    getShortenedAdminLabel: function (element) {
	    	return iPhorm.shorten(iPhorm.getAdminLabel(element));
	    },
	    
	    shorten: function (text, maxLength, join) {
	    	if (!maxLength) maxLength = 20;	    	
	    	if (!join) join = '...';
	    	
	    	var halfLength = Math.floor(maxLength / 2);
	    	
	    	if (text.length > maxLength) {
	    		var firstHalf = text.slice(0, halfLength - 1);
	    		var secondHalf = text.slice(-halfLength);
	    		text = firstHalf + join + secondHalf;
	    	}
	    	
	    	return text;
	    },
	    
	    updateTooltipStyle: function () {
	    	var style = $('#tooltip_style').val();
	    	
	    	if (style == 'custom') {
	    		$('.show-if-tooltip-style-previewable').hide();
	    		$('.show-if-tooltip-style-custom').show();
	    	} else {
	    		var classes = [style];
	    		
	    		if ($('#tooltip_shadow').is(':checked')) {
	    			classes.push('ui-tooltip-shadow');
	    		}
	    		
	    		if ($('#tooltip_rounded').is(':checked')) {
	    			classes.push('ui-tooltip-rounded');
	    		}
	    		
	    		$('#ifb-tooltip-example').qtip('destroy').qtip({
	    			content: iphormL10n.example_tooltip,
	    			style: {
	    				classes: classes.join(' ')
	    			},
	    			position: {
	    				my: $('#tooltip_my').val(),
    					at: $('#tooltip_at').val()
	    			}
	    		}).show();
	     		
	    		$('#tooltip_custom').val('');
	    		$('.show-if-tooltip-style-previewable').show();
	    		$('.show-if-tooltip-style-custom').hide();	   	    		
	    	}
	    },
	    
	    sortElements: function() {
			var elements = [];
			
			$.each($elementsList.children(), function () {
				var id = $(this).attr('id').substring(17);
				elements.push(iPhorm.getElementById(id));
			});
			
			iPhorm.form.elements = elements;
	    },
	    	    
	    addMessage: function(message, type, timeout) {
	    	if (typeof type === 'undefined') {
	    		type = 'success';
	    	}
	    	
	    	if (typeof timeout === 'undefined') {
	    		timeout = 0;
	    	}	    	
	    	
	    	var $message = $('<div/>').addClass('ifb-message ifb-message-' + type).html(message);
	    	
    		var $close = $('<div/>').addClass('ifb-close-message').click(function () {
    			$message.fadeOut('slow').hide(0, function() {
    				$message.remove();
    			});
    		});
    		$message.prepend($close);
	    	
	    	$messageArea.empty().prepend($message);
	    	$message.hide().fadeIn('slow');
	    	
	    	if (timeout > 0) {
	    		setTimeout(function() {
	    			$message.fadeOut('slow').hide(0, function() {
	    				$message.remove();
	    			});
	    		}, (timeout*1000));
	    	}
	    },
	    
	    addResponseMessage: function (responseMessage) {
	    	iPhorm.addMessage(responseMessage.content, responseMessage.type, responseMessage.timeout);
	    },
	    
	    formatAddMessage: function (content, type, timeout, more) {
	    	if (typeof type === 'undefined') {
	    		type = 'success';
	    	}
	    	
	    	if (typeof timeout === 'undefined') {
	    		timeout = 5;
	    	}
	    	
	    	if (more && more.length > 0) {
	    		content += ' <a href="#" class="ifb-message-more">' + iPhorm.htmlEntities(iphormL10n.more_information) + '</a>.';
	    		content += '<div class="ifb-hidden ifb-message-more-content">' + more + '</div>';
	    	}
	    	
	    	iPhorm.addMessage(content, type, timeout);
	    },
	    
	    htmlEntities: function (str) {
	    	return $('<div/>').text(str).html();
	    },
	    
	    scrollToElement: function (element) {
	    	iPhorm.showSettings(element.id);
	    	
	    	function pulseIn(callback) {
	    		$('#ifb-element-wrap-' + element.id + ' .ifb-element-preview').animate({  			
    				borderTopColor: '#C30000',
    				borderRightColor: '#C30000',
    				borderBottomColor: '#C30000',
    				borderLeftColor: '#C30000'
	    		}, 200, function () {
	    			if (typeof callback === 'function') {
	    				callback.apply(this);
	    			}
	    		});
	    	}
	    	
	    	function pulseOut(callback)
	    	{
	    		$('#ifb-element-wrap-' + element.id + ' .ifb-element-preview').animate({  			
	    			borderTopColor: '#919191',
    				borderRightColor: '#919191',
    				borderBottomColor: '#919191',
    				borderLeftColor: '#919191'
	    		}, 200, function () {
	    			if (typeof callback === 'function') {
	    				callback.apply(this);
	    			}
	    		});	    		
	    	}
	    	
	    	$.smoothScroll({
				scrollTarget: $('#ifb-element-wrap-' + element.id),
				offset: -50,
				speed: 1000,
				afterScroll: function () {
	    			pulseIn(function () {
	    				pulseOut(function () {
	    					pulseIn(function () {
	    						pulseOut(function () {
	    							$(this).removeAttr('style');
	    						});
	    					});
	    				});
	    			});	    			
		    	}
			});
	    },
	    
	    updateFormTitle: function () {
	    	var val = $('#title').val();
	    	$('#ifb-title').html(val);
	    	
	    	if (val.length > 0) {
	    		$('#ifb-title').fadeIn('slow');
	    	} else {
	    		$('#ifb-title').hide();
	    	}
	    },
	    
	    updateFormDescription: function () {
	    	var val = $('#description').val();
	    	$('#ifb-description').html(val);
	    	
	    	if (val.length > 0) {
	    		$('#ifb-description').fadeIn('slow');
	    	} else {
	    		$('#ifb-description').hide();
	    	}
	    },
	    
	    savePreviewLabel: function (value, element) {
	    	$('#label_' + element.id).val(value);
	    	iPhorm.updateElementLabel(element);
	    },
	    
	    maybeSelectOptionText: function (input) {
	    	var val = $(input).val();
	    	
	    	if (val == iphormL10n.option_1 || val == iphormL10n.option_2 || val == iphormL10n.option_3) {
	    		$(input).select();
	    	}
	    },
	    
	    positionMessageBox: function() {
	    	var $messageArea = $('#ifb-message-area');
	    	var scrollY = $(window).scrollTop();
	    	var minY = $('.ifb-wrap').offset().top - 20;
	    	var isFixed = $messageArea.css('position') == 'fixed';
	    	var marginRight = $('body').hasClass('folded') ? '-258px' : '-315px';

	    	if (scrollY > minY && !isFixed) {
	    		$messageArea.css({
	    			position: 'fixed',
    	            right: '50%',
    	            marginRight: marginRight,
    	            top: '39px'
	    		});
	    	} else if (scrollY < minY && isFixed) {
	    		$messageArea.css({
	    			position: 'absolute',
    	            right: 0,
    	            top: '19px',
    	            marginRight: 0
	    		});
	    	}
	    },
	    
	    positionRightColumn: function() {
	    	var $scrollElement = $('.ifb-right-scroll-wrap');
	    	var scrollY = $(window).scrollTop();
	    	var minY = $('.ifb-wrap').offset().top - 20;
	    	var isFixed = $scrollElement.css('position') == 'fixed';
	    	var marginRight = $('body').hasClass('folded') ? '-451px' : '-508px';

	    	if (scrollY > minY && !isFixed) {
	    		$scrollElement.css({
	    			position: 'fixed',
    	            right: '50%',
    	            marginRight: marginRight,
    	            top: '20px'
	    		});
	    	} else if (scrollY < minY && isFixed) {
	    		$scrollElement.css({
	    			position: 'static',
    	            right: 0,
    	            top: 0,
    	            marginRight: 0
	    		});
	    	}
	    },
	    
	    showScrollTopButton: function () {
	    	if ($(window).scrollTop() > 200) {
	    		$('#ifb-scroll-top').fadeIn();
	    	} else {
	    		$('#ifb-scroll-top').fadeOut();
	    	}
	    },
	    
	    toggleUseWpDb: function (checked) {
			if (checked) {
				$('.ifb-show-if-not-wpdb').hide();
			} else {
				$('.ifb-show-if-not-wpdb').show();
			}
		},
		
		addDbField: function (field, value) {
			if (!field) field = '';
			if (!value) value = '';
			
			$('#db_fields_empty').hide();
			$('#db_fields_headings').show();
			$('#db_fields').show().append('<li><input type="text" name="db_field_name" class="db_field_name" value="' + field + '" /> <input type="text" name="db_field_value" class="db_field_value" value="' + value + '" /> <select class="ifb-insert-variable" onchange="iPhorm.insertVariable(jQuery(this).prev(\'.db_field_value\'), this);"></select> <span class="ifb-small-delete-button" onclick="iPhorm.removeDbField(this); return false;" title="' + iphormL10n.remove + '">x</span></li>');
		
			iPhorm.updateSettingsDependencies();
		},
		
		removeDbField: function (listItem) {
			$(listItem).parent().remove();
			
			if ($('#db_fields').children().length == 0) {
				$('#db_fields').hide();
				$('#db_fields_headings').hide();
				$('#db_fields_empty').show();
			}
		},
		
		updateDbFields: function () {
			iPhorm.form.db_fields = {};
			
			$('#db_fields > li').each(function () {
				var field = $(this).find('.db_field_name').val(),
				value = $(this).find('.db_field_value').val();
				
				if (field.length) {
					iPhorm.form.db_fields[field] = value;
				}
			});
		},
		
		updateSuccessType: function () {
			if ($('#success_type').val() == 'redirect') {
				$('.show-if-success-type-redirect').show();
				$('.show-if-success-type-message').hide();
			} else {
				$('.show-if-success-type-redirect').hide();
				$('.show-if-success-type-message').show();
			}
		},
		
		toggleUseUniform: function (checked) {
			if (checked) {
				$('.show-if-use-uniform').show();
			} else {
				$('.show-if-use-uniform').hide();
			}
		},
		
		toggleCustomiseEmailContent: function (checked) {
			if (checked) {
				$('.ifb-show-if-customise-email-content').show();
			} else {
				$('.ifb-show-if-customise-email-content').hide();
			}
		},
		
		updateFormName: function () {
			$('.ifb-update-form-name').text($('#name').val());
		},
		
		updateGroupName: function (element) {
			var name = $('#name_' + element.id).val();
			$('#ifb-element-wrap-' + element.id).find('.ifb-start-group-name').text(name);
			$('#ifb-element-wrap-' + (element.id+1)).find('.ifb-group-end-name').text(name);
		},
		
		toggleAddAnotherUpload: function (element) {
			if ($('#upload_user_add_more_' + element.id).is(':checked')) {
				$('.show-if-upload-user-add-more', '#ifb-element-wrap-' + element.id).show();
			} else {
				$('.show-if-upload-user-add-more', '#ifb-element-wrap-' + element.id).hide();
			}
		},
		
		updateOptionsLayout: function (element) {
			if ($('#options_layout_' + element.id).val() == 'block') {
				$('#ifb_element_' + element.id).removeClass('ifb-options-inline').addClass('ifb-options-block');
			} else {
				$('#ifb_element_' + element.id).removeClass('ifb-options-block').addClass('ifb-options-inline');
			}
		},
		
		setElementLabelPlacement: function (element) {
			if ($('#label_placement_' + element.id).val() == 'left') {
				$('.ifb-show-if-element-label-placement-left', '#ifb-element-wrap-' + element.id).show();
			} else {
				$('.ifb-show-if-element-label-placement-left', '#ifb-element-wrap-' + element.id).hide();
			}
		},
		
		hideNagMessage: function () {
			$('#ifb-nag-message').remove();
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {
			       action: 'iphorm_hide_nag_message'
				}
			});
		},
		
		isScrolledIntoView: function (elem) {
	        var docViewTop = $(window).scrollTop();
	        var docViewBottom = docViewTop + $(window).height();

	        var elemTop = $(elem).offset().top;
	        var elemBottom = elemTop + $(elem).height();

	        return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom)
	          && (elemBottom <= docViewBottom) &&  (elemTop >= docViewTop) );
	    },
	    
	    getElementPosition: function (element) {
	    	for (var i = 0; i < iPhorm.form.elements.length; i++) {
	    		if (iPhorm.form.elements[i].id == element.id) {
	    			return i;
	    		}
	    	}
	    	
	    	return 0;
	    },
	    
	    addEntryLayoutColumn: function (element) {
	    	iPhorm.removeEntryLayoutColumn(element);
	    	var $activeColumnList = $('#ifb-active-columns');
	    	if ($activeColumnList.children().length > 3) {
	    		$target = $('#ifb-inactive-columns');
	    	} else {
	    		$target = $activeColumnList;
	    	}
	    	$target.append('<li><div class="button" data-type="element" data-id="' + element.id + '">' + iPhorm.getShortenedAdminLabel(element) + '</div></li>');	    	
	    },
	    
	    updateEntryLayoutColumnLabel: function (element) {
	    	$('#ifb-active-columns > li > div').each(function () {
	    		if ($(this).data('id') == element.id) {
	    			$(this).text(iPhorm.getShortenedAdminLabel(element));
	    		}
	    	});

	    	$('#ifb-inactive-columns > li > div').each(function () {
	    		if ($(this).data('id') == element.id) {
	    			$(this).text(iPhorm.getShortenedAdminLabel(element));
	    		}
	    	});
	    },
	    
	    removeEntryLayoutColumn: function (element) {
	    	$('#ifb-active-columns > li > div').each(function () {
	    		if ($(this).data('id') == element.id) {
	    			$(this).parent().remove();
	    		}
	    	});

	    	$('#ifb-inactive-columns > li > div').each(function () {
	    		if ($(this).data('id') == element.id) {
	    			$(this).parent().remove();
	    		}
	    	});
	    },
	    
	    toggleSaveToDatabase: function (element) {
	    	if ($('#save_to_database_' + element.id).is(':checked')) {
	    		iPhorm.addEntryLayoutColumn(element);
	    	} else {
	    		iPhorm.removeEntryLayoutColumn(element);
	    	}
	    },
	    
	    toggleShowDatepicker: function (element) {
	    	if ($('#show_datepicker_' + element.id).is(':checked')) {
	    		$('.ifb-show-if-show-datepicker', '#ifb-element-wrap-' + element.id).show();
	    	} else {
	    		$('.ifb-show-if-show-datepicker', '#ifb-element-wrap-' + element.id).hide();
	    	}
	    },
	    
	    groupStyleChanged: function (element) {
	    	if ($('#group_style_' + element.id).val() == 'plain') {
	    		$('.ifb-show-if-group-style-bordered', '#ifb-element-wrap-' + element.id).hide();
	    	} else {
	    		$('.ifb-show-if-group-style-bordered', '#ifb-element-wrap-' + element.id).show();
	    	}
	    },
	    
	    toggleClearDefaultValue: function (element) {
	    	if ($('#clear_default_value_' + element.id).is(':checked')) {
	    		$('.ifb-show-if-clear-default-value', '#ifb-element-wrap-' + element.id).show();
	    	} else {
	    		$('.ifb-show-if-clear-default-value', '#ifb-element-wrap-' + element.id).hide();
	    	}
	    },
	    
	    showBulkOptions: function (element) {
	    	tb_show(iphormL10n.add_bulk_options, '#TB_inline?height=500&amp;width=500&amp;inlineId=ifb-bulk-options-' + element.id);
	    	
	    	// Fix to prevent Thickbox breaking jQuery UI tabs for WP < 3.3
	    	$("#TB_window, #TB_overlay, #TB_HideSelect").one('unload', function (e) {
	    	    e.stopPropagation();
	    	    e.stopImmediatePropagation();
	    	    return false;
	    	});
	    },
	    	    
	    loadBulkOptions: function (type, element) {
	    	if (typeof iphormL10n.bulk_options[type] === 'object') {
	    		$('#bulk_options_textarea_' + element.id).val(iphormL10n.bulk_options[type].join('\n'));
	    	}
	    },
	    
	    insertBulkOptions: function (element) {
	    	var $bulkOptions = $('#bulk_options_textarea_' + element.id),
	    	bulkOptions = $bulkOptions.val();
	    	
	    	if (bulkOptions.length) {
	    		var $optionsList = $('#ifb_options_' + element.id);
		    	if ($('#bulk_options_clear_' + element.id).is(':checked')) {
		    		$optionsList.empty();
		    	}
		    	
		    	bulkOptions = bulkOptions.split('\n');
		    	
		    	for (var i = 0; i < bulkOptions.length; i++) {
		    		$optionsList.append(iPhorm.getOptionHtml(element, bulkOptions[i]));
		    	}
		    	
		    	iPhorm.updateOptions(element);
		    	iPhorm.updateLogicOptions(element);
	    	}
	    	
	    	$bulkOptions.val('');
	    	
	    	if (typeof tb_remove === 'function') {
	    		tb_remove();
	    	}
	    },
	    
	    loadBulkExistingOptions: function (element) {
	    	var options = [];
	    	for (var i = 0; i < element.options.length; i++) {
	    		options.push(element.options[i].label);
	    	}
	    	
	    	$('#bulk_options_textarea_' + element.id).val(options.join('\n'));
	    },
	    
	    togglePreventDuplicates: function (element) {
	    	if ($('#prevent_duplicates_' + element.id).is(':checked')) {
	    		$('.ifb-show-if-prevent-duplicates', '#ifb-element-wrap-' + element.id).show();
	    	} else {
	    		$('.ifb-show-if-prevent-duplicates', '#ifb-element-wrap-' + element.id).hide();
	    	}
	    },
	    
	    notificationFromTypeChanged: function () {
	    	if ($('#notification_from_type').val() == 'static') {
	    		$('.ifb-notification-from-element').hide();
	    		$('.ifb-notification-from-static').show();
	    	} else {
	    		$('.ifb-notification-from-static').hide();
	    		$('.ifb-notification-from-element').show();
	    	}
	    },
	    
	    autoreplyFromTypeChanged: function () {
	    	if ($('#autoreply_from_type').val() == 'static') {
	    		$('.ifb-autoreply-from-element').hide();
	    		$('.ifb-autoreply-from-static').show();
	    	} else {
	    		$('.ifb-autoreply-from-static').hide();
	    		$('.ifb-autoreply-from-element').show();
	    	}
	    },
	    
	    toggleLogic: function (element) {	    	
	    	if ($('#logic_' + element.id).is(':checked')) {
	    		iPhorm.syncLogic(element);
	    		$('.ifb-show-if-logic-on', '#ifb-element-wrap-' + element.id).show();
	    		$('#enable_wrapper_' + element.id).attr('checked', true);
	    	} else {
	    		$('.ifb-show-if-logic-on', '#ifb-element-wrap-' + element.id).hide();
	    	}
	    },
	    
	    toggleLogicOff: function (element) {
	    	$('#logic_' + element.id).attr('checked', false);
	    	$('.ifb-show-if-logic-on', '#ifb-element-wrap-' + element.id).hide();
	    },
	    
	    syncLogic: function (element, update, hideIfNoRules) {
	    	switch (element.type) {
	    		case 'hidden':
	    		case 'groupend':
	    			// Not applicable to hidden/groupend element types
	    			break;
    			default:
	    			if (update !== false) {
	    				iPhorm.updateLogic(element);
	    			}
	    			$('#ifb_logic_rules_' + element.id).empty();
	    			if ($('#logic_' + element.id).is(':checked')) {
	    				if (iPhorm.logicableElements.length > 0) {
	    					var $rulesOuter = $('<div class="ifb-rules-outer-wrap"></div>'),
	    					$rulesTop = $('<div class="ifb-rules-top"></div>');
	    					
	    					var this_if_text = element.type == 'groupstart' ? iphormL10n.this_group_if : iphormL10n.this_field_if;
	    					
	    					$rulesTop.append($('<select id="logic_action_' + element.id + '">').append($('<option>', { text: iphormL10n.show, value: 'show' })).append($('<option>', { text: iphormL10n.hide, value: 'hide' })).val(element.logic_action));
	    					$rulesTop.append($('<span class="ifb-logic-top-if"></span>').text(this_if_text));
	    					$rulesTop.append($('<select id="logic_match_' + element.id + '">').append($('<option>', { text: iphormL10n.all, value: 'all' })).append($('<option>', { text: iphormL10n.any, value: 'any' })).val(element.logic_match));
	    					$rulesTop.append($('<span class="ifb-logic-top-rules-match"></span>').text(iphormL10n.these_rules_match));
	    					$rulesOuter.append($rulesTop);
	    					
	    					$rulesWrap = $('<div class="ifb-rules-wrap"></div>');
	    					
	    					if (element.logic_rules.length) {
	    						for (var i = 0; i < element.logic_rules.length; i++) {
	    							$rulesWrap.append(iPhorm.buildLogicRule(element.logic_rules[i], element, i));
	    						}	    						
	    					} else {
    							$rulesWrap.append(iPhorm.buildLogicRule(iPhorm.getNewLogicRule(), element, 0));
    							if (hideIfNoRules) {
    								iPhorm.toggleLogicOff(element);
    							}
	    					}
	    					
	    					$rulesOuter.append($rulesWrap);
	    					$('#ifb_logic_rules_' + element.id).append($rulesOuter);
	    				} else {
	    					$('#ifb_logic_rules_' + element.id).html('<div class="ifb-info-message"><span class="ifb-info-message-icon"></span>'+ iphormL10n.need_multi_element +'</div>');
	    					if (hideIfNoRules) {
	    						iPhorm.toggleLogicOff(element);
	    					}
	    				}
	    	    	}
	    			break;
	    	}
	    },
	    
	    buildLogicRule: function (rule, element, index) {
			var $ruleWrap = $('<div id="ifb-rule-wrap-'+element.id+'-'+index+'" class="ifb-rule-wrap"></div>');
			
			var $element = $('<select id="logic_rule_element_'+element.id+'_'+index+'" class="logic_rule_element"></select>');
			for (var i = 0; i < iPhorm.logicableElements.length; i++) {
				$element.append($('<option>', { text: iPhorm.getShortenedAdminLabel(iPhorm.logicableElements[i]), value: iPhorm.logicableElements[i].id }));
			}
			
			var $operator = $('<select id="logic_rule_operator_'+element.id+'_'+index+'" class="logic_rule_operator"></select>').append($('<option>', { text: iphormL10n.is, value: 'eq' })).append($('<option>', { text: iphormL10n.is_not, value: 'neq' }));
			
			if (typeof rule === 'object') {
				$element.val(rule.element_id);
				$operator.val(rule.operator);
			}
			
			var $value = iPhorm.buildLogicRuleValues($element.val(), element, index, (typeof rule === 'object') ? rule.value : '');
			
			$element.change(function () {
				$('#logic_rule_value_'+element.id+'_'+index).replaceWith(iPhorm.buildLogicRuleValues($(this).val(), element, index));
			});
			
			var $addButton = $('<span class="ifb-small-add-button"></span>').click(function () {
				iPhorm.addLogicRule(element, index+1);
			});
			
			var $deleteButton = $('<span class="ifb-small-delete-button"></span>').click(function () {
				iPhorm.deleteLogicRule(element, index);
			});
			
			$ruleWrap.append($element).append($operator).append($value).append($addButton).append($deleteButton);
			return $ruleWrap;
	    },
	    
	    buildLogicRuleValues: function (selectedElementId, element, index, selectedValue) {
	    	$value = $('<select id="logic_rule_value_'+element.id+'_'+index+'" class="logic_rule_value"></select>');
	    	
	    	var selectedElement = iPhorm.getElementById(selectedElementId),
			optionHasBeenSelected = false;
			
			for (var i = 0; i < selectedElement.options.length; i++) {
				var $option = $('<option>', { text: iPhorm.shorten(selectedElement.options[i].label), value: selectedElement.options[i].value });
				if (selectedElement.options[i].value == selectedValue) {
					$option.attr('selected', 'selected');
					optionHasBeenSelected = true;
				}
				
				$value.append($option);
			}

			// There was a saved value that's no longer in the list, add it to stop this rule incorrectly interfering
			if (!optionHasBeenSelected && selectedValue && selectedValue.length > 0) {
				$value.append($('<option>', { text: selectedValue, value: selectedValue }).attr('selected', 'selected'));
			}
			
			return $value;
	    },
	    
	    syncAllLogic: function (update, hideIfNoRules) {
	    	for (var i = 0; i < iPhorm.form.elements.length; i++) {
	    		iPhorm.syncLogic(iPhorm.form.elements[i], update, hideIfNoRules);
	    	}
	    },
	    
	    updateLogic: function (element) {
	    	element.logic = $('#logic_' + element.id).is(':checked');
	    	element.logic_action = 'show';
	    	element.logic_match = 'all';
	    	element.logic_rules = [];
	    	
	    	if (element.logic) {
	    		element.logic_action = $('#logic_action_' + element.id).val();
	    		element.logic_match = $('#logic_match_' + element.id).val();
	    		
	    		$('.ifb-rule-wrap', '#ifb_logic_rules_' + element.id).each(function () {
	    			element.logic_rules.push({
	    				element_id: $(this).find('.logic_rule_element').val(),
	    				operator: $(this).find('.logic_rule_operator').val(),
    					value: $(this).find('.logic_rule_value').val()
	    			});
	    		});
	    		
	    		// If there are no rules, just disable logic altogether
	    		if (element.logic_rules.length == 0) {
	    			element.logic = false;
	    		}
	    	}
	    },
	    
	    updateAllLogic: function () {
	    	for (var i = 0; i < iPhorm.form.elements.length; i++) {
	    		iPhorm.updateLogic(iPhorm.form.elements[i]);
	    	}
	    },
	    	    	    
	    deleteLogicableElement: function (element) {
	    	for (var i = 0; i < iPhorm.logicableElements.length; i++) {
	    		if (iPhorm.logicableElements[i].id == element.id) {
	    			iPhorm.logicableElements.splice(i, 1);
	    		}
	    	}
	    },
	    
	    addLogicRule: function (element, index) {
	    	iPhorm.updateLogic(element);
	    	element.logic_rules.splice(index, 0, iPhorm.getNewLogicRule());
	    	iPhorm.syncLogic(element, false);	    	
	    },
	    
    	deleteLogicRule: function (element, index) {
	    	iPhorm.updateLogic(element);
	    	if (element.logic_rules.length > 1) {
	    		element.logic_rules.splice(index, 1);
	    		iPhorm.syncLogic(element, false);
	    	}
	    },
	    
	    getNewLogicRule: function () {
	    	return { element_id: '', operator: 'eq', value: '' };
	    },
	    
	    deleteDependentLogicRules: function (element) {
	    	iPhorm.updateAllLogic();
	    	for (var i = 0; i < iPhorm.form.elements.length; i++) {
	    		if (typeof iPhorm.form.elements[i].logic_rules === 'object') {
	    			var newLogicRules = [];
	    			for (var j = 0; j < iPhorm.form.elements[i].logic_rules.length; j++) {
	    				if (iPhorm.form.elements[i].logic_rules[j].element_id != element.id) {
	    					newLogicRules.push(iPhorm.form.elements[i].logic_rules[j]);
	    				}
	    			}
	    			iPhorm.form.elements[i].logic_rules = newLogicRules;
	    		}
	    	}
	    },
	    
	    /**
	     * Updates existing logic rules with changes to the element labels
	     * 
	     * @param object element
	     */
	    updateLogicRuleLabels: function (element) {
	    	$('.logic_rule_element > option[value="'+element.id+'"]').each(function () {
	    		$(this)[0].text = iPhorm.getShortenedAdminLabel(element);
	    	});
	    },
	    
	    /**
	     * Updates existing logic rules with changes to the options
	     * for the given element
	     * 
	     * @param object element
	     */
	    updateLogicOptions: function (element) {
	    	$('.logic_rule_element > option[value="'+element.id+'"]').each(function () {
	    		var id = $(this).parent().attr('id'),
	    		idParts = id.split('_');
	    		
	    		id = id.replace('element', 'value');
	    		
	    		$values = $('#' + id);
	    		selectedValue = $values.val();

	    		$values.replaceWith(iPhorm.buildLogicRuleValues(element.id, iPhorm.getElementById(idParts[3]), idParts[4], selectedValue));
	    	});
	    },
	    
	    toggleDynamicDefaultValue: function (element) {
	    	if ($('#dynamic_default_value_' + element.id).is(':checked')) {
	    		$('.ifb-show-if-dynamic-default-value', '#ifb-element-wrap-' + element.id).show();
	    	} else {
	    		$('.ifb-show-if-dynamic-default-value', '#ifb-element-wrap-' + element.id).hide();
	    	}
	    }
	};
	
	window.iphormPreloadedImages = [];
	window.iphormPreload = function (images, prefix) {
		for (var i = 0; i < images.length; i++) {
			var elem = document.createElement('img');
			elem.src = prefix ? prefix + images[i] : images[i];
			window.iphormPreloadedImages.push(elem);
		}
	};
	
	/**
	 * Preload form builder images
	 */
	window.iphormPreload([
       '/button-blue-hover.png',
       '/pop-up-box-close.png',
       '/pop-up-box-close-hover.png',
       '/button-orange-hover.png',
       '/add-icon-for-orange-button.png',
       '/edit-form-icon-grey.png',
       '/form-settings-icon-orange.png',
       '/help-hover.png',
       '/button-grey.png',
       '/button-grey-hover.png',
       '/go-to-top-hover.png',
       '/side-button-loading.gif',
       '/button-extra-tick.png',
       '/button-extra-fail.png',
       '/button-orange.png',
       '/drop-element-from-here.png',
       '/button-dark.png',
       '/button-dark-hover.png',
       '/delete-bg-hover.png',
       '/button-extra-minus-smaller.png',
       '/button-extra-minus-mini.png',
       '/button-extra-add-mini.png',
       '/color-wheel.png',
       '/toggle-plus.png',
       '/loading.gif',
       '/move-here.png',
       '/iphorm-main-nav-bg-hover.png',
       '/info-icon.png'       
    ], iphormL10n.admin_images_url);
})(jQuery, window);