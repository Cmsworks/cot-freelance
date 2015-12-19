<!-- BEGIN: MAIN -->
<div class="reviews">
	<h4>{PHP.L.reviews_reviews}</h4>
	<!-- BEGIN: REVIEWS_ROWS -->
		<div class="row">
			<div class="span1">{REVIEW_ROW_AVATAR}</div>
			<div class="span8">
				<div class="pull-right score">{REVIEW_ROW_SCORE}</div>
				<div class="owner">{REVIEW_ROW_OWNER}</div>
				<!-- IF {REVIEW_ROW_AREA} == 'projects' -->
				<p class="small">{PHP.L.reviews_reviewforproject}: <a href="{REVIEW_ROW_PRJ_URL}">{REVIEW_ROW_PRJ_SHORTTITLE}</a></p>
				<!-- ENDIF -->
				<p>{REVIEW_ROW_TEXT}</p>
				<p class="small">{REVIEW_ROW_DATE|date('d.m.Y H:i', $this)}</p>
				<!-- IF {REVIEW_ROW_DELETE_URL} --><div class="edit"><a href="{REVIEW_ROW_DELETE_URL}">{PHP.L.Delete}</a></div><!-- ENDIF -->
				<!-- IF {PHP.usr.id} > 0 AND {PHP.usr.id} == {REVIEW_ROW_OWNERID} --><div class="edit"><a onClick="$('#ReviewEditModal{REVIEW_ROW_ID}').modal(); return false;" href="{REVIEW_ROW_EDIT_URL}">{PHP.L.Edit}</a></div><!-- ENDIF -->
			</div>
		</div>
	
		<!-- BEGIN: EDITFORM -->
		<div id="ReviewEditModal{REVIEW_FORM_ID}" class="modal hide fade">
			<div class="modal-header">
				<h3 id="myModalLabel">{PHP.L.reviews_edit_review}</h3>
				<div class="modal-body">
					<div class="customform">
						<form action="{REVIEW_FORM_SEND}" method="post" name="newreview" enctype="multipart/form-data">
							<table class="table">
								<tr>
									<td style="width:176px;">{PHP.L.reviews_text}:</td>
									<td>{REVIEW_FORM_TEXT}</td>
								</tr>
								<tr>
									<td>{PHP.L.reviews_score}:</td>
									<td>{REVIEW_FORM_SCORE}</td>
								</tr>
								<tr>
									<td></td>
									<td>
										<input type="submit" value="{PHP.L.Edit}" class="btn btn-success" />
										<a href="{REVIEW_FORM_DELETE_URL}" class="btn btn-warning">{PHP.L.Delete}</a>	   
									</td>
								</tr>
							</table>
						</form>
					</div>	
				</div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
				</div>
			</div>
		</div>
		<!-- END: EDITFORM -->	
	
		<hr/>
	<!-- END: REVIEWS_ROWS -->
</div>

{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}

<!-- BEGIN: FORM -->
	<div class="mboxHD"><!-- IF {REVIEW_FORM_ACTION} == "EDIT" -->{PHP.L.reviews_edit_review}<!-- ELSE -->{PHP.L.reviews_add_review}<!-- ENDIF --></div>
	<div class="customform">
		<form action="{REVIEW_FORM_SEND}" method="post" name="newreview" enctype="multipart/form-data">
			<table class="table">
				<!-- IF {REVIEW_FORM_PROJECTS} -->
				<tr>
					<td colspan="2"><div class="alert">{PHP.L.reviews_projectsonly}</div></td>
				</tr>
				<tr>
					<td style="width:150px;">{PHP.L.reviews_chooseprj}:</td>
					<td>{REVIEW_FORM_PROJECTS}</td>
				</tr>
				<!-- ENDIF -->
				<tr>
					<td style="width:150px;">{PHP.L.reviews_text}:</td>
					<td>{REVIEW_FORM_TEXT}</td>
				</tr>
				<tr>
					<td>{PHP.L.reviews_score}:</td>
					<td>{REVIEW_FORM_SCORE}</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input class="btn" type="submit" value="<!-- IF {REVIEW_FORM_ACTION} == "EDIT" -->{PHP.L.Edit}<!-- ELSE -->{PHP.L.Add}<!-- ENDIF -->" />
						<!-- IF {REVIEW_FORM_ACTION} == "EDIT" --> <a href="{REVIEW_FORM_DELETE_URL}">{PHP.L.Delete}</a><!-- ENDIF -->	   
					</td>
				</tr>
			</table>
		</form>
	</div>
<!-- END: FORM -->
<!-- END: MAIN -->