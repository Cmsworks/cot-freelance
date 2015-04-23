<!-- BEGIN: MAIN -->

<h3>{PHP.L.market}</h3>

<div class="well">	
	<form action="{SEARCH_ACTION_URL}" method="get">
		<input type="hidden" name="m" value="{PHP.m}" />
		<input type="hidden" name="p" value="{PHP.p}" />
		<input type="hidden" name="c" value="{PHP.c}" />
		<table width="100%" cellpadding="5" cellspacing="0">
			<tr>
				<td width="100">{PHP.L.Search}:</td>
				<td>{SEARCH_SQ}</td>
			</tr>
			<tr>
				<td width="100">{PHP.L.Location}:</td>
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

<form action="{PHP|cot_url('admin','m=market'),'',true}" id="prd_form" method="POST">
<div id="listmarket">
	<!-- BEGIN: PRD_ROWS -->
	<div class="media">
		<!-- IF {PRD_ROW_MAVATAR.1} -->
		<div class="pull-left">
			<a href="{PRD_ROW_URL}"><div class="thumbnail"><img src="{PRD_ROW_MAVATAR.1|cot_mav_thumb($this, 100, 100, crop)}" /></div></a>
		</div>
		<!-- ENDIF -->
		<h4><!-- IF {PRD_ROW_COST} > 0 --><div class="cost pull-right">{PRD_ROW_COST} {PHP.cfg.payments.valuta}</div><!-- ENDIF --><a href="{PRD_ROW_URL}">{PRD_ROW_SHORTTITLE}</a></h4>
		<label><input type="checkbox" name="prd_arr[]" value="{PRD_ROW_ID}">Отметить</label>
		<p class="owner">{PRD_ROW_OWNER_NAME} <span class="date">[{PRD_ROW_DATE}]</span> &nbsp;{PRD_ROW_COUNTRY} {PRD_ROW_REGION} {PRD_ROW_CITY} &nbsp; {PRD_ROW_ADMIN_EDIT}</p>
		<div class="pull-right">
			<!-- IF {PRD_ROW_STATE} == 2 -->
			<a href="{PRD_ROW_VALIDATE_URL}" class="button btn btn-success">{PHP.L.Validate}</a>
			<!-- ENDIF -->
			<a href="{PRD_ROW_DELETE_URL}" class="button btn btn-warning">{PHP.L.Delete}</a>
		</div>
		<p class="text">{PRD_ROW_SHORTTEXT}</p>
		<p class="type"><a href="{PRD_ROW_CATURL}">{PRD_ROW_CATTITLE}</a></p>
	</div>
		<!-- END: PRD_ROWS -->
</div>	
<hr>
<div class="row">
	<div class="span3">
		<select name="prd_action" id="prd_action">
			<option value="0">---</option>
			<option value="delete">{PHP.L.Delete}</option>
			<option value="validate">{PHP.L.Validate}</option>
		</select>		
	</div>
	<div class="span9">
		<button type="submit" class="btn btn-default">{PHP.L.Confirm}</button>
	</div>
</div>

<!-- IF {PAGENAV_COUNT} > 0 -->	
<div class="pagination"><ul>{PAGENAV_PAGES}</ul></div>
<!-- ELSE -->
<div class="alert">{PHP.L.market_notfound}</div>
<!-- ENDIF -->
</form>	
<!-- END: MAIN -->