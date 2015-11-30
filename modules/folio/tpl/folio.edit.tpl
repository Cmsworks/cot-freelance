<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PHP.L.folio_edit_work_title}</div>
<div class="customform">
	{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
	<form action="{PRDEDIT_FORM_SEND}" method="post" name="edit" enctype="multipart/form-data">
		<table class="table">
			<tr>
				<td align="right" style="width:176px;">{PHP.L.Category}</td>
				<td>{PRDEDIT_FORM_CAT}</td>
			</tr>
			<tr>
				<td align="right">{PHP.L.Title}:</td>
				<td>{PRDEDIT_FORM_TITLE}</td>
			</tr>	
			<tr>
				<td align="right">{PHP.L.Alias}:</td>
				<td>{PRDEDIT_FORM_ALIAS}</td>
			</tr>			
			<tr>
				<td align="right">{PHP.L.folio_location}:</td>
				<td>{PRDEDIT_FORM_LOCATION}</td>
			</tr>
			<tr<!-- IF !{PHP.usr.isadmin} --> class="hidden"<!-- ENDIF -->>
				<td align="right">{PHP.L.Parser}:</td>
				<td>{PRDEDIT_FORM_PARSER}</td>
			</tr>
			<tr>
				<td align="right">{PHP.L.Text}:</td>
				<td>{PRDEDIT_FORM_TEXT}</td>
			</tr>
			<!-- BEGIN: TAGS -->
					<tr>
						<td>{PRDEDIT_FORM_TAGS_TITLE}:</td>
						<td>{PRDEDIT_FORM_TAGS} ({PRDEDIT_FORM_TAGS_HINT})</td>
					</tr>
			<!-- END: TAGS -->
			<tr>
				<td align="right">{PHP.L.folio_price}:</td>
				<td>{PRDEDIT_FORM_COST} {PHP.cfg.payments.valuta}</td>
			</tr>
			<tr>
				<td align="right">{PHP.L.Image}:</td>
				<td>{PRDEDIT_FORM_MAVATAR}</td>
			</tr>
			<tr>
				<td align="right">{PHP.L.Delete}</td>
				<td>{PRDEDIT_FORM_DELETE}</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" class="btn btn-info" value="{PHP.L.Submit}" />
				</td>
			</tr>
		</table>
	</form>
</div>

<!-- END: MAIN -->