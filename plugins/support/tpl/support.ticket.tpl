<!-- BEGIN: MAIN -->

<div class="breadcrumb">{SUPPORT_TITLE}</div>

<!-- IF {TICKET_STATUS} == 'open' -->
<a class="pull-right btn btn-info" href="{TICKET_CLOSE_URL}">{PHP.L.support_tickets_close_button}</a>
<!-- ENDIF -->

<h1>{TICKET_TITLE}</h1>
<p>{PHP.L.support_tickets_number} #{TICKET_ID} | {TICKET_DATE|date('d.m.Y H:i:s', $this)}</p>	

<!-- BEGIN: CLOSED -->
<div class="alert alert-info">{PHP.L.support_tickets_closed_alert}</div>
<!-- END: CLOSED -->

<table class="table table-striped">
<!-- BEGIN: MSG_ROW -->
<tr>
	<td>
		<div class="media" id="msg{MSG_ROW_ID}">
			<a class="pull-left thumbnail" href="{MSG_ROW_USER_DETAILSLINK}">
				{MSG_ROW_USER_AVATAR}
			</a>
			<div class="media-body">
				<div class="pull-right small">{MSG_ROW_DATE|cot_date('d.m.Y H:i:s' ,$this)}</div>
				<p><b><!-- IF {MSG_ROW_USER_ID} -->{MSG_ROW_USER_NAME}<!-- ELSE -->{PHP.L.Guest}<!-- ENDIF --></b></p>
				<p>{MSG_ROW_TEXT}</p>
			</div>
		</div>
		<br/>
	</td>
</tr>
<!-- END: MSG_ROW -->
</table>

<!-- BEGIN: MSGWAIT -->
<i class="text text-success">{PHP.L.support_tickets_wait_alert}</i>
<!-- END: MSGWAIT -->

<!-- BEGIN: MSGFORM -->
{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
<form action="{MSG_FORM_SEND}" enctype="multipart/form-data" method="post" name="msgform" id="msgform">
	<p>{MSG_FORM_TEXT}{MSG_FORM_MYPFS}</p>
	<p>
	<button type="submit" name="submit" class="btn btn-success" value="send">{PHP.L.Submit}</button>
	</p>
</form>
<!-- END: MSGFORM -->

<!-- END: MAIN -->