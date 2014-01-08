<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PHP.L.wmbilling_title}</div>

<!-- BEGIN: WMFORM -->
	<div class="alert alert-info">{PHP.L.wmbilling_formtext}</div>
	<script>
		$(document).ready(function(){
			setTimeout(function() {
				$("#wmform").submit();
			}, 3000);
		});
	</script>
	{WEBMONEY_FORM}
<!-- END: WMFORM -->

<!-- BEGIN: ERROR -->
	<h4>{WEBMONEY_TITLE}</h4>
	{WEBMONEY_ERROR}
<!-- END: ERROR -->


<!-- END: MAIN -->