<!-- BEGIN: MAIN -->
<div class="block">
	<h3>{PHP.L.ls_countries}</h3>
	<form action="{LOCATIONSELECTOR_FORM_UPDATE}" method="post" name="update" id="update" class="ajax">
		<table class="table">
		<thead>
			<tr>
				<th class="width10">
					<!-- IF {PHP.cfg.jquery} --><input class="checkbox" type="checkbox" value="{PHP.L.Yes}/{PHP.L.No}" onclick="$('.checkbox').attr('checked', this.checked);" /><!-- ENDIF -->
				</th>
				<th>{PHP.L.Country}</th>
			</tr>	
		</thead>
		<!-- BEGIN: ROWS -->
		<tr>
			<td class="width10"><input type="checkbox" class="checkbox" name="enabled_countries[]" <!-- IF {COUNTRY_ROW_CHECKED} -->checked="checked"<!-- ENDIF --> value="{COUNTRY_ROW_CODE}"/></td>
			<td>{COUNTRY_ROW_FLAG} <a href="{COUNTRY_ROW_URL}" class="thumbicons">{COUNTRY_ROW_NAME}</a></td>
		</tr>
		<!-- END: ROWS -->
		</table>
		<button type="submit" class="btn btn-success">{PHP.L.Update}</button>
	</form>
	<!-- BEGIN: NOROWS -->
	<p>{PHP.L.ls_nocountries}</p>
	<!-- END: NOROWS -->
	<div class="clear height0"></div>
</div>
<!-- END: MAIN -->