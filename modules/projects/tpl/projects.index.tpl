<!-- BEGIN: SEARCH -->
	<!-- BEGIN: PTYPES -->
	<ul class="nav nav-tabs">
		<li class="active"><a href="{PTYPE_ALL_URL}">{PHP.L.All}</a></li>
		<!-- BEGIN: PTYPES_ROWS -->
		<li<!-- IF {PTYPE_ROW_ACT} --> class="active"<!-- ENDIF -->><a href="{PTYPE_ROW_URL}">{PTYPE_ROW_TITLE}</a></li>
		<!-- END: PTYPES_ROWS -->
		<!-- IF {PHP.cot_plugins_active.paypro} -->
		<li><a href="{FORPRO_URL}"><span class="label label-important">{PHP.L.paypro_forpro}</span></a></li>
		<!-- ENDIF -->
		<!-- IF {PHP.usr.auth_write} -->
		<li class="pull-right"><noindex><a rel="nofollow" class="btn btn-success" href="{PHP|cot_url('projects', 'm=add')}" title="{PHP.L.projects_add_to_catalog}">{PHP.L.projects_add_to_catalog}</a></noindex></li>
		<!-- ENDIF -->
	</ul>	
	<!-- END: PTYPES -->

	<div class="well">			
		<form action="{SEARCH_ACTION_URL}" method="get">
			<input type="hidden" name="e" value="projects" />
			<table width="100%" cellpadding="5" cellspacing="0">
				<tr>
					<td width="100">{PHP.L.Search}:</td>
					<td>{SEARCH_SQ}</td>
				</tr>
				<!-- IF {PHP.cot_plugins_active.locationselector} -->
				<tr>
					<td >{PHP.L.Location}:</td>
					<td>{SEARCH_LOCATION}</td>
				</tr>
				<!-- ENDIF -->
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
					<td><input type="submit" name="search" class="btn" value="{PHP.L.Search}" /></td>
				</tr>
			</table>		
		</form>
	</div>
<!-- END: SEARCH -->

<!-- BEGIN: PROJECTS -->
<div id="listprojects">
	<!-- BEGIN: PRJ_ROWS -->
	<div class="media<!-- IF {PRJ_ROW_ISBOLD} --> well prjbold<!-- ENDIF --><!-- IF {PRJ_ROW_ISTOP} --> well prjtop<!-- ENDIF -->">
		<h4>
			<!-- IF {PRJ_ROW_COST} > 0 --><div class="pull-right">{PRJ_ROW_COST} {PHP.cfg.payments.valuta}</div><!-- ENDIF -->
			<a href="{PRJ_ROW_URL}">{PRJ_ROW_SHORTTITLE}</a>
		</h4>
		<p class="owner small">{PRJ_ROW_OWNER_NAME} <span class="date">[{PRJ_ROW_DATE}]</span>   <span class="region">{PRJ_ROW_COUNTRY} {PRJ_ROW_REGION} {PRJ_ROW_CITY}</span>   {PRJ_ROW_EDIT_URL}</p>
		<p class="text">{PRJ_ROW_SHORTTEXT}</p>
		
		<!-- IF {PHP.cot_plugins_active.tags} AND {PHP.cot_plugins_active.tagslance} AND {PHP.cfg.plugin.tagslance.projects} -->
		<p class="small">{PHP.L.Tags}: 
			<!-- BEGIN: PRJ_ROW_TAGS_ROW --><!-- IF {PHP.tag_i} > 0 -->, <!-- ENDIF --><a href="{PRJ_ROW_TAGS_ROW_URL}" title="{PRJ_ROW_TAGS_ROW_TAG}" rel="nofollow">{PRJ_ROW_TAGS_ROW_TAG}</a><!-- END: PRJ_ROW_TAGS_ROW -->
			<!-- BEGIN: PRJ_ROW_NO_TAGS -->{PRJ_ROW_NO_TAGS}<!-- END: PRJ_ROW_NO_TAGS -->
		</p>
		<!-- ENDIF -->

		<div class="pull-right offers"><a href="{PRJ_ROW_OFFERS_ADDOFFER_URL}">{PHP.L.offers_add_offer}</a> ({PRJ_ROW_OFFERS_COUNT})</div>
		<div class="type"><!-- IF {PHP.cot_plugins_active.paypro} AND {PRJ_ROW_FORPRO} --><span class="label label-important">{PHP.L.paypro_forpro}</span> <!-- ENDIF --><!-- IF {PRJ_ROW_TYPE} -->{PRJ_ROW_TYPE} / <!-- ENDIF --><a href="{PRJ_ROW_CATURL}">{PRJ_ROW_CATTITLE}</a></div>
	</div>
	<hr/>
	<!-- END: PRJ_ROWS -->
</div>
<div class="pagination"><ul>{PAGENAV_PAGES}</ul></div>
<!-- END: PROJECTS -->