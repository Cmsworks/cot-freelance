<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PHP.L.paytop_buytop_title} "{TOP_FORM_AREA_NAME}"</div>

<div class="row">
	<div class="span9">
		{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
		<form action="{TOP_FORM_ACTION}" method="post">
			<table class="table">
				<tr>
					<td width="220">{PHP.L.paytop_cost}:</td>
					<td>{TOP_FORM_COST} {PHP.cfg.payments.valuta}</td>
				</tr>
				<tr>
					<td></td>
					<td><button class="btn btn-success">{PHP.L.paytop_buy}</button></td>
				</tr>
			</table>
		</form>
	</div>
</div>

<!-- END: MAIN -->