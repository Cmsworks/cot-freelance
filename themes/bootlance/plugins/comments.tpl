<!-- BEGIN: MAIN -->
		<div class="block">
<!-- BEGIN: COMMENTS_TITLE -->
			<h2><a href="{COMMENTS_TITLE_URL}">{COMMENTS_TITLE}</a></h2>
<!-- END: COMMENTS_TITLE -->
			{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
<!-- BEGIN: COMMENTS_FORM_EDIT -->
			<form id="comments" name="comments" action="{COMMENTS_FORM_POST}" method="post">
				<table class="cells">
					<tr>
						<td class="width20"><b>{COMMENTS_POSTER_TITLE}:</b></td>
						<td class="width80">{COMMENTS_POSTER}</td>
					</tr>
					<tr>
						<td><b>{COMMENTS_IP_TITLE}:</b></td>
						<td>{COMMENTS_IP}</td>
					</tr>
					<tr>
						<td><b>{COMMENTS_DATE_TITLE}:</b></td>
						<td>{COMMENTS_DATE}</td>
					</tr>
					<tr>
						<td colspan="2">
							{COMMENTS_FORM_TEXT}
							<!-- IF {COMMENTS_FORM_PFS} -->{COMMENTS_FORM_PFS}<!-- ENDIF -->
							<!-- IF {COMMENTS_FORM_SFS} --><span class="spaced">{PHP.cfg.separator}</span>{COMMENTS_FORM_SFS}<!-- ENDIF -->
						</td>
					</tr>
					<tr>
						<td colspan="2" class="valid">
							<input type="submit" class="btn" value="{COMMENTS_FORM_UPDATE_BUTTON}">
						</td>
					</tr>
				</table>
			</form>
<!-- END: COMMENTS_FORM_EDIT -->
		</div>
<!-- END: MAIN -->

<!-- BEGIN: COMMENTS -->

		<a name="comments"></a>

		<div class="block" style="display:{COMMENTS_DISPLAY}">
		<br/>
		<br/>
		<div class="mboxHD comments">{PHP.L.comments_comments}</div>
<!-- BEGIN: COMMENTS_ROW -->
		<div class="row comment">
			<div class="span1">
				<p>{COMMENTS_ROW_AUTHOR_AVATAR}</p>
			</div>
			<div class="span8">
				<p><a href="{COMMENTS_ROW_URL}" id="c{COMMENTS_ROW_ID}">{COMMENTS_ROW_ORDER}.</a> {COMMENTS_ROW_AUTHOR} | {COMMENTS_ROW_DATE}</p>
				<p>{COMMENTS_ROW_TEXT}</p>
				{COMMENTS_ROW_ADMIN}{COMMENTS_ROW_EDIT}
			</div>
			<div class="span9"><hr class="clear divider" /></div>
		</div>
<!-- END: COMMENTS_ROW -->

<!-- BEGIN: PAGNAVIGATOR -->
		<!-- IF {COMMENTS_PAGES_PAGNAV} -->
		<p class="pagination"><ul>{COMMENTS_PAGES_PAGESPREV}{COMMENTS_PAGES_PAGNAV}{COMMENTS_PAGES_PAGESNEXT}</ul></p>
		<p class="pagin"><span>{COMMENTS_PAGES_INFO}</span></p>
		<!-- ENDIF -->
<!-- END: PAGNAVIGATOR -->

<!-- BEGIN: COMMENTS_NEWCOMMENT -->
		<div class="mboxHD comments">{PHP.L.Newcomment}</div>
		{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
		<form action="{COMMENTS_FORM_SEND}" method="post" name="newcomment">
			<!-- BEGIN: GUEST -->
			<div>{PHP.L.Name}: {COMMENTS_FORM_AUTHOR}</div>
			<!-- END: GUEST -->
			<div>
				{COMMENTS_FORM_TEXT}
				<!-- IF {COMMENTS_FORM_PFS} -->{COMMENTS_FORM_PFS}<!-- ENDIF -->
				<!-- IF {COMMENTS_FORM_SFS} --><span class="spaced">{PHP.cfg.separator}</span>{COMMENTS_FORM_SFS}<!-- ENDIF -->
			</div>

			<!-- IF {PHP.usr.id} == 0 AND {COMMENTS_FORM_VERIFYIMG} -->
			<div>{COMMENTS_FORM_VERIFYIMG}: {COMMENTS_FORM_VERIFY}</div>
			<!-- ENDIF -->
			<div class="margin10 textcenter">
				<button type="submit" class="btn">{PHP.L.Submit}</button>
			</div>
		</form>
		<div class="help">{COMMENTS_FORM_HINT}</div>
<!-- END: COMMENTS_NEWCOMMENT -->

<!-- BEGIN: COMMENTS_EMPTY -->
		<div class="warning">{COMMENTS_EMPTYTEXT}</div>
<!-- END: COMMENTS_EMPTY -->

<!-- BEGIN: COMMENTS_CLOSED -->
		<div class="error">{COMMENTS_CLOSED}</div>
<!-- END: COMMENTS_CLOSED -->
	</div>

<!-- END: COMMENTS -->