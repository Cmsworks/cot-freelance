<!-- BEGIN: MAIN -->

<h2>{PHP.L.payments_history}</h2>	

<div class="block button-toolbar well">
	<div class="pull-right">
		<a href="{PHP|cot_url('admin', 'm=payments')}" class="button btn<!-- IF !{PHP.p} --> btn-success special<!-- ENDIF -->">{PHP.L.payments_allusers}</a>
		<a href="{PHP|cot_url('admin', 'm=payments&p=payouts')}" class="button btn<!-- IF {PHP.p} == 'payouts' --> btn-success special<!-- ENDIF -->">{PHP.L.payments_payouts}</a>
		<a href="{PHP|cot_url('admin', 'm=payments&p=transfers')}" class="button btn<!-- IF {PHP.p} == 'transfers' --> btn-success special<!-- ENDIF -->">{PHP.L.payments_transfers}</a>
	</div>
	<form action="{PHP.p|cot_url('admin', 'm=payments&p='$this)}" method="post" class="form-inline">
		<div class="form-group">
			<input type="text" class="form-control" name="sq" value="{PHP.sq}">
			<button type="submit" class="btn btn-default">{PHP.L.Search}</button>
		</div>
	</form>
</div>

<!-- BEGIN: PAYMENTS -->

<div class="block button-toolbar well">
	<!-- IF {PHP.cfg.payments.balance_enabled} -->
	<p><b>{PHP.L.payments_siteinvoices}:</b> {PHP.L.payments_debet}: {INBALANCE} {PHP.cfg.payments.valuta} | {PHP.L.payments_credit}: {OUTBALANCE} {PHP.cfg.payments.valuta} | {PHP.L.payments_balance}: {BALANCE} {PHP.cfg.payments.valuta}</p>
	<!-- ENDIF -->
	<p><b>{PHP.L.payments_allpayments}:</b> {CREDIT} {PHP.cfg.payments.valuta}</p>
</div>

<div class="block">
	<table class="cells table table-bordered table-striped">
	<thead>
	<tr>
		<th class="coltop">#</th>
		<th class="coltop">{PHP.L.User}</th>
		<th class="coltop">{PHP.L.Date}</th>
		<th class="coltop"></th>
		<th class="coltop">{PHP.L.payments_summ}</th>
		<th class="coltop">{PHP.L.payments_desc}</th>
		<th class="coltop">{PHP.L.payments_area}</th>
		<th class="coltop">{PHP.L.payments_code}</th>
		<th class="coltop">{PHP.L.Status}</th>
	</tr>
	</thead>
	<tbody>
	<!-- BEGIN: PAY_ROW -->
	<tr>
		<td>{PAY_ROW_ID}</td>
		<td><a href="{PAY_ROW_USER_ID|cot_url('admin', 'm=payments&id='$this)}">{PAY_ROW_USER_NICKNAME}</a></td>
		<td>{PAY_ROW_ADATE|date('d.m.Y H:i',$this)}</td>
		<td class="centerall"><!-- IF {PAY_ROW_AREA} == 'balance' -->+<!-- ELSE -->-<!-- ENDIF --></td>
		<td style="text-align: right;">{PAY_ROW_SUMM|number_format($this, 2, '.', ' ')}</td>
		<td>{PAY_ROW_DESC}</td>
		<td>{PAY_ROW_AREA}</td>
		<td>{PAY_ROW_CODE}</td>
		<td>{PAY_ROW_STATUS}</td>
	</tr>
	<!-- END: PAY_ROW -->
	</tbody>
	</table>
	
	<div class="pagination"><ul>{PAGENAV_PREV}{PAGENAV_PAGES}{PAGENAV_NEXT}</ul></div>	
</div>
	
<!-- END: PAYMENTS -->

<!-- BEGIN: PAYOUTS -->
<table class="cells table table-bordered table-striped">
<thead>
	<tr>
		<th class="span2">{PHP.L.User}</th>
		<th class="span2">{PHP.L.payments_summ}</th>
		<th>{PHP.L.Description}</th>
		<th>{PHP.L.Date}</th>
		<th>{PHP.L.Status}</th>
		<th>{PHP.L.Action}</th>
	</tr>
</thead>	
<!-- BEGIN: PAYOUT_ROW -->
	<tr>
		<td>{PAYOUT_ROW_USER_NAME}</td>
		<td>{PAYOUT_ROW_SUMM}</td>
		<td>{PAYOUT_ROW_DETAILS}</td>
		<td><!-- IF {PAYOUT_ROW_DATE} > 0 -->{PAYOUT_ROW_DATE|cot_date('d.m.Y H:i',$this)}<!-- ELSE -->&mdash;<!-- ENDIF --></td>
		<td>{PAYOUT_ROW_LOCALSTATUS}</td>
		<td>
			<!-- IF {PAYOUT_ROW_STATUS} == 'process' -->
			<a href="{PAYOUT_ROW_DONE_URL}">{PHP.L.Confirm}</a> 
			<a href="{PAYOUT_ROW_CANCEL_URL}">{PHP.L.Cancel}</a>
			<!-- ENDIF -->
		</td>
	</tr>
<!-- END: PAYOUT_ROW -->
</table>
<!-- END: PAYOUTS -->

<!-- BEGIN: TRANSFERS -->
<table class="cells table table-bordered table-striped">
<thead>
	<tr>
		<th class="span2">{PHP.L.payments_balance_transfers_from}</th>
		<th class="span2">{PHP.L.payments_balance_transfers_for}</th>
		<th class="span2">{PHP.L.payments_summ}</th>
		<th>{PHP.L.Description}</th>
		<th>{PHP.L.Date}</th>
		<th>{PHP.L.Done}</th>
		<th>{PHP.L.Status}</th>
		<th>{PHP.L.Action}</th>
	</tr>
</thead>	
<!-- BEGIN: TRANSFER_ROW -->
	<tr>
		<td><a href="{TRANSFER_ROW_FROM_DETAILSLINK}">{TRANSFER_ROW_FROM_FULL_NAME}</a></td>
		<td><a href="{TRANSFER_ROW_FOR_DETAILSLINK}">{TRANSFER_ROW_FOR_FULL_NAME}</a></td>
		<td>{TRANSFER_ROW_SUMM}</td>
		<td>{TRANSFER_ROW_COMMENT}</td>
		<td>{TRANSFER_ROW_DATE|cot_date('d.m.Y H:i',$this)}</td>
		<td><!-- IF {TRANSFER_ROW_DONE} > 0 -->{TRANSFER_ROW_DONE|cot_date('d.m.Y H:i',$this)}<!-- ELSE -->&mdash;<!-- ENDIF --></td>
		<td>{TRANSFER_ROW_LOCALSTATUS}</td>
		<td>
			<!-- IF {TRANSFER_ROW_STATUS} == 'process' -->
			<a href="{TRANSFER_ROW_DONE_URL}">{PHP.L.Confirm}</a>
			<a href="{TRANSFER_ROW_CANCEL_URL}">{PHP.L.Cancel}</a>
			<!-- ENDIF -->
		</td>
	</tr>
<!-- END: TRANSFER_ROW -->
</table>
<!-- END: TRANSFERS -->
			
<!-- END: MAIN -->