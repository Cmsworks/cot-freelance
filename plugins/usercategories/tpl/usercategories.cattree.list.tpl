<!-- BEGIN: MAIN -->
<ul<!-- IF {CAT_LEVEL} == 0 --> id="ucats_list" class="nav nav-list"<!-- ENDIF -->>
	<!-- BEGIN: CAT_ROW -->
	<!-- IF {CAT_ROW_SELECTED} -->
	<li>{CAT_ROW_TITLE}
		<!-- IF {CAT_ROW_SUBCAT} -->
		{CAT_ROW_SUBCAT}
		<!-- ENDIF -->
	</li>
	<!-- ENDIF -->
	<!-- END: CAT_ROW -->
</ul>
<!-- END: MAIN -->