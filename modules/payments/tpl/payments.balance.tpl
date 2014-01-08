<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PHP.L.payments_mybalance}</div>

<div class="row">
	<div class="span9">
		
		<!-- IF {PHP.cfg.payments.balance_enabled} -->
		<h4>{PHP.L.payments_balance}: {BALANCE_SUMM|number_format($this, '2', '.', ' ')} {PHP.cfg.payments.valuta}</h4>
		<!-- ENDIF -->
		
		<br/>
		<br/>
		<ul class="nav nav-tabs">
			<li<!-- IF {PHP.n} == 'history' --> class="active"<!-- ENDIF -->><a href="{BALANCE_HISTORY_URL}">{PHP.L.payments_history}</a></li>
			<!-- IF {PHP.cfg.payments.balance_enabled} -->
			<li<!-- IF {PHP.n} == 'billing' --> class="active"<!-- ENDIF -->><a href="{BALANCE_BILLING_URL}">{PHP.L.payments_paytobalance}</a></li>
			<li<!-- IF {PHP.n} == 'payout' --> class="active"<!-- ENDIF -->><a href="{BALANCE_PAYOUT_URL}">{PHP.L.payments_payout}</a></li>
			<li<!-- IF {PHP.n} == 'transfer' --> class="active"<!-- ENDIF -->><a href="{BALANCE_TRANSFER_URL}">{PHP.L.payments_transfer}</a></li>
			<!-- ENDIF -->
		</ul>		
		
		<!-- BEGIN: BILLINGFORM -->
		<h5>{PHP.L.payments_balance_billing_desc}</h5>
		{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
		<form action="{BALANCE_FORM_ACTION_URL}" method="post">
			<p>{PHP.L.payments_balance_billing_summ}: <input type="text" name="summ" size="5" value="{BALANCE_FORM_SUMM}"/> {PHP.cfg.payments.valuta}</p>
			<p><button class="btn btn-success">{PHP.L.payments_paytobalance}</button></p>
		</form>
		<!-- END: BILLINGFORM -->
		
		<!-- BEGIN: PAYOUTFORM -->
		
		<!-- BEGIN: PAYOUTS -->
		<h5>{PHP.L.payments_balance_payout_list}</h5>
		<table class="table">
			<!-- BEGIN: PAYOUT_ROW -->
			<tr>
				<td>{PAYOUT_ROW_ID}</td>
				<td>{PAYOUT_ROW_CDATE|cot_date('d.m.Y H:i', $this)}</td>
				<td style="text-align: right;">{PAYOUT_ROW_SUMM|number_format($this, '2', '.', ' ')} {PHP.cfg.payments.valuta}</td>
				<td><!-- IF {PAYOUT_ROW_DATE} > 0 -->{PAYOUT_ROW_DATE|cot_date('d.m.Y H:i', $this)}<!-- ELSE -->{PHP.L.No}<!-- ENDIF --></td>
			</tr>
			<!-- END: PAYOUT_ROW -->
		</table>
		<!-- END: PAYOUTS -->
		
		<h5>{PHP.L.payments_balance_payout_title}</h5>
		{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
		<form action="{PAYOUT_FORM_ACTION_URL}" method="post">
			<table class="customform">
				<tr>
					<td class="width30">{PHP.L.payments_balance_payout_details}:</td>
					<td><textarea name="details" rows="5" cols="40">{PAYOUT_FORM_DETAILS}</textarea></td>
				</tr>
				<tr>
					<td class="width30">{PHP.L.payments_balance_payout_summ}:</td>
					<td><input type="text" name="summ" size="5" value="{PAYOUT_FORM_SUMM}"/> {PHP.cfg.payments.valuta}</td>
				</tr>
				<tr>
					<td class="width30"></td>
					<td><button class="btn btn-success">{PHP.L.Submit}</button></td>
				</tr>
			</table>
		</form>
		<!-- END: PAYOUTFORM -->
		
		<!-- BEGIN: TRANSFERFORM -->	
		<h5>{PHP.L.payments_transfer}</h5>
		{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
		<form action="{TRANSFER_FORM_ACTION_URL}" method="post">
			<table class="customform">
				<tr>
					<td class="width30">{PHP.L.payments_balance_transfer_comment}:</td>
					<td><textarea name="comment" rows="5" cols="40">{TRANSFER_FORM_COMMENT}</textarea></td>
				</tr>
				<tr>
					<td class="width30">{PHP.L.payments_balance_transfer_summ}:</td>
					<td><input type="text" name="summ" size="5" value="{TRANSFER_FORM_SUMM}"/> {PHP.cfg.payments.valuta}</td>
				</tr>
				<tr>
					<td class="width30">{PHP.L.payments_balance_transfer_username}:</td>
					<td><input type="text" name="username" value="{TRANSFER_FORM_USERNAME}"/></td>
				</tr>
				<tr>
					<td class="width30"></td>
					<td><button class="btn btn-success">{PHP.L.Submit}</button></td>
				</tr>
			</table>
		</form>
		<!-- END: TRANSFERFORM -->
		
		<!-- BEGIN: HISTORY -->
		<h5>{PHP.L.payments_history}</h5>
		<table class="table">
			<!-- BEGIN: HIST_ROW -->
			<tr>
				<td>{HIST_ROW_ID}</td>
				<td><!-- IF {HIST_ROW_AREA} == 'balance' -->+<!-- ELSE -->-<!-- ENDIF --></td>
				<td>{HIST_ROW_PDATE|cot_date('d.m.Y H:i', $this)}</td>
				<td>{HIST_ROW_DESC}</td>
				<td style="text-align: right;">{HIST_ROW_SUMM|number_format($this, '2', '.', ' ')} {PHP.cfg.payments.valuta}</td>
			</tr>
			<!-- END: HIST_ROW -->
		</table>
		<!-- END: HISTORY -->
		
	</div>
	<div class="span3">
		
	</div>
</div>

<!-- END: MAIN -->