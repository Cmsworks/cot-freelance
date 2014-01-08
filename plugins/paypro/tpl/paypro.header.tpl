<!-- BEGIN: MAIN -->
	<br/>
	<!-- IF {USER_ISPRO} -->
	{PHP.L.paypro_header_expire} {USER_PROEXPIRE|cot_date('d.m.Y', $this)}<br/><a href="{PHP|cot_url('plug', 'e=paypro')}">{PHP.L.paypro_header_extend}</a>
	<!-- ELSE -->
		<a href="{PHP|cot_url('plug', 'e=paypro')}">{PHP.L.paypro_header_buy}</a>
	<!-- ENDIF -->

<!-- END: MAIN -->