/*
 *  PekeUpload 1.0.6 - jQuery plugin
 *  written by Pedro Molina
 *  http://www.mavatarsbyte.com/
 *
 *  Copyright (c) 2013 Pedro Molina (http://mavatarsbyte.com)
 *  Dual licensed under the MIT (MIT-LICENSE.txt)
 *  and GPL (GPL-LICENSE.txt) licenses.
 *
 *  Built for jQuery library
 *  http://jquery.com
 *
 */
(function($) {

	$.fn.mavatarsUpload = function(options) {

		/* default configuration properties*/
		var defaults = {
			onSubmit: false,
			btnText: "Browse files...",
			url: "upload.php",
			data: null,
			multi: true,
			showFilename: true,
			showPercent: true,
			showErrorAlerts: true,
			allowedExtensions: "",
			invalidExtError: "Invalid File Type",
			maxSize: 0,
			sizeError: "Size of the file is greather than allowed",
			onFileError: function(file, error) {
			}
		};

		var options = $.extend(defaults, options);

		/*строки замены. просто в стандартной библиотеке очень коряво был html - хочется это несколько упорядочить*/
		var inputform = '<button class="button large special">%text%</button><div class="mavatarscontainer"></div>';
		var progressbar = '<div class="file"><div class="filename"></div><div class="mavatarsupload-progress"><div class="mavatarsupload-bar mavatarsupload-progressbar" style="width: 0%;"><span></span></div></div></div>'
		var alertmessage = '<div class="mavatarsupload-alert"><button type="button" class="close">&times;</button>%text%</div>'
		
		/*Main function*/
		var obj; /*объект маватара*/
		var fileinput; /*поле ввода*/
		var fileuploadcontainer; /*поле прогреессбаров*/
		var uploadedfiles;
		
		var file = new Object();

		this.each(function() {
			obj = $(this);
			fileinput = $(this).find('input[type=file]:first');
			
			fileinput.after(inputform.replace(/\%text\%/g, options.btnText));
			fileinput.hide();
			
			fileuploadcontainer = fileinput.next('button').next('.mavatarscontainer');	
			uploadedfiles = obj.find('.uploadedfiles');
			
			/*Event when clicked the newly created link*/
			fileinput.next('button').click(function() {
				fileinput.click();
				return false;
			});
			/*Event when user select a file*/
			fileinput.change(function() {
				file.name = fileinput.val().split('\\').pop();
				file.size = (fileinput[0].files[0].size / 1024) / 1024;
				if (validateresult() == true) {
					if (options.onSubmit == false) {
						UploadFile();
					}
					else {
						fileuploadcontainer.prepend('<br /><span class="filename">' + file.name + '</span>');
						fileinput.parent('form').bind('submit', function() {
							fileuploadcontainer.html('');
							UploadFile();
							fileinput.replaceWith(fileinput.val('').clone(true));
						});
					}
				}
				
			});
		
		/*	uploadedfiles.find('.uploadedfile').find("input[type=checkbox]").click(function() {
				$(this).removeAttr("checked");
				$(this).closest('.uploadedfile').hide();
				return false;
			});*/		
		});
		/*Function that uploads a file*/
		function UploadFile() {
			var error = true;
			var uploadobj;
			fileuploadcontainer.prepend(progressbar);
			
			uploadobj = fileuploadcontainer.find('.file:first');
			
			var formData = new FormData();
			formData.append(fileinput.attr('name'), fileinput[0].files[0]);
			formData.append('data', options.data);
			$.ajax({
				url: options.url,
				type: 'POST',
				data: formData,
			/*dataType: 'json',*/
				success: function(data) {
					var percent = 100;
					uploadobj.find('.mavatarsupload-progressbar:first').width(percent + '%');
					uploadobj.find('.mavatarsupload-progressbar:first span').text(percent + "%");
					var response = jQuery.parseJSON(data);
					if (typeof response == 'object') {
						data = response;
					} else {
						if (data == 1)	data = {success: "1"};
						else data = {success: "0", error: data};
					}
					if (data == 1 || data.success == 1) {
						options.multi == false && fileinput.attr('disabled', 'disabled');
					/*uploadobj.remove();*/
						var decoded = $('<textarea/>').html(data.form).val();
							uploadedfiles.append(decoded);
						}
					else {
						options.onFileError(file, data);
						uploadobj.remove();

						if (options.showErrorAlerts == true) {
							fileuploadcontainer.prepend(alertmessage.replace(/\%text\%/g, data.error));
							closenotification();
						}
						error = false;
					}
				},
				xhr: function() {  /* custom xhr*/
					myXhr = $.ajaxSettings.xhr();
					if (myXhr.upload) { /* check if upload property exists*/
						myXhr.upload.addEventListener('progress', progressHandlingFunction, false); /*for handling the progress of the upload*/
					}
					return myXhr;
				},
				cache: false,
				contentType: false,
				processData: false
			});
			return error;
		}
		/*Function that updates bars progress*/
		function progressHandlingFunction(e) {
			if (e.lengthComputable) {
				var total = e.total;
				var loaded = e.loaded;
				if (options.showFilename == true) {
					fileuploadcontainer.find('.file').first().find('.filename:first').text(file.name);
				}
				if (options.showPercent == true) {
					var percent = Number(((e.loaded * 100) / e.total).toFixed(2));
					fileuploadcontainer.find('.file').first().find('.mavatarsupload-progressbar:first').width(percent + '%');
				}
				fileuploadcontainer.find('.file').first().find('.mavatarsupload-progressbar:first span').text(percent + "%");
			}
		}
		/*Validate master*/
		function validateresult() {
			var canUpload = true;
			if (options.allowedExtensions != "") {
				var validationresult = validateExtension();
				if (validationresult == false) {
					canUpload = false;
					if (options.showErrorAlerts == true) {
						fileuploadcontainer.prepend(alertmessage.replace(/\%text\%/g, options.invalidExtError));
						closenotification();
					}
					options.onFileError(file, options.invalidExtError);
				}
				else {
					canUpload = true;
				}
			}
			if (options.maxSize > 0) {
				var validationresult = validateSize();
				if (validationresult == false) {
					canUpload = false;
					if (options.showErrorAlerts == true) {
						fileuploadcontainer.prepend(alertmessage.replace(/\%text\%/g, options.sizeError));
						closenotification();
					}
					options.onFileError(file, options.sizeError);
				}
				else {
					canUpload = true;
				}
			}
			return canUpload;
		};
		/*Validate extension of file*/
		function validateExtension() {
			var ext = fileinput.val().split('.').pop().toLowerCase();
			var allowed = options.allowedExtensions.split("|");
			if ($.inArray(ext, allowed) == -1) {
				return false;
			}
			else {
				return true;
			}
		};
		/*Validate Size of the file*/
		function validateSize() {
			if (file.size > options.maxSize) {
				return false;
			}
			else {
				return true;
			}
		};
		function closenotification() {
			fileuploadcontainer.find('mavatarsupload-alert').click(function() {
				$(this).remove();
			});
		};
	};

})(jQuery);