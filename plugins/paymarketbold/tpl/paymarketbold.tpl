<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PHP.L.paymarketbold_buy_title}</div>

{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
<div class="customform">
	<form action="{PAY_FORM_ACTION}" method="post">
		<table class="table-condensed">
			<tr>
				<td width="220">{PHP.L.paymarketbold_costofday}:</td>
				<td>{PAY_FORM_COST} {PHP.cfg.plugin.paymarketbold.cost} {PHP.cfg.payments.valuta}</td>
			</tr>
			<tr>
				<td>{PHP.L.paymarketbold_error_days}:</td>
				<td>{PAY_FORM_PERIOD} {PHP.L.paymarketbold_day}</td>
			</tr>
			<tr>
				<td></td>
				<td><button class="btn btn-success">{PHP.L.paymarketbold_buy}</button></td>
			</tr>
		</table>
	</form>
</div>

<!-- END: MAIN -->