<!-- BEGIN: MAIN -->

<div class="breadcrumb">{SUPPORT_TITLE}</div>

<h1>{PHP.L.support_tickets}</h1>
<!-- IF {PHP.tickets_open} == 0 OR !{PHP.cfg.plugin.support.onlyoneticket} -->
<a class="btn btn-success pull-right" href="{PHP|cot_url('support', 'm=newticket')}">{PHP.L.support_tickets_add_button}</a>
<!-- ENDIF -->
<ul class="nav nav-tabs">
	<li<!-- IF {PHP.status} == 'open' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('support','status=open')}">{PHP.L.support_tickets_open}</a></li>
	<li<!-- IF {PHP.status} == 'closed' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('support','status=closed')}">{PHP.L.support_tickets_closed}</a></li>	
	<li<!-- IF {PHP.status} == 'all' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('support', 'status=all')}">{PHP.L.All}</a></li>
</ul>

<!-- IF {PAGENAV_COUNT} > 0 -->
<table class="table table-striped">
	<thead>
		<tr>
			<th class="width5">ID</th>
			<th class="large">Заголовок обращения</th>
			<!-- IF {PHP.usr.isadmin} -->
			<th class="width10">Автор</th>
			<!-- ENDIF -->
			<th class="width20">Статус</th>
		</tr>
	</thead>
	<tbody>
		<!-- BEGIN: TICKET_ROW -->
		<tr>
			<td class="width5">#{TICKET_ROW_ID}</td>
			<td>
				<div class="large"><a href="{TICKET_ROW_URL}">{TICKET_ROW_TITLE} ({TICKET_ROW_COUNT})</a></div>
				<div class="small">{TICKET_ROW_DATE|cot_date('d.m H:i:s', $this)}</div>
			</td>
			<!-- IF {PHP.usr.isadmin} -->
			<td class="width15"><!-- IF {TICKET_ROW_USER_ID} -->{TICKET_ROW_USER_NAME}<!-- ELSE -->{PHP.L.Guest}<!-- ENDIF --></td>
			<!-- ENDIF -->
			<td class="width30">
				<!-- IF {TICKET_ROW_STATUS} == 'open' -->
					<!-- IF {PHP.usr.id} == {TICKET_ROW_USER_ID} -->
						<!-- IF {TICKET_ROW_COUNT} == 0 -->
						<b class="text text-warning">{PHP.L.support_tickets_new}</b>
						<div class="small">{TICKET_ROW_UPDATE|cot_build_timeago($this)}</div>
						<!-- ELSE -->
							<!-- IF {TICKET_ROW_USER_ID} == {TICKET_ROW_LASTPOSTER_ID} -->
							<b class="text text-warning">{PHP.L.support_tickets_notanswered}</b>
							<div class="small">{PHP.L.support_tickets_lastpost_from}: {TICKET_ROW_LASTPOSTER_NAME}, {PHP.L.support_tickets_lastpost_when}: {TICKET_ROW_UPDATE|cot_build_timeago($this)}</div>
							<!-- ELSE -->
							<b class="text text-success">{PHP.L.support_tickets_answer}</b>
							<div class="small">{PHP.L.support_tickets_lastpost_from}: {TICKET_ROW_LASTPOSTER_NAME}, {PHP.L.support_tickets_lastpost_when}: {TICKET_ROW_UPDATE|cot_build_timeago($this)}</div>
							<!-- ENDIF -->
						<!-- ENDIF -->
					<!-- ELSE -->
						<!-- IF {TICKET_ROW_COUNT} == 0 -->
						<b class="text text-warning">{PHP.L.support_tickets_new}</b>
						<div class="small">{TICKET_ROW_UPDATE|cot_build_timeago($this)}</div>
						<!-- ELSE -->
							<!-- IF {TICKET_ROW_USER_ID} == {TICKET_ROW_LASTPOSTER_ID} -->
							<b class="text text-warning">{PHP.L.support_tickets_waiting_answer}</b>
							<div class="small">{PHP.L.support_tickets_lastpost_from}: {TICKET_ROW_LASTPOSTER_NAME}, {PHP.L.support_tickets_lastpost_when}: {TICKET_ROW_UPDATE|cot_build_timeago($this)}</div>
							<!-- ELSE -->
							<b class="text text-success">{PHP.L.support_tickets_answered}</b>
							<div class="small">{PHP.L.support_tickets_lastpost_from}: {TICKET_ROW_LASTPOSTER_NAME}, {PHP.L.support_tickets_lastpost_when}: {TICKET_ROW_UPDATE|cot_build_timeago($this)}</div>
							<!-- ENDIF -->
						<!-- ENDIF -->
					<!-- ENDIF -->
				<!-- ELSE -->
					<b>{PHP.L.support_tickets_closed}</b>
					<div class="small">{TICKET_ROW_UPDATE|cot_build_timeago($this)}</div>
				<!-- ENDIF -->
			</td>
		</tr>
		<!-- END: TICKET_ROW -->
	</tbody>
</table>
<ul class="pagination">{PAGENAV_PREV}{PAGENAV_PAGES}{PAGENAV_NEXT}</ul>	
<!-- ELSE -->
<br/>
<div class="alert alert-warning">{PHP.L.None}</div>
<!-- ENDIF -->
		
<!-- END: MAIN -->