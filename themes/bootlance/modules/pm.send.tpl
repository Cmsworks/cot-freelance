<!-- BEGIN: MAIN -->

	<div class="breadcrumb">{PMSEND_TITLE}</div>
<!-- BEGIN: BEFORE_AJAX -->
		<div id="ajaxBlock">
<!-- END: BEFORE_AJAX -->

			<div class="block">
				<p class="small">{PHP.L.pmsend_subtitle}</p>
				<p class="paging">{PMSEND_INBOX}<span class="spaced">{PHP.cfg.separator}</span>{PMSEND_SENTBOX}<span class="spaced">{PHP.cfg.separator}</span>{PMSEND_SENDNEWPM}
				{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
				<form action="{PMSEND_FORM_SEND}" method="post" name="newmessage" id="mewmessage">
					<table class="table">
<!-- BEGIN: PMSEND_USERLIST -->
						<tr>
							<td class="width20">{PHP.L.Recipients}:</td>
							<td>
								{PMSEND_FORM_TOUSER}
								<p class="small">{PHP.themelang.pmsend.Sendmessagetohint}</p>
							</td>
						</tr>
<!-- END: PMSEND_USERLIST -->
						<tr>
							<td>{PHP.L.Subject}:</td>
							<td>{PMSEND_FORM_TITLE}</td>
						</tr>
						<tr>
							<td>{PHP.L.Message}:</td>
							<td>{PMSEND_FORM_TEXT}</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><input type="checkbox" class="checkbox"  name="fromstate" value="3" /> {PHP.L.pm_notmovetosentbox}</td>
						</tr>
						<tr>
							<td colspan="2" class="valid"><button class="btn btn-primary btn-small" type="submit">{PHP.L.Submit}</button></td>
						</tr>
					</table>
				</form>
			</div>
			<!-- IF {PMSEND_AJAX_MARKITUP} AND {PHP.cfg.pm.turnajax} -->
			<script type="text/javascript">
				$(document).ready(function() {$("textarea.editor").markItUp(mySettings);});
			</script>
			<!-- ENDIF -->

	<!-- BEGIN: AFTER_AJAX -->
		</div>
<!-- END: AFTER_AJAX -->

<!-- END: MAIN -->