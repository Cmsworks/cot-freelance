<!-- BEGIN: FOLIO -->
<div class="mboxHD">{PHP.L.folio} </div>
<div id="listfolio">
	<!-- BEGIN: PRD_ROWS -->
	<div class="media">
		<!-- IF {PRD_ROW_MAVATAR.1} -->
		<div class="pull-left">
			<a href="{PRD_ROW_URL}"><div class="thumbnail"><img src="{PRD_ROW_MAVATAR.1|cot_mav_thumb($this, 100, 100, crop)}" /></div></a>
		</div>
		<!-- ENDIF -->
		<h4><!-- IF {PRD_ROW_COST} > 0 --><div class="cost pull-right">{PRD_ROW_COST} {PHP.cfg.payments.valuta}</div><!-- ENDIF --><a href="{PRD_ROW_URL}">{PRD_ROW_SHORTTITLE}</a></h4>
		<p class="owner">{PRD_ROW_OWNER_NAME} <span class="date">[{PRD_ROW_DATE}]</span> &nbsp;{PRD_ROW_COUNTRY} {PRD_ROW_REGION} {PRD_ROW_CITY} &nbsp; {PRD_ROW_EDIT_URL}</p>
		<p class="text">{PRD_ROW_SHORTTEXT}</p>
		<p class="type"><a href="{PRD_ROW_CATURL}">{PRD_ROW_CATTITLE}</a></p>
	</div>
	<!-- END: PRD_ROWS -->
</div>
<div class="pagination"><ul>{PAGENAV_PAGES}</ul></div>
<!-- END: FOLIO -->