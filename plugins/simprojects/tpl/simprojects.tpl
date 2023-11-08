<!-- BEGIN: MAIN -->

<h4>{PHP.L.simprojects}</h4>
<!-- BEGIN: SIMPRJ_ROW -->
<div class="media">
	<div class="media-body">
		<h4 class="media-header"><a href="{SIMPRJ_ROW_URL}">{SIMPRJ_ROW_SHORTTITLE}</a></h4>
		<p class="text">{SIMPRJ_ROW_SHORTTEXT}</p>
		<!-- IF {SIMPRJ_ROW_COST} > 0 --><p>{SIMPRJ_ROW_COST} {PHP.cfg.payments.valuta}</p><!-- ENDIF -->
	</div>
</div>
<!-- END: SIMPRJ_ROW -->

<!-- END: MAIN -->