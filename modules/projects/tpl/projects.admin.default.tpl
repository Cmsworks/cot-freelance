<!-- BEGIN: MAIN -->

<h3>{PHP.L.projects_projects}</h3>

<div class="nav nav-tabs">
	<!-- BEGIN: TYPES -->
	<li<!-- IF {PHP.p} != 'types' --> class="active"<!-- ENDIF -->><a href="{TYPE_ALL_URL}">{PHP.L.All}</a></li>
	<!-- BEGIN: TYPES_ROWS -->
	<li class="{TYPE_ALL_ACT}"><a href="{TYPE_ROW_URL}">{TYPE_ROW_TITLE}</a></li>
	<!-- END: TYPES_ROWS -->
	<!-- END: TYPES -->
	<li><a href="{TYPES_EDIT}">{PHP.L.projects_types_edit}</a></li>	
</div>

<div class="well" id="schform">
	<form action="{SEARCH_ACTION_URL}" method="get">
		<input type="hidden" name="m" value="{PHP.m}" />
		<input type="hidden" name="p" value="{PHP.p}" />
		<input type="hidden" name="c" value="{PHP.c}" />
		<input type="hidden" name="type" value="{PHP.type}" />
		<table width="100%" cellpadding="5" cellspacing="0">
			<tr>
				<td width="100">{PHP.L.Search}:</td>
				<td>{SEARCH_SQ}</td>
			</tr>
			<tr>
				<td >{PHP.L.Location}:</td>
				<td>{SEARCH_LOCATION}</td>
			</tr>
			<tr>
				<td >{PHP.L.Category}:</td>
				<td>{SEARCH_CAT}</td>
			</tr>
			<tr>
				<td>{PHP.L.Order}:</td>
				<td>{SEARCH_SORTER}</td>
			</tr>
			<tr>
				<td></td>
				<td>{SEARCH_STATE}<br/></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="search" class="btn btn-success" value="{PHP.L.Search}" /></td>
			</tr>
		</table>		
	</form>
</div>

<form action="{PHP|cot_url('admin','m=projects'),'',true}" id="prj_form" method="POST">
<div class="block" id="listprojects">
	<table class="table">
		<thead>
		<tr class="prjitem">
			<th class="coltop">{PHP.L.Date}</th>
			<th class="coltop">{PHP.L.Title}</th>
			<th class="coltop">{PHP.L.projects_price}</th>
			<th class="coltop">{PHP.L.Owner}</th>
			<th class="coltop">{PHP.L.Text}</th>
			<th class="coltop">{PHP.L.Type}</th>
			<th class="coltop">{PHP.L.Category}</th>
			<th class="coltop">{PHP.L.Actions}</th>
		</tr>
		</thead>
		<tbody>
		<!-- BEGIN: PRJ_ROWS -->
		<tr class="prjitem">
			<td><label><input type="checkbox" name="prj_arr[]" value="{PRJ_ROW_ID}">{PRJ_ROW_DATE}</label></td>
			<td><a href="{PRJ_ROW_URL}" target="_blank">{PRJ_ROW_SHORTTITLE}</a></td>
			<td><!-- IF {PRJ_ROW_COST} > 0 --><div class="cost">{PRJ_ROW_COST} {PHP.cfg.payments.valuta}</div><!-- ENDIF --></td>
			<td>{PRJ_ROW_OWNER_NAME}</td>
			<td>{PRJ_ROW_SHORTTEXT}</td>
			<td>{PRJ_ROW_TYPE}</td>
			<td>{PRJ_ROW_CATTITLE}</td>
			<td>
				<a href="{PRJ_ROW_EDIT_URL}" class="button btn" target="blank">{PHP.L.Edit}</a>
				<!-- IF {PRJ_ROW_STATE} == 2 -->
				<a href="{PRJ_ROW_VALIDATE_URL}" class="button btn">{PHP.L.Validate}</a>
				<!-- ENDIF -->
				<a href="{PRJ_ROW_DELETE_URL}" class="button btn">{PHP.L.Delete}</a>
			</td>
		</tr>
		<!-- END: PRJ_ROWS -->
		<tr class="prjitem">
				<td colspan="2">
					<select name="prj_action" id="prj_action">
						<option value="0">---</option>
						<option value="delete">{PHP.L.Delete}</option>
						<option value="validate">{PHP.L.Validate}</option>
					</select>
				</td>
				<td colspan="6">
					<button type="submit" class="btn btn-default">{PHP.L.Confirm}</button>
				</td>		
			</tr>
		</tbody>
	</table>
	<div class="action_bar valid">
		<div class="pagination">
			<ul>{PAGENAV_PAGES}</ul>
		</div>
	</div>
	</form>		
</div>


<!-- END: MAIN -->