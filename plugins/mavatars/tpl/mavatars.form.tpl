<!-- BEGIN: MAIN -->
<div class="mavatar_uploadform">
	<div class="uploadedfiles">
	<!-- BEGIN: FILES -->	
		<!-- BEGIN: ROW -->
		<div class="uploadedfile">{ENABLED}#{FILEORDER} <a href="{FILE}">{FILEORIGNAME}.{FILEEXT}</a> {PHP.L.Desc}{FILEDESC}{FILENEW}</div>
		<!-- END: ROW -->	
	<!-- END: FILES -->
	</div>

	<!-- BEGIN: UPLOAD -->
	{PHP.L.mavatar_form_addfiles}
	<!-- FOR {INDEX} IN {PHP.cfg.plugin.mavatars.items|range(1,$this)} -->
	<div>{FILEUPLOAD_INPUT}</div>
	<!-- ENDFOR -->
	<!-- END: UPLOAD -->
	
	<!-- BEGIN: AJAXUPLOAD -->
	
	<script type="text/javascript" src="{PHP.cfg.plugins_dir}/mavatars/js/mavatars.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('head').append('<link href="{PHP.cfg.plugins_dir}/mavatars/css/mavatars.css" type="text/css" rel="stylesheet" />');
			$(".mavatar_uploadform").mavatarsUpload({ url:'{FILEUPLOAD_URL}', 
				btnText:'{PHP.L.mavatar_form_addfiles}'
			});
		});
	</script>
	<div><input type="file" value="" id="mavatar_file" name="mavatar_file"></div>
	<!-- END: AJAXUPLOAD -->
	
	<!-- BEGIN: CURLUPLOAD -->
	{PHP.L.mavatar_form_addcurl}
	<!-- FOR {INDEX} IN {PHP.cfg.plugin.mavatars.items|range(1,$this)} -->
	<div>{CURLUPLOAD_INPUT}</div>
	<!-- ENDFOR -->	
	<!-- END: CURLUPLOAD -->
</div>

<!-- END: MAIN -->