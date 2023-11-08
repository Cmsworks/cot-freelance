<!-- BEGIN: MAIN -->

<h4>{PHP.L.simproducts}</h4>
<!-- BEGIN: SIMPRD_ROW -->
<div class="media">
	<!-- IF {SIMPRD_ROW_MAVATAR.1} -->
	<div class="pull-left">
		<a href="{SIMPRD_ROW_URL}"><div class="thumbnail"><img src="{SIMPRD_ROW_MAVATAR.1|cot_mav_thumb($this, 100, 100, crop)}" /></div></a>
	</div>
	<!-- ENDIF -->
	<div class="media-body">
		<h4 class="media-header"><a href="{SIMPRD_ROW_URL}">{SIMPRD_ROW_SHORTTITLE}</a></h4>
		<p class="text">{SIMPRD_ROW_SHORTTEXT}</p>
		<!-- IF {SIMPRD_ROW_COST} > 0 --><p>{SIMPRD_ROW_COST} {PHP.cfg.payments.valuta}</p><!-- ENDIF -->
	</div>
</div>
<!-- END: SIMPRD_ROW -->

<!-- END: MAIN -->