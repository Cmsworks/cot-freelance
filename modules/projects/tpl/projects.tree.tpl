<!-- BEGIN: MAIN -->
<ul<!-- IF {LEVEL} == 0 --> class="nav nav-list"<!-- ENDIF -->>
	<!-- IF {LEVEL} == 0 -->
	<li><a href="{HREF}">{PHP.L.All}</a></li>		
	<!-- ENDIF -->
	<!-- BEGIN: CATS -->
	<li<!-- IF {ROW_SELECTED} --> class="active"<!-- ENDIF -->><a href="{ROW_HREF}">{ROW_TITLE} ({ROW_COUNT})</a>
		<!-- IF {ROW_SUBCAT} -->
		{ROW_SUBCAT}
		<!-- ENDIF -->
	</li>
	<!-- END: CATS -->
</ul>
<!-- END: MAIN -->