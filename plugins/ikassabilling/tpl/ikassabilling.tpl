<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PHP.L.ikassabilling_title}</div>

<!-- BEGIN: IKASSAFORM -->
	<div class="alert alert-info">{PHP.L.ikassabilling_formtext}</div>
	<script>
		$(document).ready(function(){
			setTimeout(function() {
				$("#ikassaform").submit();
			}, 3000);
		});
	</script>
	{IKASSA_FORM}
<!-- END: IKASSAFORM -->

<!-- BEGIN: ERROR -->
	<h4>{IKASSA_TITLE}</h4>
	{IKASSA_ERROR}
	
	<!-- IF {IKASSA_REDIRECT_URL} -->
	<br/>
	<p class="small">{IKASSA_REDIRECT_TEXT}</p>
	<script>
		$(function(){
			setTimeout(function () {
				location.href='{IKASSA_REDIRECT_URL}';
			}, 5000);
		});
	</script>
	<!-- ENDIF -->
	
<!-- END: ERROR -->


<!-- END: MAIN -->