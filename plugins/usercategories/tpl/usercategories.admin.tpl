<!-- BEGIN: MAIN -->


<div class="block">
	<form action="{EDITFORM_ACTION_URL}" method="post" name="editcat">
		<h3>{PHP.L.usercategories_cat_editor}</h3>
		<table class="cells">
			<tr>
				<td class="coltop width10">{PHP.L.Path}</td>
				<td class="coltop width10">{PHP.L.Code}</td>
				<td class="coltop width40">{PHP.L.Title}</td>
				<td class="coltop width40">{PHP.L.Description}</td>
				<td class="coltop width10">{PHP.L.Action}</td>
			</tr>	
			<!-- BEGIN: ROWS -->
			<tr>
				<td>{ROW_PATH} </td>
				<td>{ROW_CODE} </td>
				<td>{ROW_TITLE} </td>
				<td>{ROW_DESC} </td>
				<td>
					<a title="{PHP.L.Delete}" href="{ROW_DELETE}" class="negative button"><span class="trash icon"></span>{PHP.L.Delete}</a>		
				</td>
			</tr>
			<!-- END: ROWS -->
			<!-- BEGIN: NOROWS -->
			<tr>
				<td class="centerall" colspan="4">{PHP.L.None}</td>
			</tr>
			<!-- END: NOROWS -->	
		</table>
		<div class="action_bar valid">
			<p class="paging">{PAGENAV_PAGES} </p>
			<input type="submit" class="submit" value="{PHP.L.Update}" />
		</div>	
	</form>
</div>	

<div class="block">
	<h3>{PHP.L.Add}</h3>
	<form method="post" action="{ADDFORM_ACTION_URL}">
		<table class="cells">
			<tr>
				<td width="150">{PHP.L.Path}:</td>
				<td>{ADDFORM_PATH}</td>
			</tr>
			<tr>
				<td>{PHP.L.Code}:</td>
				<td>{ADDFORM_CODE}</td>
			</tr>
			<tr>
				<td>{PHP.L.Title}:</td>
				<td>{ADDFORM_TITLE}</td>
			</tr>
			<tr>
				<td>{PHP.L.Description}:</td>
				<td>{ADDFORM_DESC}</td>
			</tr>
		</table>
		<div class="action_bar valid">
			<input type="submit" class="submit" value="{PHP.L.Add}" />
		</div>	
	</form>
</div>

<!-- END: MAIN -->