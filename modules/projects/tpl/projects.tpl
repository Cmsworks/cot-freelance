<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PRJ_TITLE}</div>

<!-- IF {PRJ_REALIZED} -->
<div class="pull-right label label-info margintop10">{PHP.L.projects_isrealized}</div>
<!-- ENDIF -->

<!-- IF {PHP.cot_plugins_active.paypro} AND {PRJ_FORPRO} -->
<div class="pull-right margintop10"><span class="label label-important">{PHP.L.paypro_forpro}</span></div>
<!-- ENDIF -->

<h1 class="tboxHD">
	{PRJ_SHORTTITLE}
</h1>
<!-- IF {PRJ_STATE} == 2 -->
<div class="alert alert-warning">{PHP.L.projects_forreview}</div>
<!-- ENDIF -->
<!-- IF {PRJ_STATE} == 1 -->
<div class="alert alert-warning">{PHP.L.projects_hidden}</div>
<!-- ENDIF -->

<div class="row">
	<div class="span1">
		{PRJ_OWNER_AVATAR}
	</div>
	<div class="span5">
		<p>{PRJ_OWNER_NAME}</p>
		<p>
			<!-- IF {PRJ_OWNER_ISPRO} -->
			<span class="label label-important">PRO</span> 
			<!-- ENDIF -->
			<span class="label label-info">{PRJ_OWNER_USERPOINTS}</span>
		</p>
	</div>
</div>
<hr/>
<div class="row">
	<div class="span8">	
		{PRJ_TEXT}
		
		<!-- IF {PHP.cot_plugins_active.mavatars} -->
			<!-- IF {PRJ_MAVATARCOUNT} -->
				<div style="clear:both;"></div>
				<h5>{PHP.L.Files}:</h5>
				<ol class="files">
					<!-- FOR {KEY}, {VALUE} IN {PRJ_MAVATAR} -->
					<li><a href="{VALUE.FILE}">{VALUE.FILENAME}.{VALUE.FILEEXT}</a></li>
					<!-- ENDFOR -->
				</ol>
			<!-- ENDIF -->
		<!-- ENDIF -->
		
	</div>
	<div class="span4">
		<!-- IF {PRJ_COST} > 0 --><p>{PHP.L.offers_budget}: {PRJ_COST} {PHP.cfg.payments.valuta}</p><!-- ENDIF -->
		<p class="cat">{PHP.L.Category} : <a href="{PRJ_CAT|cot_url('projects', 'c='$this)}">{PRJ_CATTITLE}</a></p>
		<p class="small region">{PRJ_COUNTRY} {PRJ_REGION} {PRJ_CITY}</p>
		<p class="date">{PHP.L.Date}: {PRJ_DATE}</p>
		
		<!-- IF {PHP.cot_plugins_active.tags} AND {PHP.cot_plugins_active.tagslance} AND {PHP.cfg.plugin.tagslance.projects} -->
		<p class="small">{PHP.L.Tags}: 
			<!-- BEGIN: PRJ_TAGS_ROW --><!-- IF {PHP.tag_i} > 0 -->, <!-- ENDIF --><a href="{PRJ_TAGS_ROW_URL}" title="{PRJ_TAGS_ROW_TAG}" rel="nofollow">{PRJ_TAGS_ROW_TAG}</a><!-- END: PRJ_TAGS_ROW -->
			<!-- BEGIN: PRJ_NO_TAGS -->{PRJ_NO_TAGS}<!-- END: PRJ_NO_TAGS -->
		</p>
		<!-- ENDIF -->
		
		<!-- IF {PRJ_USER_IS_ADMIN} -->
			<div class="well well-small">
				{PRJ_ADMIN_EDIT} &nbsp; 
				<!-- IF {PRJ_STATE} != 2 -->
					<a href="{PRJ_HIDEPROJECT_URL}">{PRJ_HIDEPROJECT_TITLE}</a>	&nbsp; 
					<!-- IF {PRJ_PERFORMER} -->
					<a href="{PRJ_REALIZEDPROJECT_URL}">{PRJ_REALIZEDPROJECT_TITLE}</a>					
					<!-- ENDIF -->
				<!-- ENDIF -->
			</div>
		<!-- ENDIF -->	
	</div>
</div>
<hr/>

<div class="row">
	<div class="span12">
		{OFFERS}
	</div>
</div>

<!-- END: MAIN -->