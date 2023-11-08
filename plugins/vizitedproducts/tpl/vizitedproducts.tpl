<!-- BEGIN: MAIN -->

<h4>{PHP.L.vizitedproducts}</h4>
<!-- BEGIN: PRD_ROW -->
<div class="media">
	<!-- IF {PRD_ROW_MAVATAR.1} -->
	<div class="pull-left">
		<a href="{PRD_ROW_URL}"><div class="thumbnail"><img src="{PRD_ROW_MAVATAR.1|cot_mav_thumb($this, 100, 100, crop)}" /></div></a>
	</div>
	<!-- ENDIF -->
	<div class="media-body">
		<h4 class="media-header"><a href="{PRD_ROW_URL}">{PRD_ROW_SHORTTITLE}</a></h4>
		<!-- IF {PRD_ROW_COST} > 0 --><p>{PRD_ROW_COST} {PHP.cfg.payments.valuta}</p><!-- ENDIF -->
	</div>
</div>
<hr/>
<!-- END: PRD_ROW -->

<!-- END: MAIN -->