<!-- BEGIN: MAIN -->
<div class="block">	

	<table class="cells">
		<!-- BEGIN: TOP_ROW -->
		<tr>
			<td><a href="{TOP_ROW_USER_DETAILSLINK}">{TOP_ROW_USER_NAME}</a></td>
			<td>{TOP_ROW_AREA}</td>
			<td>{TOP_ROW_EXPIRE|cot_date('d.m.Y', $this)}</td>
			<td><a href="{TOP_ROW_SERVICE_ID|cot_url('admin', 'm=other&p=paytop&a=delete&id='$this)}">{PHP.L.Delete}</a></td>
		</tr>
		<!-- END: TOP_ROW -->
	</table>
</div>	

<div class="block">	
	<h3>{PHP.L.paytop_addtopaccaunt}:</h3>
	{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
	<form action="{TOP_FORM_ACTION_URL}" method="POST">
		{PHP.L.Username}: <input type="text" name="username" value="" /> 
		{PHP.L.paytop_area}: {TOP_FORM_AREA} 
		{PHP.L.paytop_period} {TOP_FORM_PERIOD} {TOP_FORM_PERIOD_NAME}
		<button class="btn">{PHP.L.Add}</button>
	</form>

</div>

<!-- END: MAIN -->