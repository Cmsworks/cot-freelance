<!-- BEGIN: LIST -->
<h2>{PHP.L.Modules}</h2>
<div class="row">
	<!-- BEGIN: ADMIN_STRUCTURE_EXT -->
	<div class="span3">
		<div class="thumbnail">
			<a href="{ADMIN_STRUCTURE_EXT_URL}">
				<!-- IF {ADMIN_STRUCTURE_EXT_ICO} --> 
				<img src="{ADMIN_STRUCTURE_EXT_ICO}" style="height: 32px!important;"/>
				<!-- ELSE -->
				<img src="{PHP.cfg.system_dir}/admin/img/plugins32.png" style="height: 32px!important;"/>
				<!-- ENDIF -->	
				{ADMIN_STRUCTURE_EXT_NAME}
			</a>
		</div>
		</br>
	</div>
	<!-- END: ADMIN_STRUCTURE_EXT -->
	<!-- BEGIN: ADMIN_STRUCTURE_EMPTY -->
	<div class="alert alert-info">{PHP.L.adm_listisempty}</div>
	<!-- END: ADMIN_STRUCTURE_EMPTY -->
</div>
<!-- END: LIST -->

<!-- BEGIN: MAIN -->
		<h2>{PHP.L.Structure}</h2>
		{FILE "{PHP.cfg.themes_dir}/admin/{PHP.cfg.admintheme}/warnings.tpl"}
		<div class="block btn-toolbar">
				<a href="{ADMIN_STRUCTURE_URL_EXTRAFIELDS}" class="btn btn-default">{PHP.L.adm_extrafields}</a>
				<a href="{ADMIN_PAGE_STRUCTURE_RESYNCALL}" class="ajax btn btn-default special" title="{PHP.L.adm_tpl_resyncalltitle}">{PHP.L.Resync}</a>
				<!-- IF {ADMIN_STRUCTURE_I18N_URL} -->
				<a href="{ADMIN_STRUCTURE_I18N_URL}" class="btn btn-default">{PHP.L.i18n_structure}</a>
				<!-- ENDIF -->
		</div>

		<!-- BEGIN: OPTIONS -->
		<div class="block">
			<form name="savestructure" id="savestructure" action="{ADMIN_STRUCTURE_UPDATE_FORM_URL}" method="post" enctype="multipart/form-data">
			<table class="cells table table-bordered table-striped">
				<tr>
					<th class="width20">{PHP.L.Path}:</th>
					<th class="width80">{ADMIN_STRUCTURE_PATH}</th>
				</tr>
				<tr>
					<td>{PHP.L.Code}:</td>
					<td>{ADMIN_STRUCTURE_CODE}</td>
				</tr>
				<tr>
					<td>{PHP.L.Title}:</td>
					<td>{ADMIN_STRUCTURE_TITLE}</td>
				</tr>
				<tr>
					<td>{PHP.L.Description}:</td>
					<td>{ADMIN_STRUCTURE_DESC}</td>
				</tr>
				<tr>
					<td>{PHP.L.Icon}:</td>
					<td>{ADMIN_STRUCTURE_ICON}</td>
				</tr>
				<tr>
					<td>{PHP.L.Locked}:</td>
					<td>{ADMIN_STRUCTURE_LOCKED}</td>
				</tr>
				<tr>
					<td>{PHP.L.adm_tpl_mode}:</td>
					<td>
						{ADMIN_STRUCTURE_TPLMODE} {ADMIN_STRUCTURE_SELECT}<br />
						{PHP.L.adm_tpl_quickcat}: {ADMIN_STRUCTURE_TPLQUICK}
					</td>
				</tr>
				<!-- BEGIN: EXTRAFLD -->
				<tr>
					<td>{ADMIN_STRUCTURE_EXTRAFLD_TITLE}:</td>
					<td class="{ADMIN_STRUCTURE_ODDEVEN}">{ADMIN_STRUCTURE_EXTRAFLD}</td>
				</tr>
				<!-- END: EXTRAFLD -->
			</table>
				<!-- BEGIN: CONFIG -->
				<h2>{PHP.L.Configuration}</h2>{CONFIG_HIDDEN}
				{ADMIN_CONFIG_EDIT_CUSTOM}

				<table class="cells table">
					<tr>
						<td class="coltop width35">{PHP.L.Parameter}</td>
						<td class="coltop width60">{PHP.L.Value}</td>
						<td class="coltop width5">{PHP.L.Reset}</td>
					</tr>
	<!-- BEGIN: ADMIN_CONFIG_ROW -->
	<!-- BEGIN: ADMIN_CONFIG_FIELDSET_BEGIN -->
					<tr>
						<td class="group_begin" colspan="3">
							<h4>{ADMIN_CONFIG_FIELDSET_TITLE}</h4>
						</td>
					</tr>
	<!-- END: ADMIN_CONFIG_FIELDSET_BEGIN -->
	<!-- BEGIN: ADMIN_CONFIG_ROW_OPTION -->
					<tr>
						<td>{ADMIN_CONFIG_ROW_CONFIG_TITLE}:</td>
						<td>
							{ADMIN_CONFIG_ROW_CONFIG}
							<div class="adminconfigmore">{ADMIN_CONFIG_ROW_CONFIG_MORE}</div>
						</td>
						<td class="centerall">
							<a href="{ADMIN_CONFIG_ROW_CONFIG_MORE_URL}" class="ajax btn btn-default">
								{PHP.L.Reset}
							</a>
						</td>
					</tr>
	<!-- END: ADMIN_CONFIG_ROW_OPTION -->
	<!-- END: ADMIN_CONFIG_ROW -->

				</table>

