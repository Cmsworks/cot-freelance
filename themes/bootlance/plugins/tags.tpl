<!-- BEGIN: MAIN -->

	<div class="row">
		<div class="span12">
			<div class="block">
				<div class="mboxHD">{PHP.L.tags_Search_tags}</div>
				<form action="{TAGS_ACTION}" method="post" class="form-inline">
					<input type="text" name="t" value="{TAGS_QUERY}" />
					<input type="submit" class="btn" value="&raquo;&raquo;" />
					<select name="order">
						<option value="">{PHP.L.tags_Orderby}</option>
						<option value="">--</option>
						{TAGS_ORDER}
					</select>
				</form>
			</div>
			
			
			<div class="alert alert-info">
				<div class="mboxHD">{PHP.L.Tags}</div>
				{TAGS_HINT}
			</div>
			
			
			<!-- BEGIN: TAGS_CLOUD -->
			<div class="block">
				<div class="mboxHD">{PHP.L.tags_All}</div>
				{TAGS_CLOUD_BODY}
			</div>
			<!-- END: TAGS_CLOUD -->
			<!-- BEGIN: TAGS_RESULT -->
			<div class="block">
				<div class="mboxHD">{TAGS_RESULT_TITLE}</div>
				<ol>
					<!-- BEGIN: TAGS_RESULT_ROW -->
					<li class="marginbottom10">
						<span class="strong"><a href="{TAGS_RESULT_ROW_URL}">{TAGS_RESULT_ROW_TITLE}</a></span><br />
						<span class="small">{PHP.L.Sections}: {TAGS_RESULT_ROW_PATH}<br />
						{PHP.L.Tags}: {TAGS_RESULT_ROW_TAGS}</span>
						<!-- IF {TAGS_RESULT_ROW_TEXT_CUT} -->
						<p>{TAGS_RESULT_ROW_TEXT_CUT}</p>
						<!-- ENDIF -->
					</li>
					<!-- END: TAGS_RESULT_ROW -->
				</ol>
				<!-- BEGIN: TAGS_RESULT_NONE -->
				<div class="error">
					{PHP.L.Noitemsfound}
				</div>
				<!-- END: TAGS_RESULT_NONE -->
			</div>
			<!-- END: TAGS_RESULT -->
			<!-- IF {TAGS_PAGNAV} --><p class="paging">{TAGS_PAGEPREV}{TAGS_PAGNAV}{TAGS_PAGENEXT}</p><!-- ENDIF -->
		</div>
	</div>

<!-- END: MAIN -->