<!-- BEGIN: MAIN -->

<div class="breadcrumb">Счета на оплату</div>

<table class="table table-bordered width100">
	<thead>
	<tr>
		<th>#</th>
		<th>{PHP.L.payments_desc}</th>
		<th>{PHP.L.payments_summ}</th>
		<th>{PHP.L.payorders_date_create}</th>
		<th>{PHP.L.payorders_date_paid}</th>
		<th>{PHP.L.payorders_status}</th>
	</tr>
	</thead>
	<tbody>
	<!-- BEGIN: ORD_ROW -->
	<tr>
		<td>{ORD_ROW_ID}</td>
		<td>{ORD_ROW_DESC}</td>
		<td style="text-align: right;">{ORD_ROW_SUMM|number_format($this, '2', '.', ' ')} {PHP.L.valuta}</td>
		<td>{ORD_ROW_CDATE|cot_date('d.m.Y', $this)}</td>
		<td><!-- IF {ORD_ROW_PDATE} > 0 -->{ORD_ROW_PDATE|cot_date('d.m.Y', $this)}<!-- ELSE -->&mdash;<!-- ENDIF --></td>
		<td>
			<!-- IF {ORD_ROW_STATUS} == 'done' -->
			Оплачен
			<!-- ELSE -->
			<a href="{ORD_ROW_ID|cot_url('payments', 'm=billing&pid='$this)}">Оплатить</a>
			<!-- ENDIF -->
		</td>
	</tr>
	<!-- END: ORD_ROW -->
	</tbody>
</table>

<!-- END: MAIN -->