<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PRJ_TITLE}</div>
<h1 class="tboxHD">
	{PRJ_SHORTTITLE}
</h1>
<!-- IF {PRJ_STATE} == 2 -->
<div class="alert alert-warning">{PHP.L.projects_forreview}</div>
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
	</div>
</div>
<a href="{PRJ_SAVE_URL}" class="btn btn-success"><span>{PHP.L.Publish}</span></a> 
<a href="{PRJ_EDIT_URL}" class="btn btn-info"><span>{PHP.L.Edit}</span></a>

<!-- END: MAIN -->	