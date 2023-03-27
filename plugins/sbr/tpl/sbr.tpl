<!-- BEGIN: MAIN -->

<div class="breadcrumb">{SBR_TITLE}</div>
<div class="pull-right paddingtop10"><span class="label label-{SBR_LABELSTATUS}">{SBR_LOCALSTATUS}</span></div>
<h1>{SBR_SHORTTITLE}</h1>

<ul class="nav nav-tabs">
	<li<!-- IF !{PHP.num} --> class="active"<!-- ENDIF -->><a href="{SBR_URL}">{PHP.L.sbr_nav_info}</a></li>
	<!-- BEGIN: STAGENAV_ROW -->
	<li<!-- IF {PHP.num} == {STAGENAV_ROW_NUM} --> class="active"<!-- ENDIF -->>
		<a href="{STAGENAV_ROW_URL}">
			{PHP.L.sbr_nav_stagenum} {STAGENAV_ROW_NUM} 
			<!-- IF {STAGENAV_ROW_STATUS} == 'process' --><i class="icon icon-play"></i><!-- ENDIF -->
			<!-- IF {STAGENAV_ROW_STATUS} == 'claim' --><i class="icon icon-warning-sign"></i><!-- ENDIF -->
			<!-- IF {STAGENAV_ROW_STATUS} == 'done' --><i class="icon icon-check"></i><!-- ENDIF -->
			<br/><b>{STAGENAV_ROW_TITLE}</b>
		</a>
	</li>
	<!-- END: STAGENAV_ROW -->
</ul>
		
<!-- BEGIN: SBR -->	

<!-- BEGIN: INFO -->
<div class="block">
	<div>
		<h3>{PHP.L.sbr_info}</h3>
		<table class="table customform">
			<tr>
				<td class="width30"><b>{PHP.L.sbr_employer}</b></td>
				<td class="width70"><a href="{SBR_EMPLOYER_DETAILSLINK}" target="blank">{SBR_EMPLOYER_NICKNAME}</a></td>
			</tr>
			<tr>
				<td class="width30"><b>{PHP.L.sbr_performer}</b></td>
				<td class="width70"><a href="{SBR_PERFORMER_DETAILSLINK}" target="blank">{SBR_PERFORMER_NICKNAME}</a></td>
			</tr>
			<tr>
				<td class="width30"><b>{PHP.L.sbr_calc_summ}</b></td>
				<td class="width70"><span id="summ">{SBR_COST}</span> {PHP.cfg.payments.valuta}</td>
			</tr>
			<!-- IF {PHP.role} == 'employer' -->
			<tr>
				<td class="width30"><b>{PHP.L.sbr_calc_tax}</b></td>
				<td class="width70"><span id="taxsumm">{SBR_TAX}</span> {PHP.cfg.payments.valuta}</td>
			</tr>
			<tr>
				<td class="width30"><b>{PHP.L.sbr_calc_total}</b></td>
				<td><span id="total">{SBR_TOTAL}</span> {PHP.cfg.payments.valuta}</td>
			</tr>
			<!-- ENDIF -->
		</table>
	</div>		
	<div id="sbrstageslist">
		<!-- BEGIN: STAGE_ROW -->
		<div class="accordion" id="accordion2">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapsestage{STAGE_ROW_NUM}"><b>{PHP.L.sbr_stage} <span class="stagenum">{STAGE_ROW_NUM}</span>: {STAGE_ROW_TITLE}</b></a>		
				</div>
				<div id="collapsestage{STAGE_ROW_NUM}" class="accordion-body collapse in">
					<div class="accordion-inner">
						<p>
							<b>{PHP.L.sbr_stagecost}:</b> {STAGE_ROW_COST} {PHP.cfg.payments.valuta}, 
							<b>{PHP.L.sbr_stagedays}:</b> {STAGE_ROW_DAYS|cot_declension($this, 'Days')}
						</p>
						<p>{STAGE_ROW_TEXT}</p>
						<!-- BEGIN: FILES -->	
						<b>{PHP.L.sbr_stagefiles}</b>
						<ol class="fileslist">
							<!-- BEGIN: FILE_ROW -->
							<li>
								<a href="{FILE_ROW_URL}" target="blank">{FILE_ROW_TITLE}</a>
							</li>
							<!-- END: FILE_ROW -->
						</ol>
						<!-- END: FILES -->	
					</div>
				</div>
			</div>
		</div>
		<!-- END: STAGE_ROW -->
	</div>
	<hr/>
	<div>
		<!-- BEGIN: EMPLOYER -->

		<!-- IF {SBR_STATUS} == 'new' -->
		<a href="{PHP.id|cot_url('sbr', 'm=edit&id='$this)}" class="btn btn-info">{PHP.L.sbr_action_edit}</a>
		<a href="{PHP.id|cot_url('sbr', 'a=cancel&id='$this)}" class="btn btn-warning">{PHP.L.sbr_action_cancel}</a>
		<!-- ENDIF -->

		<!-- IF {SBR_STATUS} == 'refuse' -->
		<a href="{PHP.id|cot_url('sbr', 'm=edit&id='$this)}" class="btn btn-info">{PHP.L.sbr_action_edit}</a>
		<a href="{PHP.id|cot_url('sbr', 'a=cancel&id='$this)}" class="btn btn-warning">{PHP.L.sbr_action_cancel}</a>
		<!-- ENDIF -->

		<!-- IF {SBR_STATUS} == 'confirm' -->
		<a href="{PHP.id|cot_url('sbr', 'a=pay&id='$this)}" class="btn btn-success">{PHP.L.sbr_action_pay}</a>
		<a href="{PHP.id|cot_url('sbr', 'a=cancel&id='$this)}" class="btn btn-warning">{PHP.L.sbr_action_cancel}</a>
		<!-- ENDIF -->

		<!-- END: EMPLOYER -->

		<!-- BEGIN: PERFORMER -->

		<!-- IF {SBR_STATUS} == 'new' -->
		<a href="{PHP.id|cot_url('sbr', 'a=confirm&id='$this)}" class="btn btn-success">{PHP.L.sbr_action_confirm}</a>
		<a href="{PHP.id|cot_url('sbr', 'a=refuse&id='$this)}" class="btn btn-info">{PHP.L.sbr_action_refuse}</a>
		<!-- ENDIF -->

		<!-- IF {SBR_STATUS} == 'confirm' -->
		<a href="{PHP.id|cot_url('sbr', 'a=refuse&id='$this)}" class="btn btn-info">{PHP.L.sbr_action_refuse}</a>
		<!-- ENDIF -->

		<!-- END: PERFORMER -->
	</div>
