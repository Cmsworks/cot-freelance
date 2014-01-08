<!-- BEGIN: MAIN -->

	<div class="block">
		<h2>{MESSAGE_TITLE}</h2>
		<div class="alert alert-error">
			{MESSAGE_BODY}
			<!-- BEGIN: MESSAGE_CONFIRM -->
			<table class="inline" style="width:80%">
				<tr>
					<td><a id="confirmYes" href="{MESSAGE_CONFIRM_YES}" class="confirmButton">{PHP.L.Yes}</a></td>
					<td><a id="confirmNo" href="{MESSAGE_CONFIRM_NO}" class="confirmButton">{PHP.L.No}</a></td>
				</tr>
			</table>
			<!-- END: MESSAGE_CONFIRM -->
		</div>
	</div>

<!-- END: MAIN -->