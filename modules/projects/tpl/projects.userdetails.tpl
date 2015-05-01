<!-- BEGIN: MAIN -->
<h4><!-- IF {PHP.usr.id} == {PHP.urr.user_id} AND {ADDPRJ_SHOWBUTTON} --><div class="pull-right"><a href="{PHP|cot_url('projects', 'm=add')}" class="btn btn-success">{PHP.L.projects_add_to_catalog}</a></div><!-- ENDIF -->{PHP.L.projects_projects}</h4>

<ul class="nav nav-pills">
  <li>
 	  <a href="{PHP.urr.user_id|cot_url('users', 'm=details&id=$this&tab=projects')}">{PHP.L.All}</a>
  </li>
  	<!-- BEGIN: CAT_ROW -->
  		<li class="centerall <!-- IF {PRJ_CAT_ROW_SELECT} -->active<!-- ENDIF -->">
  				<a href="{PRJ_CAT_ROW_URL}">
  						<!-- IF {PRJ_ROW_CAT_ICON} -->
  							<img src="{PRJ_CAT_ROW_ICON}" alt="{PRJ_CAT_ROW_TITLE} ">
  						<!-- ENDIF -->
  						{PRJ_CAT_ROW_TITLE} 
  					<span class="badge badge-inverse">{PRJ_CAT_ROW_COUNT_PROJECTS}</span>
  				</a>
  		</li>
  	<!-- END: CAT_ROW -->
</ul>
<hr>
<div id="listprojects">
	<!-- BEGIN: PRJ_ROWS -->
	<div class="media<!-- IF {PRJ_ROW_ISBOLD} --> well prjbold<!-- ENDIF --><!-- IF {PRJ_ROW_ISTOP} --> well prjtop<!-- ENDIF -->">
		<h4>
			<!-- IF {PRJ_ROW_COST} > 0 --><div class="pull-right">{PRJ_ROW_COST} {PHP.cfg.payments.valuta}</div><!-- ENDIF -->
			<a href="{PRJ_ROW_URL}">{PRJ_ROW_SHORTTITLE}</a> <!-- IF {PRJ_ROW_USER_IS_ADMIN} --> <span class="label label-info">{PRJ_ROW_LOCALSTATUS}</span><!-- ENDIF -->
		</h4>
		<div class="pull-right textright">
			<!-- IF {PHP.cot_plugins_active.payprjtop} AND {PHP.usr.id} == {PHP.urr.user_id} --><li>{PRJ_ROW_PAYTOP}</li><!-- ENDIF -->
			<!-- IF {PHP.cot_plugins_active.payprjbold} AND {PHP.usr.id} == {PHP.urr.user_id} --><li>{PRJ_ROW_PAYBOLD}</li><!-- ENDIF -->
		</div>	
		<p class="owner small"><span class="date">[{PRJ_ROW_DATE}]</span>   <span class="region">{PRJ_ROW_COUNTRY} {PRJ_ROW_REGION} {PRJ_ROW_CITY}</span>   {PRJ_ROW_EDIT_URL}</p>
		<p class="text">{PRJ_ROW_SHORTTEXT}</p>
		<div class="pull-right offers"><a href="{PRJ_ROW_OFFERS_ADDOFFER_URL}">{PHP.L.offers_add_offer}</a> ({PRJ_ROW_OFFERS_COUNT})</div>
		<div class="type"><!-- IF {PRJ_ROW_TYPE} -->{PRJ_ROW_TYPE} / <!-- ENDIF --><a href="{PRJ_ROW_CATURL}">{PRJ_ROW_CATTITLE}</a></div>
	</div>
	<hr/>
	<!-- END: PRJ_ROWS -->
</div>

<!-- IF {PAGENAV_COUNT} > 0 -->	
<div class="pagination"><ul>{PAGENAV_PAGES}</ul></div>
<!-- ELSE -->
<div class="alert">{PHP.L.projects_empty}</div>
<!-- ENDIF -->

<!-- END: MAIN -->