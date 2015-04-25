<!-- BEGIN: MAIN -->
<div class="mavatar_uploadform">
	<div class="uploadedfiles rows">
	<!-- BEGIN: FILES -->	
		<!-- BEGIN: ROW -->
		<div class="uploadedfile col-md-3 marginbottom10">	

			<div class="img text-center">
				<a href="{MAVATAR.FILE}" target="_blank"  class="fancybox" rel="gallery1"><img src="{MAVATAR|cot_mav_thumb($this, 255, 191, auto)}" alt="{MAVATAR.FILENAME}.{MAVATAR.FILEEXT}" title="{MAVATAR.FILENAME}.{MAVATAR.FILEEXT}" class="img-thumbnail" /></a>
			</div>
			<div class="des">
				<div class="inp">{FILEDESCTEXT|cot_rc_modify('$this', 'class="form-control"')}{FILENEW}</div> 
			</div>			
			<div class="order input-group">
				<span class="input-group-addon">
		        	Порядок
		    	</span>
		    	{FILEORDER|cot_rc_modify('$this', 'class="form-control"')}
				<span class="input-group-addon">
		        	 Доступна {ENABLED}
		    	</span>		    	
			</div>			

		</div>
		<!-- END: ROW -->	
	<!-- END: FILES -->
	</div>
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
			  debug: false // debug mode
			, staticPath: '{PHP.cfg.plugins_dir}/mavatars/lib/FileAPI/' // path to *.swf
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
				maxSize: FileAPI.MB*10, // max file size
				imageTransform: {
					// resize by max side
					maxWidth: 1200,
					maxHeight: 1200
				},
				onFileComplete: function (evt, uiEvt){
					var file = uiEvt.file;
					var data = uiEvt.result;
					if (data == 1 || data.success == 1) {
					//	uploadobj.remove();
						var decoded = $('<textarea/>').html(data.form).val();
							$('.uploadedfiles').append(decoded);
						}
					else {
						$(this).prepend(alertmessage.replace(/\%text\%/g, data.error));
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