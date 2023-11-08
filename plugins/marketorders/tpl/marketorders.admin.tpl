<!-- BEGIN: MAIN -->

<h3>{PHP.L.marketorders_sales_title}</h3>

<ul class="nav nav-tabs" id="myTab">
	<li<!-- IF !{PHP.status} --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('admin', 'm=other&p=marketorders')}">{PHP.L.All}</a></li>
	<!-- IF {PHP.cfg.plugin.marketorders.showneworderswithoutpayment} -->
	<li<!-- IF {PHP.status} == 'new' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('admin', 'm=other&p=marketorders&status=new')}">{PHP.L.marketorders_purchases_new}</a></li>
	<!-- ENDIF -->
	<li<!-- IF {PHP.status} == 'paid' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('admin', 'm=other&p=marketorders&status=paid')}">{PHP.L.marketorders_sales_paidorders}</a></li>
	<li<!-- IF {PHP.status} == 'done' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('admin', 'm=other&p=marketorders&status=done')}">{PHP.L.marketorders_sales_doneorders}</a></li>
	<li<!-- IF {PHP.status} == 'claim' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('admin', 'm=other&p=marketorders&status=claim')}">{PHP.L.marketorders_sales_claimorders}</a></li>
	<li<!-- IF {PHP.status} == 'cancel' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('admin', 'm=other&p=marketorders&status=cancel')}">{PHP.L.marketorders_sales_cancelorders}</a></li>
</ul>

<!-- BEGIN: ORDER_ROW -->
<div class="media">
	<div class="pull-right">{ORDER_ROW_COST} {PHP.cfg.payments.valuta}</div>
	<div class="span2">
		<div class="media-header"><a href="{ORDER_ROW_URL}">№ {ORDER_ROW_ID} [<!-- IF {ORDER_ROW_PAID} > 0 -->{ORDER_ROW_PAID|date('d.m.Y H:i', $this)}<!-- ELSE -->{ORDER_ROW_DATE|date('d.m.Y H:i', $this)}<!-- ENDIF -->]</a></div>
	</div>
	<div class="span6">
		<a href="{ORDER_ROW_PRD_URL}">{ORDER_ROW_PRD_SHORTTITLE}</a> ({ORDER_ROW_SELLER_NAME})
	</div>
	<div class="span2">
		<!-- IF {ORDER_ROW_CUSTOMER_ID} > 0 -->{ORDER_ROW_CUSTOMER_NAME}<!-- ELSE -->{ORDER_ROW_EMAIL}<!-- ENDIF -->
	</div>
</div>
<hr/>
<!-- END: ORDER_ROW -->

<!-- IF {PAGENAV_COUNT} > 0 -->
<div class="pagination"><ul>{PAGENAV_PAGES}</ul></div>
<!-- ELSE -->
<div class="alert">{PHP.L.marketorders_empty}</div>
<!-- ENDIF -->

<!-- END: MAIN -->
