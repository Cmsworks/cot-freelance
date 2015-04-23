<!-- BEGIN: MAIN -->

<div class="row">
	<div class="span12">
		<!-- IF {PHP.cot_plugins_active.paytop} -->
		{PHP|cot_get_paytop ('top')}
		<!-- ENDIF -->	
	</div>
</div>
<div class="row">
	<div class="span3">
		<div class="well well-small">{PROJECTS_CATALOG}</div>
		
		<!-- IF {PHP.cot_plugins_active.userpoints} -->
		<h4 class="mboxHD">{PHP.L.userpoints_topfreelancers}</h4>
		{PHP|cot_get_topusers (4, 5)}
		<br/>
		<br/>
		<h4 class="mboxHD">{PHP.L.userpoints_topemployers}</h4>
		{PHP|cot_get_topusers (7, 5)}	
		<!-- ENDIF -->	
		
		<!-- IF {INDEX_NEWS} -->
		<br/>
		<br/>
		<div class="block">
			{INDEX_NEWS}
		</div>
		<!-- ENDIF -->
	</div>
	<div class="span9">
		{PROJECTS_SEARCH}
		
		<!-- IF {PHP.cot_plugins_active.paypro} -->
			<!-- IF !{PHP|cot_getuserpro()} AND {PHP.cfg.plugin.paypro.projectslimit} > 0 AND {PHP.cfg.plugin.paypro.projectslimit} <= {PHP.usr.id|cot_getcountprjofuser($this)} -->
			<div class="alert alert-warning">{PHP.L.paypro_warning_projectslimit_empty}</div>
			<!-- ENDIF -->
			<!-- IF !{PHP|cot_getuserpro()} AND {PHP.cfg.plugin.paypro.offerslimit} > 0 AND {PHP.cfg.plugin.paypro.offerslimit} <= {PHP.usr.id|cot_getcountoffersofuser($this)} -->
			<div class="alert alert-warning">{PHP.L.paypro_warning_offerslimit_empty}</div>
			<!-- ENDIF -->
		<!-- ENDIF -->
		
		{PROJECTS}
	</div>
</div>
	
<!-- END: MAIN -->