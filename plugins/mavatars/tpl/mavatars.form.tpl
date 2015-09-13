<!-- BEGIN: MAIN -->
<div class="mavatar_uploadform">
	<div class="uploadedfiles">
	<!-- BEGIN: FILES -->	
		<!-- BEGIN: ROW -->
		<div class="uploadedfile media">	
			<div class="pull-left">{MAVATAR.ORDER}</div>
			<div class="pull-right">				
		    	{FILEORDER|cot_rc_modify('$this', 'class="form-control"')}
			</div>
			<!-- IF {MAVATAR.FILEEXT} == 'png' OR {MAVATAR.FILEEXT} == 'jpg' OR {MAVATAR.FILEEXT} == 'gif' OR {MAVATAR.FILEEXT} == 'bmp' -->
			<div class="pull-left">
				<a href="{MAVATAR.FILE}" target="_blank" class="fancybox" rel="gallery1"><img src="{MAVATAR|cot_mav_thumb($this, 100, 100, auto)}" alt="{MAVATAR.FILENAME}.{MAVATAR.FILEEXT}" title="{MAVATAR.FILENAME}.{MAVATAR.FILEEXT}" class="img-thumbnail" /></a>
			</div>
			<div class="media-body">
				<div class="inp">{FILEDESCTEXT|cot_rc_modify('$this', 'class="form-control"')}{FILENEW}</div>
				<label class="checkbox">{DELETE} {PHP.L.Delete}</label>	    	
			</div>	
			<!-- ELSE -->
			<div class="media-body">
				<a href="{MAVATAR.FILE}" target="_blank" rel="gallery1">{MAVATAR.DESC}.{MAVATAR.FILEEXT}</a>
				<div class="inp">{FILEDESCTEXT|cot_rc_modify('$this', 'class="form-control"')}{FILENEW}</div>
				<label class="checkbox">{DELETE} {PHP.L.Delete}</label>	 
			</div>
			<!-- ENDIF -->		
		</div>
		<!-- END: ROW -->	
	<!-- END: FILES -->
	</div>
	<br/>
	<div class="clearfix"></div>

	<!-- BEGIN: UPLOAD -->
	{PHP.L.mavatar_form_addfiles}
	<!-- FOR {INDEX} IN {PHP.cfg.plugin.mavatars.items|range(1,$this)} -->
	<div>{FILEUPLOAD_INPUT}</div>
	<!-- ENDFOR -->
	<!-- END: UPLOAD -->
	
	<!-- BEGIN: AJAXUPLOAD -->

 
	<script>
		window.FileAPI = {
			  debug: false
			, staticPath: '{PHP.cfg.plugins_dir}/mavatars/lib/FileAPI/' /* path to *.swf*/
		};
	</script>	
	
	<script src="{PHP.cfg.plugins_dir}/mavatars/lib/FileAPI/FileAPI.min.js"></script>
	<script src="{PHP.cfg.plugins_dir}/mavatars/lib/FileAPI/FileAPI.exif.js"></script>
	<script src="{PHP.cfg.plugins_dir}/mavatars/lib/jquery.fileapi.min.js"></script>
	
	<div id="uploader">
		<div class="js-fileapi-wrapper">
			<input type="file"  tabindex="-1" hidefocus="true" id="mavatar_file" name="mavatar_file[]" />
		</div>
		<div data-fileapi="active.show" class="progress">
			<div data-fileapi="progress" class="progress__bar"></div>
		</div>
	</div>
	<script>
		jQuery(function ($){
			$('#uploader').fileapi({
				url: '{FILEUPLOAD_URL}',
				autoUpload: true,
			//	accept: 'image/*',
				multiple: true,
				maxSize: FileAPI.KB*{MAXFILESIZE}, // max file size
				imageTransform: {
					// resize by max side
					maxWidth: 1600,
					maxHeight: 1600
				},
				onSelect: function (evt, data){
					data.all; // All files
			        data.files; // Correct files
			        if( data.other.length ){
			            // errors
			            var errors = data.other[0].errors;
			            if( errors ){
			                errors.maxSize; // File size exceeds the maximum size `@see maxSize`
			                errors.maxFiles; // Number of files selected exceeds the maximum `@see maxFiles`
			                errors.minWidth; // Width of the image is smaller than the specified `@see imageSize`
			                errors.minHeight;
			                errors.maxWidth; // Width of the image greater than the specified `@see imageSize`
			                errors.maxHeight;
			                
			                $('.uploadedfiles').append('<div class="alert alert-danger alert-dismissible" role="alert">'+
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							'{PHP.L.mavatar_wrongfile}</div>');
			            }
			        }
				},
				onBeforeUpload: function (evt, uiEvt){
					console.log(evt, uiEvt);
				},
				onFileComplete: function (evt, uiEvt){
					console.log(evt);
					var file = uiEvt.file;
					var data = uiEvt.result;
					console.log(data);
					if (data.id) {
					//	uploadobj.remove();
						var decoded = $('<textarea/>').html(data.form).val();
							$('.uploadedfiles').append(decoded);
					} else {
						$('.uploadedfiles').append('<div class="alert alert-danger alert-dismissible" role="alert">'+
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							'{PHP.L.mavatar_wrongfile}</div>');
					}
				}
			});
		});
	</script>
	
	<!-- END: AJAXUPLOAD -->
	
	<!-- BEGIN: CURLUPLOAD -->
	{PHP.L.mavatar_form_addcurl}
	<!-- FOR {INDEX} IN {PHP.cfg.plugin.mavatars.items|range(1,$this)} -->
	<div>{CURLUPLOAD_INPUT}</div>
	<!-- ENDFOR -->	
	<!-- END: CURLUPLOAD -->
</div>

<!-- END: MAIN -->