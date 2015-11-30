<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PHP.L.projects_edit_project_title}</div>

{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
<div class="customform">
	<form action="{PRJEDIT_FORM_SEND}" method="post" name="edit" enctype="multipart/form-data">
		<table class="table">
			<!-- IF {PHP.projects_types} -->
			<tr>
				<td>{PHP.L.Type}:</td>
				<td>{PRJEDIT_FORM_TYPE}</td>
			</tr>
			<!-- ENDIF -->
			<tr>
				<td width="150">{PHP.L.Category}:</td>
				<td>{PRJEDIT_FORM_CAT}</td>
			</tr>		
			<tr>
				<td>{PHP.L.Location}:</td>
				<td>{PRJEDIT_FORM_LOCATION}</td>
			</tr>
			<tr>
				<td>{PHP.L.Title}:</td>
				<td>{PRJEDIT_FORM_TITLE}</td>
			</tr>
			<tr>
				<td>{PHP.L.Alias}:</td>
				<td>{PRJEDIT_FORM_ALIAS}</td>
			</tr>
			<tr<!-- IF !{PHP.usr.isadmin} --> class="hidden"<!-- ENDIF -->>
				<td align="right">{PHP.L.Parser}:</td>
				<td>{PRJEDIT_FORM_PARSER}</td>
			</tr>
			<tr>
				<td class="top">{PHP.L.Text}:</td>
				<td>{PRJEDIT_FORM_TEXT}</td>
			</tr>
			<!-- BEGIN: TAGS -->
			<tr>
				<td>{PRJEDIT_FORM_TAGS_TITLE}:</td>
				<td>{PRJEDIT_FORM_TAGS} ({PRJEDIT_FORM_TAGS_HINT})</td>
			</tr>
			<!-- END: TAGS -->
			<tr>
				<td>{PHP.L.projects_price}:</td>
				<td><div class="input-append">{PRJEDIT_FORM_COST}<span class="add-on">{PHP.cfg.payments.valuta}</span></div></td>
			</tr>
			<!-- IF {PHP.cot_plugins_active.mavatars} -->
			<tr>
				<td>{PHP.L.Files}:</td>
				<td>{PRJEDIT_FORM_MAVATAR}</td>
			</tr>
			<!-- ENDIF -->
			<!-- IF {PHP.cot_plugins_active.paypro} -->
			<tr>
				<td>{PHP.L.paypro_forpro}:</td>
				<td>
					{PRJEDIT_FORM_FORPRO}
				</td>
			</tr>
			<!-- ENDIF -->
			<!-- IF {PHP.usr.isadmin} -->
			<tr>
				<td>{PHP.L.Delete}</td>
				<td>{PRJEDIT_FORM_DELETE}</td>
			</tr>
			<!-- ENDIF -->
			<tr>
				<td></td>
				<td>
					<input type="submit" class="btn btn-info" value="{PHP.L.projects_next}" />
				</td>
			</tr>
		</table>
	</form>
</div>

<!-- END: MAIN -->