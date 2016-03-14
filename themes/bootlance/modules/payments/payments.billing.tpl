<!-- BEGIN: MAIN -->


<!-- BEGIN: BILLINGS -->
	<h4>{PHP.L.payments_billing_title}:</h4>
	<!-- BEGIN: BILL_ROW -->
	<div class="media">
		<div class="pull-left">
			<img src="<!-- IF {BILL_ROW_ICON} -->{BILL_ROW_ICON}<!-- ELSE -->modules/payments/images/billing_blank.png<!-- ENDIF -->" />
		</div>
		<div class="media-body">
			<h5><a href="{BILL_ROW_URL}">{BILL_ROW_TITLE}</a></h5>
		</div>
	</div>
	<!-- END: BILL_ROW -->
<!-- END: BILLINGS -->

<!-- BEGIN: EMPTYBILLINGS -->
	<h4>{PHP.L.payments_billing_title}:</h4>
	<div class="alert alert-danger">{PHP.L.payments_emptybillings}</div>
<!-- END: EMPTYBILLINGS -->


<!-- END: MAIN -->