<!-- END: CONFIG -->
			<table class="cells table">
				<tr>
					<td class="valid" colspan="2"><input type="submit" class="submit btn btn-success" value="{PHP.L.Update}" /></td>
				</tr>
			</table>
			</form>
		</div>
		<!-- END: OPTIONS -->

		<!-- BEGIN: DEFAULT -->
		<div class="block">
			<h3>{PHP.L.editdeleteentries}:</h3>
			<form name="savestructure" id="savestructure" action="{ADMIN_STRUCTURE_UPDATE_FORM_URL}" method="post" class="ajax" enctype="multipart/form-data" >
			<table class="cells table table-bordered table-striped">
				<tr>
					<th class="coltop width15">{PHP.L.Path}</th>
					<th class="coltop width10">{PHP.L.Code}</th>
					<th class="coltop width20">{PHP.L.Title}</th>
					<th class="coltop width5">{PHP.L.TPL}</th>
					<th class="coltop width5">{PHP.L.Pages}</th>
					<th class="coltop width35">{PHP.L.Action}</th>
				</tr>
				<!-- BEGIN: ROW -->
				<tr>
					<td class="{ADMIN_STRUCTURE_ODDEVEN}">{ADMIN_STRUCTURE_SPACEIMG}{ADMIN_STRUCTURE_PATH}</td>
					<td class="centerall {ADMIN_STRUCTURE_ODDEVEN}">{ADMIN_STRUCTURE_CODE}</td>
					<td class="centerall {ADMIN_STRUCTURE_ODDEVEN}">{ADMIN_STRUCTURE_TITLE}</td>
					<td class="centerall {ADMIN_STRUCTURE_ODDEVEN}">{ADMIN_STRUCTURE_TPLQUICK}</td>
					<td class="centerall {ADMIN_STRUCTURE_ODDEVEN}">{ADMIN_STRUCTURE_COUNT}</td>
					<td class="action {ADMIN_STRUCTURE_ODDEVEN}">
						<a title="{PHP.L.Options}" href="{ADMIN_STRUCTURE_OPTIONS_URL}" class="ajax btn">{PHP.L.short_config}</a>
						<!-- IF {ADMIN_STRUCTURE_RIGHTS_URL} --><a title="{PHP.L.Rights}" href="{ADMIN_STRUCTURE_RIGHTS_URL}" class="btn btn-default">{PHP.L.short_rights}</a><!-- ENDIF -->
						<!-- IF {PHP.dozvil} --><a title="{PHP.L.Delete}" href="{ADMIN_STRUCTURE_UPDATE_DEL_URL}" class="btn btn-default">{PHP.L.short_delete}</a><!-- ENDIF -->
						<a href="{ADMIN_STRUCTURE_JUMPTO_URL}" title="{PHP.L.Pages}" class="btn special">{PHP.L.short_open}</a> </td>
				</tr>
				<!-- END: ROW -->
				<tr>
					<td class="valid" colspan="8"><input type="submit" class="submit btn btn-success" value="{PHP.L.Update}" /></td>
				</tr>
			</table>
			</form>
			<div class="pagination"><ul>{ADMIN_STRUCTURE_PAGINATION_PREV}{ADMIN_STRUCTURE_PAGNAV}{ADMIN_STRUCTURE_PAGINATION_NEXT}</ul></div>
			<p><span>{PHP.L.Total}: {ADMIN_STRUCTURE_TOTALITEMS}, {PHP.L.Onpage}: {ADMIN_STRUCTURE_COUNTER_ROW}</span></p>
		</div>
		<!-- END: DEFAULT -->

		<!-- BEGIN: NEWCAT -->
		<div class="block">
			<h3>{PHP.L.Add}:</h3>
			<form name="addstructure" id="addstructure" action="{ADMIN_STRUCTURE_URL_FORM_ADD}" method="post" class="ajax" enctype="multipart/form-data">
			<table class="cells table table-bordered table-striped">
				<tr>
					<th class="width20">{PHP.L.Path}:</th>
					<th class="width80">{ADMIN_STRUCTURE_PATH} {PHP.L.adm_required}</th>
				</tr>
				<tr>
					<td>{PHP.L.Code}:</td>
					<td>{ADMIN_STRUCTURE_CODE} {PHP.L.adm_required}</td>
				</tr>
				<tr>
					<td>{PHP.L.Title}:</td>
					<td>{ADMIN_STRUCTURE_TITLE} {PHP.L.adm_required}</td>
				</tr>
				<tr>
					<td>{PHP.L.Description}:</td>
					<td>{ADMIN_STRUCTURE_DESC}</td>
				</tr>
				<tr>
					<td>{PHP.L.Icon}:</td>
					<td>{ADMIN_STRUCTURE_ICON}</td>
				</tr>
				<tr>
					<td>{PHP.L.Locked}:</td>
					<td>{ADMIN_STRUCTURE_LOCKED}</td>
				</tr>
				<!-- BEGIN: EXTRAFLD -->
				<tr>
					<td>{ADMIN_STRUCTURE_EXTRAFLD_TITLE}:</td>
					<td>{ADMIN_STRUCTURE_EXTRAFLD}</td>
				</tr>
				<!-- END: EXTRAFLD -->
				<tr>
					<td class="valid" colspan="2">
						<input type="submit" class="submit btn btn-success" value="{PHP.L.Add}" />
					</td>
				</tr>
			</table>
			</form>
		</div>
		<!-- END: NEWCAT -->

<!-- END: MAIN -->