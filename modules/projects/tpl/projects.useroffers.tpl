<!-- BEGIN: MAIN -->
<div class="breadcrumb">{BREADCRUMBS}</div>
<h1>{PHP.L.offers_useroffers}</h1>

<ul class="nav nav-tabs" id="myTab">
	<li<!-- IF !{PHP.choise} --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('projects', 'm=useroffers')}">{PHP.L.All}</a></li>
	<li<!-- IF {PHP.choise} == 'none' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('projects', 'm=useroffers&choise=none')}">{PHP.L.offers_useroffers_none}</a></li>
	<li<!-- IF {PHP.choise} == 'performer' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('projects', 'm=useroffers&choise=performer')}">{PHP.L.offers_useroffers_performer}</a></li>
	<li<!-- IF {PHP.choise} == 'refuse' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('projects', 'm=useroffers&choise=refuse')}">{PHP.L.offers_useroffers_refuse}</a></li>
</ul>

<!-- BEGIN: OFFER_ROWS -->
<div class="row">
	<div class="span12">		
		<div class="media<!-- IF {OFFER_ROW_PROJECT_ISBOLD} --> well prjbold<!-- ENDIF --><!-- IF {OFFER_ROW_PROJECT_ISTOP} --> well prjtop<!-- ENDIF -->">
			<h4>
				<!-- IF {OFFER_ROW_PROJECT_COST} > 0 --><div class="pull-right">{OFFER_ROW_PROJECT_COST} {PHP.cfg.payments.valuta}</div><!-- ENDIF -->
				<a href="{OFFER_ROW_PROJECT_URL}">{OFFER_ROW_PROJECT_SHORTTITLE}</a>
			</h4>
			<p class="owner small">{OFFER_ROW_PROJECT_OWNER_NAME} <span class="date">[{OFFER_ROW_PROJECT_DATE}]</span>   <span class="region">{OFFER_ROW_PROJECT_COUNTRY} {OFFER_ROW_PROJECT_REGION} {OFFER_ROW_PROJECT_CITY}</span></p>
			<p class="text">{OFFER_ROW_PROJECT_SHORTTEXT}</p>
			<div class="pull-right offers"><a href="{OFFER_ROW_PROJECT_OFFERS_ADDOFFER_URL}">{PHP.L.offers_add_offer}</a> ({OFFER_ROW_PROJECT_OFFERS_COUNT})</div>
			<div class="type"><!-- IF {OFFER_ROW_PROJECT_TYPE} -->{OFFER_ROW_PROJECT_TYPE} / <!-- ENDIF --><a href="{OFFER_ROW_PROJECT_CATURL}">{OFFER_ROW_PROJECT_CATTITLE}</a></div>
			<hr/>
			<div class="row">
				<div class="span9">
					<p>{OFFER_ROW_TEXT}</p>
				</div>
				<div class="span3">
					<p>
						{PHP.L.Date}: {OFFER_ROW_DATE}
					</p>
					<p class="cost">
						<!-- IF {OFFER_ROW_COSTMAX} > {OFFER_ROW_COSTMIN} AND {OFFER_ROW_COSTMIN} != 0 -->
						{PHP.L.offers_budget}: {PHP.L.offers_ot} {OFFER_ROW_COSTMIN}
						{PHP.L.offers_do} {OFFER_ROW_COSTMAX} {PHP.cfg.payments.valuta}
						<!-- ENDIF -->
						<!-- IF {OFFER_ROW_COSTMAX} == {OFFER_ROW_COSTMIN} AND {OFFER_ROW_COSTMIN} != 0 OR {OFFER_ROW_COSTMAX} == 0 AND {OFFER_ROW_COSTMIN} != 0 -->
						{PHP.L.offers_budget}: {OFFER_ROW_COSTMIN} {PHP.cfg.payments.valuta}
						<!-- ENDIF -->
					</p>
					<p class="time">
						<!-- IF {OFFER_ROW_TIMEMAX} > {OFFER_ROW_TIMEMIN} AND {OFFER_ROW_TIMEMIN} != 0 -->
						{PHP.L.offers_sroki}: {PHP.L.offers_ot} 
						{OFFER_ROW_TIMEMIN} {PHP.L.offers_do} {OFFER_ROW_TIMEMAX} {OFFER_ROW_TIMETYPE}
						<!-- ENDIF -->
						<!-- IF {OFFER_ROW_TIMEMAX} == {OFFER_ROW_TIMEMIN} AND {OFFER_ROW_TIMEMIN} != 0 OR {OFFER_ROW_TIMEMAX} == 0 AND {OFFER_ROW_TIMEMIN} != 0 -->
						{PHP.L.offers_sroki}: {OFFER_ROW_TIMEMIN} {OFFER_ROW_TIMETYPE}
						<!-- ENDIF -->
					</p>
					<p>
						<!-- IF {OFFER_ROW_CHOISE} -->
							<!-- IF {OFFER_ROW_CHOISE} == 'performer' -->
							<span class="label label-success">{PHP.L.offers_vibran_ispolnitel}</span>
							<!-- ELSE -->
							<span class="label label-warning">{PHP.L.offers_otkazali}</span>
							<!-- ENDIF -->
						<!-- ELSE -->
							<span class="label">{PHP.L.offers_useroffers_none}</span>
						<!-- ENDIF -->
					</p>
				</div>
			</div>
		</div>	
	</div>
</div>
<hr/>
<!-- END: OFFER_ROWS -->
<div class="pagination"><ul>{PAGENAV_PAGES}</ul></div>



<!-- END: MAIN -->


