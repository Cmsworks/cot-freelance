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

	<!-- IF {PAYTOP_COUNT} <= 4 -->
	<!-- FOR {INDEX} IN {PHP|range(1, 4)} -->
	<!-- IF 4 - {INDEX} >= {PAYTOP_COUNT} -->
	<div class="span3">
		<div class="row">
			<div class="span1">
				<img src="datas/defaultav/blank.png">
			</div>
			<div class="span2">
				<p>{PHP.L.paytop_default_text}</p>
			</div>
		</div>
		<br/>
	</div>
	<!-- ENDIF -->
	<!-- ENDFOR -->
	<!-- ENDIF -->

</div>	
<div class="pull-right"><a href="{PAYTOP_BUY_URL}">{PHP.L.paytop_how}</a></div>
<hr/>
<!-- END: MAIN -->