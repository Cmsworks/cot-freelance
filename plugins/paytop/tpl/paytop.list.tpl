<!-- BEGIN: MAIN -->
<div class="row">
	<!-- BEGIN: TOP_ROW -->
	<div class="span3">
		<div class="row">
			<div class="span1">
				{TOP_ROW_AVATAR}
			</div>
			<div class="span2">
				<p>{TOP_ROW_NAME}</p>
				<p>
					<!-- IF {TOP_ROW_ISPRO} -->
					<span class="label label-important">PRO</span> 
					<!-- ENDIF -->
					<span class="label label-info">{TOP_ROW_USERPOINTS}</span>
				</p>
			</div>
		</div>
		<br/>
	</div>
	<!-- END: TOP_ROW -->
</div>	
<div class="pull-right"><a href="{PAYTOP_BUY_URL}">{PHP.L.paytop_how}</a></div>
<hr/>
<!-- END: MAIN -->