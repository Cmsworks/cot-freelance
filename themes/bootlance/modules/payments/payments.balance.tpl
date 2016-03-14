<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PHP.L.payments_mybalance}</div>
		
<!-- IF {PHP.cfg.payments.balance_enabled} -->
<h4>{PHP.L.payments_balance}: {BALANCE_SUMM|number_format($this, '2', '.', ' ')} {PHP.cfg.payments.valuta}</h4>
<!-- ENDIF -->

<br/>
<br/>
<ul class="nav nav-tabs">
	<li<!-- IF {PHP.n} == 'history' --> class="active"<!-- ENDIF -->><a href="{BALANCE_HISTORY_URL}">{PHP.L.payments_history}</a></li>
	<!-- IF {PHP.cfg.payments.balance_enabled} -->
	<li<!-- IF {PHP.n} == 'billing' --> class="active"<!-- ENDIF -->><a href="{BALANCE_BILLING_URL}">{PHP.L.payments_paytobalance}</a></li>
	<!-- IF {PHP.cfg.payments.payouts_enabled} -->
	<li<!-- IF {PHP.n} == 'payouts' --> class="active"<!-- ENDIF -->><a href="{BALANCE_PAYOUT_URL}">{PHP.L.payments_payouts}</a></li>
	<!-- ENDIF -->
	<!-- IF {PHP.cfg.payments.transfers_enabled} -->
	<li<!-- IF {PHP.n} == 'transfers' --> class="active"<!-- ENDIF -->><a href="{BALANCE_TRANSFER_URL}">{PHP.L.payments_transfer}</a></li>
	<!-- ENDIF -->
	<!-- ENDIF -->
