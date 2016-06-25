<!-- BEGIN: MAIN -->
<script src="{PHP.cfg.plugins_dir}/usercategories/js/usercategories.admin.config.js" type="text/javascript"></script>	
<div id="areagenerator" style="display:none">
	<table class="cells">
		<tr>
			<td class="coltop width20">{PHP.L.usercategories_admin_config_groupid}</td>
			<td class="coltop">{PHP.L.usercategories_admin_config_limit1}</td>
			<td class="coltop">{PHP.L.usercategories_admin_config_limit2}</td>
			<td class="coltop">&nbsp;</td>
		</tr>
		<!-- BEGIN: ADDITIONAL -->
		<tr class="area">
			<td>{ADDGROUP}</td>
			<td>{ADDLIMIT1}</td>
			<td>{ADDLIMIT2}</td>
			<td><a href="#" class="deloption negative button"><span class="trash icon"></span>{PHP.L.Delete}</a></td>
		</tr>
		<!-- END: ADDITIONAL -->
		<tr id="addtr">
			<td class="valid" colspan="8"><button name="addoption" id="addoption" class="btn btn-default" type="button">{PHP.L.Add}</button></td>
		</tr>
	</table>
</div>

<!-- END: MAIN -->