</div>
<!-- END: INFO -->

<!-- BEGIN: STAGE -->
<div class="block">
	<!-- IF {STAGE_BEGIN} > 0 AND {STAGE_STATUS} == 'process' -->
	<div class="pull-right">
		<!-- IF {PHP.role} == 'employer' -->
		<div class="btn-group pull-right">
			<a class="btn btn-warning dropdown-toggle" data-toggle="dropdown" href="#">
				{PHP.L.sbr_stagemenu}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a href="{STAGE_DONE_URL}">{PHP.L.sbr_action_stagedone}</a></li>
				<li><a href="{STAGE_CLAIM_URL}">{PHP.L.sbr_action_claim}</a></li>
			</ul>
		</div>
		<!-- ENDIF -->

		<!-- IF {PHP.role} == 'performer' -->
		<div class="btn-group pull-right">
			<a class="btn btn-warning" href="{STAGE_CLAIM_URL}">{PHP.L.sbr_action_claim}</a>
		</div>
		<!-- ENDIF -->
	</div>
	<!-- ENDIF -->
	
	<h3>{STAGE_TITLE}</h3>		
	<p>
		<b>{PHP.L.sbr_stagecost}:</b> {STAGE_COST} {PHP.cfg.payments.valuta}, 
		<b>{PHP.L.sbr_stagedays}:</b> {STAGE_DAYS|cot_declension($this, 'Days')}
	</p>
	<h4>{PHP.L.sbr_stagetext}</h4>
	<p>{STAGE_TEXT}</p>
	<!-- BEGIN: FILES -->
	<h4>{PHP.L.sbr_stagefiles}</h4>
	<ol class="fileslist">
		<!-- BEGIN: FILE_ROW -->
		<li>
			<a href="{FILE_ROW_URL}" target="blank">{FILE_ROW_TITLE}</a>
		</li>
		<!-- END: FILE_ROW -->
	</ol>
	<!-- END: FILES -->	
	<p>&nbsp;</p>
	
	<!-- IF {STAGE_BEGIN} > 0 AND {STAGE_STATUS} == 'process' -->
	<div class="alert alert-success">
		<b>{PHP.L.sbr_stagestart}:</b> {STAGE_BEGIN|date('d.m.Y H:i:s', $this)}<br/>
		<b>{PHP.L.sbr_stageexpiredays}:</b> <!-- IF {STAGE_EXPIREDATE} > {PHP.sys.now} -->{STAGE_EXPIREDAYS}<!-- ELSE -->{PHP.L.sbr_stageexpired}<!-- ENDIF -->
	</div>
	<!-- ENDIF -->

	<!-- IF {STAGE_STATUS} == 'claim' -->
	<div class="alert alert-danger">
		{PHP.L.sbr_claim_msg}
		<!-- IF {PHP.usr.isadmin} -->
		<a class="btn btn-danger pull-right" href="{STAGE_DECISION_URL}">{PHP.L.sbr_claim_decision_button}</a>
		<div class="clear"></div>
		<!-- ENDIF -->
	</div>
	<!-- ENDIF -->

	<!-- IF {STAGE_STATUS} == 'done' -->
	<div class="alert alert-info">
		<b>{PHP.L.sbr_stagestart}:</b> {STAGE_BEGIN|date('d.m.Y H:i:s', $this)}<br/>
		<b>{PHP.L.sbr_stagedone}:</b> {STAGE_DONE|date('d.m.Y H:i:s', $this)}
	</div>
	<!-- ENDIF -->
