<!-- BEGIN: MAIN -->

	<table class="cells table table-bordered table-striped">
		<tr>
			<th>#</th>
			<th>{PHP.L.paytop_my_area}</th>
			<th>{PHP.L.paytop_my_until}</th>
		</tr>
		<!-- BEGIN: TOP_ROW -->
		<tr>
			<td>{TOP_ROW_ID}</td>
			<td>{TOP_ROW_AREA_TITLE}</td>
			<td>{TOP_ROW_EXPIRE|cot_date('d.m.Y, H:i', $this)}</td>
		</tr>
		<!-- END: TOP_ROW -->
	</table>

<!-- END: MAIN -->