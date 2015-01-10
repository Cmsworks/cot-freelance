<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PHP.L.roboxbilling_title}</div>

<!-- BEGIN: ERROR -->
	<h4>{ROBOX_TITLE}</h4>
	{ROBOX_ERROR}
	
	
	<!-- IF {ROBOX_REDIRECT_URL} -->
	<br/>
	<p class="small">{ROBOX_REDIRECT_TEXT}</p>
	<script>
		$(function(){
			setTimeout(function () {
				location.href='{ROBOX_REDIRECT_URL}';
			}, 5000);
		});
	</script>
	<!-- ENDIF -->
<!-- END: ERROR -->


<!-- END: MAIN -->