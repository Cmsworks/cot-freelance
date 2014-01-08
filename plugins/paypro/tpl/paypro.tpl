<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PHP.L.paypro_buypro_title}</div>

<div class="row">
	<div class="span9">
		{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
		<form action="{PRO_FORM_ACTION}" method="post">
			<table class="table">
				<tr>
					<td width="220">{PHP.L.paypro_costofmonth}:</td>
					<td>{PRO_FORM_COST} {PHP.cfg.plugin.paypro.cost} {PHP.cfg.payments.valuta}</td>
				</tr>
				<tr>
					<td>{PHP.L.paypro_error_months}:</td>
					<td>{PRO_FORM_PERIOD} {PHP.L.paypro_month}</td>
				</tr>
				<!-- IF {PRO_FORM_USER_NAME} -->
				<tr>
					<td>{PHP.L.paypro_giftfor}:</td>
					<td>{PRO_FORM_USER_NAME}</td>
				</tr>
				<!-- ENDIF -->
				<tr>
					<td></td>
					<td><button class="btn btn-success">{PHP.L.paypro_buy}</button></td>
				</tr>
			</table>
		</form>
	</div>
</div>

<!-- END: MAIN -->