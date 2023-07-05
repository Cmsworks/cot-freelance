<!-- BEGIN: MAIN -->

<div class="breadcrumb">{SBR_TITLE}</div>
<h1>{PHP.L.sbr_mydeals}</h1>

<ul class="nav nav-tabs">
	<li<!-- IF !{PHP.status} --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('sbr')}">{PHP.L.All} ({SBR_COUNTERS.all})</a></li>
	<li<!-- IF {PHP.status} == 'new' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('sbr','status=new')}">{PHP.L.sbr_deals_new} ({SBR_COUNTERS.new})</a></li>
	<li<!-- IF {PHP.status} == 'refuse' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('sbr','status=refuse')}">{PHP.L.sbr_deals_refuse} ({SBR_COUNTERS.refuse})</a></li>
	<li<!-- IF {PHP.status} == 'confirm' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('sbr','status=confirm')}">{PHP.L.sbr_deals_confirm} ({SBR_COUNTERS.confirm})</a></li>
	<li<!-- IF {PHP.status} == 'process' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('sbr','status=process')}">{PHP.L.sbr_deals_process} ({SBR_COUNTERS.process})</a></li>
	<li<!-- IF {PHP.status} == 'done' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('sbr','status=done')}">{PHP.L.sbr_deals_done} ({SBR_COUNTERS.done})</a></li>
	<li<!-- IF {PHP.status} == 'claim' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('sbr','status=claim')}">{PHP.L.sbr_deals_claim} ({SBR_COUNTERS.claim})</a></li>
	<li<!-- IF {PHP.status} == 'cancel' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('sbr','status=cancel')}">{PHP.L.sbr_deals_cancel} ({SBR_COUNTERS.cancel})</a></li>
</ul>
		
<table class="table">
	<!-- BEGIN: SBR_ROW -->
	<tr>
		<td class="width5">{SBR_ROW_ID}</td>
		<td class="large"><a href="{SBR_ROW_URL}">{SBR_ROW_SHORTTITLE}</a></td>
		<td class="width15"><!-- IF {CREATEDATE_STAMP} -->{SBR_ROW_CREATEDATE}<!-- ENDIF --></td>
		<td class="width20">{SBR_ROW_COST} {PHP.cfg.payments.valuta}</td>
		<td class="width20"><!-- IF !{PHP.status} --><span class="label label-{SBR_ROW_LABELSTATUS}">{SBR_ROW_LOCALSTATUS}</span><!-- ENDIF --></td>
	</tr>
	<!-- END: SBR_ROW -->
</table>

<!-- END: MAIN -->