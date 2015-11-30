<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PHP.L.projects_add_project_title}</div>

{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
<div class="customform">
	<form action="{PRJADD_FORM_SEND}" method="post" name="newadv" enctype="multipart/form-data">
		<table class="table">
			<!-- IF {PHP.projects_types} -->
			<tr>
				<td>{PHP.L.Type}:</td>
				<td>{PRJADD_FORM_TYPE}</td>
			</tr>
			<!-- ENDIF -->
			<tr>
				<td width="150">{PHP.L.Category}:</td>
				<td>{PRJADD_FORM_CAT}</td>
			</tr>			
			<tr>
				<td>{PHP.L.Location}:</td>
				<td>{PRJADD_FORM_LOCATION}</td>
			</tr>			
			<tr>
				<td>{PHP.L.Title}:</td>
				<td>{PRJADD_FORM_TITLE}</td>
			</tr>
			<tr>
				<td>{PHP.L.Alias}:</td>
				<td>{PRJADD_FORM_ALIAS}</td>
			</tr>
			<tr<!-- IF !{PHP.usr.isadmin} --> class="hidden"<!-- ENDIF -->>
				<td align="right">{PHP.L.Parser}:</td>
				<td>{PRJADD_FORM_PARSER}</td>
			</tr>
			<tr>
				<td class="top">{PHP.L.Text}:</td>
				<td>{PRJADD_FORM_TEXT}</td>
			</tr>
			<!-- BEGIN: TAGS -->
			<tr>
				<td>{PRJADD_FORM_TAGS_TITLE}:</td>
				<td>{PRJADD_FORM_TAGS} ({PRJADD_FORM_TAGS_HINT})</td>
			</tr>
			<!-- END: TAGS -->
			<tr>
				<td>{PHP.L.projects_price}:</td>
				<td><div class="input-append">{PRJADD_FORM_COST}<span class="add-on">{PHP.cfg.payments.valuta}</span></div></td>
			</tr>
			<!-- IF {PHP.cot_plugins_active.mavatars} -->
			<tr>
				<td>{PHP.L.Files}:</td>
				<td>
					{PRJADD_FORM_MAVATAR}
				</td>
			</tr>
			<!-- ENDIF -->
			<!-- IF {PHP.cot_plugins_active.paypro} -->
			<tr>
				<td>{PHP.L.paypro_forpro}:</td>
				<td>
					{PRJADD_FORM_FORPRO}
				</td>
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