</div>
<!-- END: STAGE -->

<!-- BEGIN: POSTS -->		
<div>
	<h3>{PHP.L.sbr_history}</h3>
	<table class="table table-striped">
	<!-- BEGIN: POST_ROW -->
	<tr<!-- IF {POST_ROW_TYPE} --> class="{POST_ROW_TYPE}"<!-- ENDIF -->>
		<td>	
			<!-- IF {POST_ROW_FROM_ID} > 0 -->	
				<p><b>{POST_ROW_FROM_NAME}</b></p>
				<p>{POST_ROW_FROM_AVATAR}</p>
			<!-- ENDIF -->
		</td>
		<td>
			<p class="small">
			<b>{POST_ROW_DATE}</b> 
			<!-- IF {PHP.usr.isadmin} AND {POST_ROW_TO_NAME} -->
			{PHP.L.sbr_posts_for}: {POST_ROW_TO_NAME}</p>
			<!-- ENDIF -->
			</p>
			<p>{POST_ROW_TEXT}</p>
			
			<!-- BEGIN: FILES -->
				<br/>
				<b>{PHP.L.sbr_stagefiles}</b>
				<ol class="fileslist media-list">
					<!-- BEGIN: FILE_ROW -->
					<li class="media">
						<a href="{FILE_ROW_URL}" target="blank">{FILE_ROW_TITLE}</a>
					</li>
					<!-- END: FILE_ROW -->
				</ol>
			<!-- END: FILES -->
		</td>
	</tr>
	<!-- END: POST_ROW -->
	</table>
	<!-- BEGIN: POSTFORM -->
	<h4>{PHP.L.sbr_posts_add}</h4>
	{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
	<form action="{POST_FORM_ACTION}" method="post" id="addpost" enctype="multipart/form-data">
		<p><textarea name="rposttext" rows="5" class="width95">{PHP.rposttext}</textarea></p>
		<div class="postfiles">
			<ol class="fileslist">
			</ol>
			<a href="javascript:void(0);" onclick="PostFileAdd(this); return false;">Прикрепить файл</a>
		</div>
		<!-- IF {PHP.usr.isadmin} -->
		<p>{PHP.L.sbr_posts_to}: {POST_FORM_TO}</p>
		<!-- ENDIF -->
		<button class="btn btn-info">{PHP.L.Submit}</button>
	</form>
	<!-- END: POSTFORM -->
</div>

<script>
	
	function PostFileAdd(obj)
	{
		$(obj).parent().children('.fileslist').append('<li>\n\
			<a href="javascript:void(0);" onclick="PostFileRemove(this); return false;" class="pull-right"><i class="icon icon-remove"></i></a>\n\
			<input type="file" name="rpostfiles[]" />\n\
		</li>');
	}
	
	function PostFileRemove(obj)
	{
		$(obj).parent().remove();
	}

</script>

<!-- END: POSTS -->

<!-- END: SBR -->

<!-- BEGIN: STAGEDONE -->

<h1>{PHP.L.sbr_stage_done_title}</h1>
{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
<form action="{STAGEDONE_FORM_ACTION}" method="post" id="stagedoneform" class="customform">
	{STAGEDONE_FORM_TEXT}
	<button class="btn btn-info">{PHP.L.Submit}</button>
</form>

<!-- END: STAGEDONE -->

<!-- BEGIN: CLAIM -->

<h1>{PHP.L.sbr_claim_add_title}</h1>
{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
<form action="{CLAIM_FORM_ACTION}" method="post" id="claimform" class="customform">
	{CLAIM_FORM_TEXT}
	<button class="btn btn-info">{PHP.L.Submit}</button>
</form>

<!-- END: CLAIM -->

<!-- BEGIN: DECISION -->

<h1>{PHP.L.sbr_claim_decision_title}</h1>
{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
<form action="{DECISION_FORM_ACTION}" method="post" id="decisionform" class="customform">
	<table class="table">
		<tr>
			<td colspan="2">{DECISION_FORM_TEXT}</td>
		</tr>
		<tr>
			<td class="span3">{PHP.L.sbr_claim_decision_pay_performer}:</td>
			<td>{DECISION_FORM_PAYPERFORMER} {PHP.cfg.payments.valuta}</td>
		</tr>
		<tr>
			<td class="span3">{PHP.L.sbr_claim_decision_pay_employer}:</td>
			<td>{DECISION_FORM_PAYEMPLOYER} {PHP.cfg.payments.valuta}</td>
		</tr>
	</table>
	<button class="btn btn-danger">{PHP.L.Submit}</button>
</form>

<!-- END: DECISION -->

<!-- END: MAIN -->