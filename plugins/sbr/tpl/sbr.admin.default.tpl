<!-- BEGIN: MAIN -->

<h3>{PHP.L.sbr}</h3>

<ul class="nav nav-tabs" id="myTab">
	<li<!-- IF !{PHP.status} --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('admin', 'm=other&p=sbr')}">{PHP.L.All}</a></li>
	<!-- BEGIN: STATUS_ROW -->
	<li<!-- IF {PHP.status} == {STATUS_ROW_ID} --> class="active"<!-- ENDIF -->><a href="{STATUS_ROW_ID|cot_url('admin', 'm=other&p=sbr&status='$this)}">{STATUS_ROW_TITLE}</a></li>
	<!-- END: STATUS_ROW -->
</ul>

<table class="table">
	<!-- BEGIN: SBR_ROW -->
	<tr>
		<td class="width5">{SBR_ROW_ID}</td>
		<td class="large"><a href="{SBR_ROW_URL}" target="blank">{SBR_ROW_SHORTTITLE}</a></td>
		<td class="width15"><!-- IF {CREATEDATE_STAMP} -->{SBR_ROW_CREATEDATE}<!-- ENDIF --></td>
		<td class="width20">{SBR_ROW_COST} {PHP.cfg.payments.valuta}</td>
		<td class="width20"><!-- IF !{PHP.status} --><span class="label label-{SBR_ROW_LABELSTATUS}">{SBR_ROW_LOCALSTATUS}</span><!-- ENDIF --></td>
	</tr>
	<!-- END: SBR_ROW -->
</table>
		
<!-- END: MAIN -->