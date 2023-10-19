<!-- BEGIN: MAIN -->

	<div class="breadcrumb">{PHP.L.affiliate}</div>

	<h4>{PHP.L.affiliate_link_title}:</h4>
	<p>{PHP.cfg.mainurl}/?ref={PHP.usr.id}</p>
	<br/>
	<br/>
	<h4>{PHP.L.affiliate_tree_title}:</h4>
	{REFERALS_TREE}

	<!-- BEGIN: PAYMENTS -->
		<br/>
		<br/>
		<h4>{PHP.L.affiliate_payments_title}:</h4>
		
		<table class="table">
			<thead>
			<tr>
				<th class="coltop">#</th>
				<th class="coltop">{PHP.L.Date}</th>
				<th class="coltop">{PHP.L.affiliate_referal}</th>
				<th class="coltop">{PHP.L.payments_summ}</th>
			</tr>
			</thead>
			<tbody>
			<!-- BEGIN: PAY_ROW -->
			<tr>
				<td class="width10">{PAY_ROW_ID}</td>
				<td class="width15">{PAY_ROW_PDATE|cot_date('d.m.Y H:i', $this)}</td>
				<td class="width15">{PAY_ROW_REFERAL_NAME}</td>
				<td style="text-align: right;">{PAY_ROW_SUMM|number_format($this, '2', '.', ' ')} {PHP.cfg.payments.valuta}</td>
			</tr>
			<!-- END: PAY_ROW -->
			</tbody>
		</table>
		
		<p><b>{PHP.L.payments_allpayments}: {PAYMENT_SUMM|number_format($this, '2', '.', ' ')} {PHP.cfg.payments.valuta}</b></p>	
		
	<!-- END: PAYMENTS -->

<!-- END: MAIN -->