</ul>		
<div class="tab-content">

	<!-- BEGIN: BILLINGFORM -->
	<h5>{PHP.L.payments_balance_billing_desc}</h5>
	{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
	<form action="{BALANCE_FORM_ACTION_URL}" method="post" class="form-horizontal">
		<div class="control-group">
			<label class="control-label">{PHP.L.payments_balance_billing_summ}:</label>
			<div class="controls">
				<div class="input-group">
			        {BALANCE_FORM_SUMM}
			        <span class="input-group-addon">{PHP.cfg.payments.valuta}</span>
		        </div>
	        </div>
		</div>
		<div class="control-group">
			<label class="control-label"></label>
			<div class="controls"><button class="btn btn-success">{PHP.L.payments_paytobalance}</button></div>
		</div>
	</form>
	<!-- END: BILLINGFORM -->

	<!-- BEGIN: PAYOUTS -->
	<a class="pull-right btn btn-success" href="{PHP|cot_url('payments', 'm=balance&n=payouts&a=add')}">{PHP.L.payments_balance_payouts_button}</a>
	<h5>{PHP.L.payments_balance_payout_list}</h5>
	<!-- IF {PHP.payouts|count($this)} > 0 -->
	<table class="table table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th class="text-right">{PHP.L.payments_summ}</th>
				<th class="text-right">{PHP.L.Date}</th>
				<th class="text-right">{PHP.L.Done}</th>
				<th class="text-right">{PHP.L.Status}</th>
			</tr>
		</thead>
		<!-- BEGIN: PAYOUT_ROW -->
		<tr>
			<td>{PAYOUT_ROW_ID}</td>
			<td class="text-right">{PAYOUT_ROW_SUMM|number_format($this, '2', '.', ' ')} {PHP.cfg.payments.valuta}</td>
			<td class="text-right">{PAYOUT_ROW_CDATE|cot_date('d.m.Y H:i', $this)}</td>
			<td class="text-right"><!-- IF {PAYOUT_ROW_DATE} > 0 -->{PAYOUT_ROW_DATE|cot_date('d.m.Y H:i', $this)}<!-- ELSE -->{PHP.L.No}<!-- ENDIF --></td>
			<td class="text-right">{PAYOUT_ROW_LOCALSTATUS}</td>
		</tr>
		<!-- END: PAYOUT_ROW -->
	</table>
	<!-- ELSE -->
	<div class="alert alert-info">{PHP.L.payments_history_empty}</div>
	<!-- ENDIF -->
	<!-- END: PAYOUTS -->

	<!-- BEGIN: PAYOUTFORM -->
	<h5>{PHP.L.payments_balance_payout_title}</h5>
	{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
	<form action="{PAYOUT_FORM_ACTION_URL}" method="post" id="payoutform" class="form-horizontal">
		<div class="control-group">
			<label class="control-label">{PHP.L.payments_balance_payout_details}:</label>
			<div class="controls">{PAYOUT_FORM_DETAILS|cot_rc_modify($this, 'class="span4"')}</div>
		</div>
		<div class="control-group">
			<label class="control-label">{PHP.L.payments_balance_payout_summ}:</label>
			<div class="controls">
				<div class="input-group">
			        {PAYOUT_FORM_SUMM}
			        <span class="input-group-addon">{PHP.cfg.payments.valuta}</span>
		        </div>
		    </div>
		</div>
			<!-- IF {PHP.cfg.payments.payouttax} > 0 -->
		<div class="control-group">
			<label class="control-label">{PHP.L.payments_balance_payout_tax} ({PHP.cfg.payments.payouttax}%):</label>
			<div class="controls"><span class="help-inline"><span id="payout_tax">{PAYOUT_FORM_TAX}</span> {PHP.cfg.payments.valuta}</span></div>
		</div>
		<div class="control-group">
			<label class="control-label">{PHP.L.payments_balance_payout_total}:</label>
			<div class="controls"><span class="help-inline"><span id="payout_total">{PAYOUT_FORM_TOTAL}</span> {PHP.cfg.payments.valuta}</span></div>
		</div>
			<!-- ENDIF -->
		<div class="control-group">
			<label class="control-label"></label>
			<div class="controls"><button class="btn btn-success">{PHP.L.Submit}</button></td>
			</div>
		</div>
	</form>
			
	<!-- IF {PHP.cfg.payments.payouttax} > 0 -->		
	<script>
		$().ready(function() {
			$('#payoutform').bind('change click keyup', function (){
				var summ = parseFloat($("input[name='summ']").val());
				var tax = parseFloat({PHP.cfg.payments.payouttax});

				if(isNaN(summ)) summ = 0;

				var taxsumm = summ*tax/100;
				var totalsumm = summ + taxsumm;

				$('#payout_tax').html(taxsumm);
				$('#payout_total').html(totalsumm);
			});
		});
	</script>
	<!-- ENDIF -->

	<!-- END: PAYOUTFORM -->

	<!-- BEGIN: TRANSFERS -->
	<a class="pull-right btn btn-success" href="{PHP|cot_url('payments', 'm=balance&n=transfers&a=add')}">{PHP.L.payments_balance_transfers_button}</a>
	<h5>{PHP.L.payments_balance_transfers_list}</h5>
	<!-- IF {PHP.transfers|count($this)} > 0 -->
	<table class="table table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>{PHP.L.payments_balance_transfers_for}</th>
				<th class="text-right">{PHP.L.payments_summ}</th>
				<th>{PHP.L.Description}</th>
				<th class="text-right">{PHP.L.Date}</th>
				<th class="text-right">{PHP.L.Done}</th>
				<th class="text-right">{PHP.L.Status}</th>
			</tr>
		</thead>
		<!-- BEGIN: TRANSFER_ROW -->
		<tr>
			<td>{TRANSFER_ROW_ID}</td>
			<td><a href="{TRANSFER_ROW_FOR_DETAILSLINK}">{TRANSFER_ROW_FOR_FULL_NAME}</a></td>
			<td class="text-right">{TRANSFER_ROW_SUMM|number_format($this, '2', '.', ' ')} {PHP.cfg.payments.valuta}</td>
			<td>{TRANSFER_ROW_COMMENT}</td>
			<td class="text-right">{TRANSFER_ROW_DATE|cot_date('d.m.Y H:i', $this)}</td>
			<td class="text-right">{TRANSFER_ROW_DONE|cot_date('d.m.Y H:i', $this)}</td>
			<td class="text-right">{TRANSFER_ROW_LOCALSTATUS}</td>
		</tr>
		<!-- END: TRANSFER_ROW -->
	</table>
	<!-- ELSE -->
	<div class="alert alert-info">{PHP.L.payments_history_empty}</div>
	<!-- ENDIF -->
	<!-- END: TRANSFERS -->

	<!-- BEGIN: TRANSFERFORM -->	
	<h5>{PHP.L.payments_transfer}</h5>
	{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
	<form action="{TRANSFER_FORM_ACTION_URL}" method="post" id="transferform" class="form-horizontal">
		<div class="control-group">
			<label class="control-label">{PHP.L.payments_balance_transfer_comment}:</label>
			<div class="controls">{TRANSFER_FORM_COMMENT|cot_rc_modify($this, 'class="span4"')}</div>
		</div>
		<div class="control-group">
			<label class="control-label">{PHP.L.payments_balance_transfer_username}:</label>
			<div class="controls">{TRANSFER_FORM_USERNAME}</div>
		</div>
		<div class="control-group">
			<label class="control-label">{PHP.L.payments_balance_transfer_summ}:</label>
			<div class="controls">
				<div class="input-group">
					{TRANSFER_FORM_SUMM} 
					<span class="input-group-addon">{PHP.cfg.payments.valuta}</span>
				</div>
			</div>
		</div>
		<!-- IF {PHP.cfg.payments.transfertax} > 0 AND !{PHP.cfg.payments.transfertaxfromrecipient} -->
		<div class="control-group">
			<label class="control-label">{PHP.L.payments_balance_transfer_tax} ({PHP.cfg.payments.transfertax}%):</label>
			<div class="controls"><span class="help-inline"><span id="transfer_tax">{TRANSFER_FORM_TAX}</span> {PHP.cfg.payments.valuta}</span></div>
		</div>
		<div class="control-group">
			<label class="control-label">{PHP.L.payments_balance_transfer_total}:</label>
			<div class="controls">
				<span class="help-inline">
					<span id="transfer_total">{TRANSFER_FORM_TOTAL}</span> {PHP.cfg.payments.valuta}
				</span>
				<script>
					$().ready(function() {
						$('#transferform').bind('change click keyup', function (){
							var summ = parseFloat($("input[name='summ']").val());
							var tax = parseFloat({PHP.cfg.payments.transfertax});

							if(isNaN(summ)) summ = 0;

							var taxsumm = summ*tax/100;
							var totalsumm = summ + taxsumm;

							$('#transfer_tax').html(taxsumm);
							$('#transfer_total').html(totalsumm);
						});
					});
				</script>
				
			</div>
		</div>
		<!-- ENDIF -->
		<div class="control-group">
			<label class="control-label"></label>
			<div class="controls"><button class="btn btn-success">{PHP.L.Submit}</button></div>
		</div>
	</form>

	<!-- END: TRANSFERFORM -->

	<!-- BEGIN: HISTORY -->
	<h5>{PHP.L.payments_history}</h5>
	<!-- IF {HISTORY_COUNT} > 0 -->
	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>-/+</th>
				<th>{PHP.L.Date}</th>
				<th>{PHP.L.Description}</th>
				<th class="text-right">{PHP.L.payments_summ}</th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: HIST_ROW -->
			<tr>
				<td>{HIST_ROW_ID}</td>
				<td><!-- IF {HIST_ROW_AREA} == 'balance' -->+<!-- ELSE -->-<!-- ENDIF --></td>
				<td>{HIST_ROW_PDATE|cot_date('d.m.Y H:i', $this)}</td>
				<td>{HIST_ROW_DESC}</td>
				<td class="text-right">{HIST_ROW_SUMM|number_format($this, '2', '.', ' ')} {PHP.cfg.payments.valuta}</td>
			</tr>
			<!-- END: HIST_ROW -->
		</tbody>
	</table>
	<div class="pagination">{PAGENAV_PREV}{PAGENAV_PAGES}{PAGENAV_NEXT}</div>
	<!-- ELSE -->
	<div class="alert alert-info">{PHP.L.payments_history_empty}</div>
	<!-- ENDIF -->
	<!-- END: HISTORY -->

</div>

<!-- END: MAIN -->