<!-- BEGIN: MAIN -->

<table class="cells table table-bordered">
	<!-- BEGIN: ORD_ROW -->
	<tr>
		<td>{ORD_ROW_ID}</td>
		<td>{ORD_ROW_DESC}</td>
		<td style="text-align: right;">{ORD_ROW_SUMM|number_format($this, '2', '.', ' ')} {PHP.L.valuta}</td>
		<td><a href="{ORD_ROW_USER_DETAILSLINK}">{ORD_ROW_USER_NAME}</a></td>
		<td>{ORD_ROW_CDATE|cot_date('d.m.Y', $this)}</td>
		<td><!-- IF {ORD_ROW_PDATE} > 0 -->{ORD_ROW_PDATE|cot_date('d.m.Y', $this)}<!-- ELSE -->&mdash;<!-- ENDIF --></td>
		<td>{ORD_ROW_STATUS}</td>
		<td><a href="{ORD_ROW_ID|cot_url('admin', 'm=other&p=payorders&a=delete&id='$this)}">{PHP.L.Delete}</a></td>
	</tr>
	<!-- END: ORD_ROW -->
</table>

<h3>{PHP.L.payorders_neworder_title}:</h3>
{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
<form action="{ORD_FORM_ACTION_URL}" method="POST">
	<table class="cells table-condensed">
		<tr>
			<td width="100">{PHP.L.Username}:</td>
			<td><input type="text" name="username" value="{PHP.username}" /></td>
		</tr>
		<tr>
			<td>{PHP.L.payments_desc}:</td>
			<td>{ORD_FORM_DESC}</td>
		</tr>
		<tr>
			<td>{PHP.L.payments_summ}:</td>
			<td>{ORD_FORM_SUMM} {PHP.cfg.payments.valuta}</td>
		</tr>
		<tr>
			<td></td>
			<td><button>{PHP.L.Add}</button></td>
		</tr>
	</table>
</form>

<!-- END: MAIN -->