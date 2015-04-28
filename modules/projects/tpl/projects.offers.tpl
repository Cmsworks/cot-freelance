<!-- BEGIN: MAIN -->
{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
<!-- IF {PRJ_PERFORMER_ID} > 0 -->
<h4>{PHP.L.offers_vibran_ispolnitel}</h4>
<div class="well well-small">
	<div class="row">
		<div class="span1">
			{PRJ_PERFORMER_AVATAR}
		</div>
		<div class="span10">
			<p class="owner">{PRJ_PERFORMER_NAME}</p>
			<p>
				<!-- IF {PRJ_PERFORMER_ISPRO} -->
				<span class="label label-important">PRO</span> 
				<!-- ENDIF -->
				<span class="label label-info">{PRJ_PERFORMER_USERPOINTS}</span>
			</p>		
		</div>
	</div>
</div>
<!-- ENDIF -->

<!-- BEGIN: PROJECTFORPRO -->
<div class="alert alert-warning">{PHP.L.paypro_warning_onlyforpro}</div>
<!-- END: PROJECTFORPRO -->

<!-- BEGIN: OFFERSLIMITEMPTY -->
<div class="alert alert-warning">{PHP.L.paypro_warning_offerslimit_empty}</div>
<!-- END: OFFERSLIMITEMPTY -->

<div id="offers">	
	<h4>{PHP.L.offers_offers} ({ALLOFFERS_COUNT})</h4><br/>
	<!-- BEGIN: ROWS -->
	<div class="row">
		<div class="span1">
			{OFFER_ROW_OWNER_AVATAR}
		</div>
		<div class="span11">
			
			<!-- BEGIN: CHOISE -->
			<div class="pull-right">
				<div class="well span3">
					<!-- IF {OFFER_ROW_CHOISE} == "refuse" -->
					<p align="center">{PHP.L.offers_otkazali}!</p>
					<!-- ENDIF -->
					<!-- IF {OFFER_ROW_CHOISE} == "performer" -->
					<p align="center">{PHP.L.offers_vibran_ispolnitel}!</p>
					<!-- ENDIF -->
					<!-- IF {OFFER_ROW_CHOISE} != "refuse" -->
					<a href="{OFFER_ROW_REFUSE}" class="btn btn-warning btn-block">{PHP.L.offers_otkazat}</a> 
					<!-- ENDIF -->
					<!-- IF {OFFER_ROW_CHOISE} != "performer" AND {PERFORMER_USERID} == "" -->
					<a href="{OFFER_ROW_SETPERFORMER}" class="btn btn-success btn-block">{PHP.L.offers_ispolnitel}</a> 
					<!-- ENDIF -->
					<!-- IF {OFFER_ROW_CHOISE} != "refuse" AND {PHP.cot_plugins_active.sbr} -->
					<a href="{OFFER_ROW_SBRCREATELINK}" class="btn btn-primary btn-block">{PHP.L.sbr_createlink}</a> 
					<!-- ENDIF -->
				</div>
			</div>
			<!-- END: CHOISE -->
			
			<p class="owner">{OFFER_ROW_OWNER_NAME} <span class="date">[{OFFER_ROW_DATE}] &nbsp; {OFFER_ROW_EDIT}</span></p>
			<p>
				<!-- IF {OFFER_ROW_OWNER_ISPRO} -->
				<span class="label label-important">PRO</span> 
				<!-- ENDIF -->
				<span class="label label-info">{OFFER_ROW_OWNER_USERPOINTS}</span>
			</p>
			<p class="text">{OFFER_ROW_TEXT}</p>
			<p class="cost">
				<!-- IF {OFFER_ROW_COSTMAX} > {OFFER_ROW_COSTMIN} AND {OFFER_ROW_COSTMIN} != 0 -->
				{PHP.L.offers_budget}: {PHP.L.offers_ot} {OFFER_ROW_COSTMIN}
				{PHP.L.offers_do} {OFFER_ROW_COSTMAX} {PHP.cfg.payments.valuta}
				<!-- ENDIF -->
				<!-- IF {OFFER_ROW_COSTMAX} == {OFFER_ROW_COSTMIN} AND {OFFER_ROW_COSTMIN} != 0 OR {OFFER_ROW_COSTMAX} == 0 AND {OFFER_ROW_COSTMIN} != 0 -->
				{PHP.L.offers_budget}: {OFFER_ROW_COSTMIN} {PHP.cfg.payments.valuta}
				<!-- ENDIF -->
			</p>
			<p class="time">
				<!-- IF {OFFER_ROW_TIMEMAX} > {OFFER_ROW_TIMEMIN} AND {OFFER_ROW_TIMEMIN} != 0 -->
				{PHP.L.offers_sroki}: {PHP.L.offers_ot} 
				{OFFER_ROW_TIMEMIN} {PHP.L.offers_do} {OFFER_ROW_TIMEMAX} {OFFER_ROW_TIMETYPE}
				<!-- ENDIF -->
				<!-- IF {OFFER_ROW_TIMEMAX} == {OFFER_ROW_TIMEMIN} AND {OFFER_ROW_TIMEMIN} != 0 OR {OFFER_ROW_TIMEMAX} == 0 AND {OFFER_ROW_TIMEMIN} != 0 -->
				{PHP.L.offers_sroki}: {OFFER_ROW_TIMEMIN} {OFFER_ROW_TIMETYPE}
				<!-- ENDIF -->
			</p>
			<p class="text">
				<!-- IF {PHP.cot_plugins_active.mavatars} -->
					<!-- IF {OFFER_ROW_MAVATARCOUNT} -->
						<h5>{PHP.L.Files}:</h5>
						<ol class="files">
							<!-- FOR {KEY}, {VALUE} IN {OFFER_ROW_MAVATAR} -->
							<li><a href="{VALUE.FILE}">{VALUE.FILENAME}.{VALUE.FILEEXT}</a></li>
							<!-- ENDFOR -->
						</ol>
					<!-- ENDIF -->
				<!-- ENDIF -->
			</p>
			<!-- BEGIN: POSTS -->
			<h5>{PHP.L.offers_posts_title}</h5>
			<div id="projectsposts">
				<!-- BEGIN: POSTS_ROWS -->
				<div class="row">
					<div class="span1">{POST_ROW_OWNER_AVATAR}</div>
					<div class="span10">
						<p class="owner">{POST_ROW_OWNER_NAME} <span class="date">[{POST_ROW_DATE}] &nbsp; {POST_ROW_EDIT_URL}</span></p> 
						{POST_ROW_TEXT}
					</div>
				</div>
				<hr/>
				<!-- END: POSTS_ROWS -->

				<!-- BEGIN: POSTFORM -->
				<div class="postform customform" id="postform{ADDPOST_OFFERID}">
					<form action="{ADDPOST_ACTION_URL}" method="post">
						{ADDPOST_TEXT}<br/>
						<input type="submit" name="submit" class="btn" value="{PHP.L.Submit}" />
					</form>
				</div>
				<!-- END: POSTFORM -->
			</div>

			<!-- END: POSTS -->
			
		</div>
	</div>
	<!-- END: ROWS -->
</div>
					
<!-- IF {OFFERSNAV_COUNT} > 0 -->
<div class="pagination"><ul>{OFFERSNAV_PAGES}</ul></div>
<!-- ENDIF -->

<!-- IF {ALLOFFERS_COUNT} == 0 -->
<div class="alert">{PHP.L.offers_empty}</div>
<!-- ENDIF -->

<!-- BEGIN: ADDOFFERFORM -->
<h4>{PHP.L.offers_ostavit_predl}</h3>
<div id="addofferform" class="customform">
	<form action="{OFFER_FORM_ACTION_URL}" method="post" enctype="multipart/form-data">
		<table class="table">
			<tr>
				<td width="150" align="right">{PHP.L.offers_budget}:</td>
				<td>{PHP.L.offers_ot} {OFFER_FORM_COSTMIN}
					{PHP.L.offers_do} {OFFER_FORM_COSTMAX} {PHP.cfg.payments.valuta}</td>
			</tr>
			<tr>
				<td align="right">{PHP.L.offers_sroki}:</td>
				<td>{PHP.L.offers_ot} {OFFER_FORM_TIMEMIN} 
					{PHP.L.offers_do} {OFFER_FORM_TIMEMAX} {OFFER_FORM_TIMETYPE}</td>
			</tr>
			<tr>
				<td align="right" class="top">{PHP.L.offers_text_predl}:</td>
				<td>{OFFER_FORM_TEXT}</td>
			</tr>
			<!-- IF {PHP.cot_plugins_active.mavatars} -->
			<tr>
				<td align="right" class="top">{PHP.L.Files}:</td>
				<td>{OFFER_FORM_MAVATAR}</td>
			</tr>
			<!-- ENDIF -->
			<tr>
				<td align="left"></td>
				<td>
					<div class="pull-right">
						<input type="submit" name="submit" class="btn btn-success" value="{PHP.L.offers_add_predl}" />
					</div>
					{OFFER_FORM_HIDDEN}
				</td>
			</tr>
		</table>
	</form>
</div>
<!-- END: ADDOFFERFORM -->

<!-- IF {PHP.usr.id} == 0 -->
<div class="alert alert-warning">
	{PHP.L.offers_for_guest}
</div>
<!-- ENDIF -->

<!-- END: MAIN -->


