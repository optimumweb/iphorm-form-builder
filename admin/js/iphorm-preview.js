jQuery(document).ready(function ($) {
	var getForm = function (form) {
		// Fix for JSON.stringify if prototype.js is loaded
		if (typeof Array.prototype.toJSON == 'function') {
			delete Array.prototype.toJSON;
		}
		
		$.ajax({
			url: iphormPreviewL10n.ajax_url,
			type: 'POST',
			dataType: 'json',
			data: {
				form: JSON.stringify(form),
				action: 'iphorm_preview_form_ajax'
			},
			success: function (response) {
				if (response.type == 'success') {
					$('.ip-loading').hide();
					$('.ip-form-wrap').html(response.data);
				}
			}
		});
	};
	if (typeof form === 'object') {
		getForm(form);		
	} else if (window.opener && window.opener.open && !window.opener.closed) {
		if (typeof window.opener.iPhorm === 'object' && typeof window.opener.iPhorm.form === 'object') {
			window.opener.iPhorm.update();
			getForm(window.opener.iPhorm.form);
		} else {
			$('.ip-loading').hide();
			$('.ip-sorry').show();
		}		
	} else {
		$('.ip-loading').hide();
		$('.ip-sorry').show();
	}
});