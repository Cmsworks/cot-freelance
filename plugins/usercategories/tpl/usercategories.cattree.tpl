<!-- BEGIN: MAIN -->
<ul<!-- IF {CAT_LEVEL} == 1 --> id="ucats_tree" class="nav nav-list"<!-- ENDIF -->>
	<!-- IF {CAT_LEVEL} == 1 -->
	<li><a href="{CAT_URL}">{PHP.L.All}</a></li>		
	<!-- ENDIF -->
	<!-- BEGIN: CAT_ROW -->
	<li<!-- IF {CAT_ROW_SELECTED} --> class="active"<!-- ENDIF -->><a href="{CAT_ROW_URL}">{CAT_ROW_TITLE} ({CAT_ROW_COUNT})</a>
		<!-- IF {CAT_ROW_SUBCAT} -->
		{CAT_ROW_SUBCAT}
		<!-- ENDIF -->
	</li>
	<!-- END: CAT_ROW -->
</ul>
<!-- END: MAIN -->