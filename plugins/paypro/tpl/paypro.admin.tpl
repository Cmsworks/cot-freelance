<!-- BEGIN: MAIN -->
<div class="block">	

	<table class="cells">
		<!-- BEGIN: PRO_ROW -->
		<tr>
			<td><a href="{PRO_ROW_USER_DETAILSLINK}">{PRO_ROW_USER_NAME}</a></td>
			<td>{PRO_ROW_EXPIRE|cot_date('d.m.Y', $this)}</td>
			<td><a href="{PRO_ROW_USER_ID|cot_url('admin', 'm=other&p=paypro&a=delete&id='$this)}">{PHP.L.Delete}</a></td>
		</tr>
		<!-- END: PRO_ROW -->
	</table>
</div>

<div class="block">	
	<h3>{PHP.L.paypro_addproacc}:</h3>
	{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
	<form action="{PRO_FORM_ACTION_URL}" method="POST" class="form-horizontal">
		{PHP.L.Username}: {PRO_FORM_SELECTUSER} {PRO_FORM_PERIOD} {PHP.L.paypro_month}
		<button class="btn btn-success">{PHP.L.Add}</button>
	</form>
</div>

<!-- END: MAIN -->