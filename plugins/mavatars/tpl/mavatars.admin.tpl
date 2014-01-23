<!-- BEGIN: MAIN -->
<script src="{PHP.cfg.plugins_dir}/mavatars/js/mavatars.admin.js" type="text/javascript"></script>	
<div id="catgenerator" style="display:none">
	<table class="cells">
		<tr>
			<td class="coltop width10">{PHP.L.Extension}</td>
			<td class="coltop width20">{PHP.L.Category}</td>
			<td class="coltop width20">{PHP.L.Path}</td>
			<td class="coltop width15">{PHP.L.mav_thumbpath}</td>
			<td class="coltop width5">{PHP.L.mav_req}</td>
			<td class="coltop width15">{PHP.L.mav_fileext}</td>
			<td class="coltop width10">{PHP.L.mav_size}</td>
			<td class="coltop width5">&nbsp;</td>
		</tr>
		<!-- BEGIN: ADDITIONAL -->
		<tr class="newscat">
			<td><input type="text" class="text ca_ext" name="ca_ext" value="{ADDMODULE}" size="32" maxlength="255" /></td>
			<td><input type="text" class="text ca_cat" name="ca_cat" value="{ADDCATEGORY}" size="3" maxlength="255" /></td>
			<td><input type="text" class="text ca_path" name="ca_path" value="{ADDPATH}" size="4" maxlength="255" /></td>
			<td><input type="text" class="text ca_thumb" name="ca_thumb" value="{ADDTHUMBPATH}" size="4" maxlength="255" /></td>
			<td><input type="checkbox" class="ca_req" name="ca_req" value="{ADDREQ}" <!-- IF {ADDREQ} -->checked="checked"<!-- ENDIF --> /></td>
			<td><input type="text" class="text ca_fileext" name="ca_ext" value="{ADDEXT}" size="4" maxlength="255" /></td>
			<td><input type="text" class="text ca_size" name="ca_size" value="{ADDMAX}" size="4" maxlength="255" /></td>
			<td><a href="#" class="deloption negative button trash icon" style="display:none">{PHP.L.Delete}</a></td>
		</tr>
		<!-- END: ADDITIONAL -->
		<tr id="addtr">
			<td class="valid" colspan="8"><button name="addoption" id="addoption" type="button">{PHP.L.Add}</button></td>
		</tr>
	</table>
</div>

<!-- END: MAIN -->