<!-- BEGIN: MAIN -->
<div class="reviews">
	<!-- BEGIN: REVIEW_ROW -->
		<div class="row">
			<div class="span1">{REVIEW_ROW_OWNER_AVATAR}</div>
			<div class="span8">
				<div class="pull-right score">{REVIEW_ROW_SCORE}</div>
				<div class="owner">{REVIEW_ROW_OWNER_NAME} &rarr; {REVIEW_ROW_TO_NAME}</div>
				<!-- IF {REVIEW_ROW_AREA} == 'projects' -->
				<p class="small">{PHP.L.reviews_reviewforproject}: <a href="{REVIEW_ROW_PRJ_URL}">{REVIEW_ROW_PRJ_SHORTTITLE}</a></p>
				<!-- ENDIF -->
				<p>{REVIEW_ROW_TEXT}</p>
				<p class="small">{REVIEW_ROW_DATE|date('d.m.Y H:i', $this)}</p>
			</div>
		</div>	
		<hr/>
	<!-- END: REVIEW_ROW -->
</div>
<!-- END: MAIN -->