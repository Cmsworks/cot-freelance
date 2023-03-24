<!-- BEGIN: MAIN -->

<!-- BEGIN: UPDATE -->
	<div class="block">
		<h3>{PHP.L.adminqv_update_notice}:</h3>
		<p>{ADMIN_HOME_UPDATE_REVISION} {ADMIN_HOME_UPDATE_MESSAGE}</p>
	</div>
<!-- END: UPDATE -->
	{FILE "{PHP.cfg.themes_dir}/admin/{PHP.cfg.admintheme}/warnings.tpl"}
<!-- BEGIN: MAINPANEL -->
	{ADMIN_HOME_MAINPANEL}
<!-- END: MAINPANEL -->

<div class="row">
	<!-- BEGIN: SIDEPANEL -->
	<div class="span3 pull-left">
		{ADMIN_HOME_SIDEPANEL}
	</div>
	<!-- END: SIDEPANEL -->
</div>
	
<hr/>

<div class="row">
	<div class="span4">
		<div class="block">
			<h3>{PHP.L.home_ql_b1_title}</h3>
			<ul class="nav nav-tabs nav-stacked">
				<li><a href="{PHP|cot_url('admin','m=config&n=edit&o=core&p=main')}">{PHP.L.home_ql_b1_1}</a></li>
				<li><a href="{PHP|cot_url('admin','m=config&n=edit&o=core&p=title')}">{PHP.L.home_ql_b1_2}</a></li>
				<li><a href="{PHP|cot_url('admin','m=config&n=edit&o=core&p=theme')}">{PHP.L.home_ql_b1_3}</a></li>
				<li><a href="{PHP|cot_url('admin','m=config&n=edit&o=core&p=menus')}">{PHP.L.home_ql_b1_4}</a></li>
				<li><a href="{PHP|cot_url('admin','m=config&n=edit&o=core&p=locale')}">{PHP.L.Locale}</a></li>
				<li><a href="{PHP|cot_url('admin','m=extrafields')}">{PHP.L.adm_extrafields}</a></li>
			</ul>
		</div>
	</div>
</div>

<!-- END: MAIN -->