<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PHP.L.nullbilling_title}</div>

<!-- BEGIN: ERROR -->
	<h4>{BILLING_TITLE}</h4>
	{BILLING_ERROR}
	
	<!-- IF {BILLING_REDIRECT_URL} -->
	<br/>
	<p class="small">{BILLING_REDIRECT_TEXT}</p>
	<script>
		$(function(){
			setTimeout(function () {
				location.href='{BILLING_REDIRECT_URL}';
			}, 5000);
		});
	</script>
	<!-- ENDIF -->
<!-- END: ERROR -->


<!-- END: MAIN -->