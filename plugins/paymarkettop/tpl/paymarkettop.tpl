<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PHP.L.paymarkettop_buy_title}</div>

{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
<div class="customform">
	<form action="{PAY_FORM_ACTION}" method="post">
		<table class="table-condensed">
			<tr>
				<td width="220">{PHP.L.paymarkettop_costofday}:</td>
				<td>{PAY_FORM_COST} {PHP.cfg.plugin.paymarkettop.cost} {PHP.cfg.payments.valuta}</td>
			</tr>
			<tr>
				<td>{PHP.L.paymarkettop_error_days}:</td>
				<td>{PAY_FORM_PERIOD} {PHP.L.paymarkettop_day}</td>
			</tr>
			<tr>
				<td></td>
				<td><button class="btn btn-success">{PHP.L.paymarkettop_buy}</button></td>
			</tr>
		</table>
	</form>
</div>

<!-- END: MAIN -->