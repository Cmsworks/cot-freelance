<!-- BEGIN: MAIN -->
		<h2>{PHP.L.Log} ({ADMIN_LOG_TOTALDBLOG})</h2>
		{FILE "{PHP.cfg.themes_dir}/admin/{PHP.cfg.admintheme}/warnings.tpl"}
<!-- IF {PHP.usr.isadmin} -->
			<div class="pull-right">
				<a title="{PHP.L.adm_purgeall}" href="{ADMIN_LOG_URL_PRUNE}" class="ajax btn large btn">{PHP.L.adm_purgeall}</a>
			</div>
<!-- ENDIF -->
			<form action="" class="margintop10 marginbottom10">{PHP.L.Group}:
				<select name="groups" size="1" onchange="redirect(this)">
<!-- BEGIN: GROUP_SELECT_OPTION -->
					<option value="{ADMIN_LOG_OPTION_VALUE_URL}"{ADMIN_LOG_OPTION_SELECTED}>{ADMIN_LOG_OPTION_GRP_NAME}</option>
<!-- END: GROUP_SELECT_OPTION -->
				</select>
			</form>
			<table class="cells table table-bordered table-striped">
				<thead>
				<tr>
					<th class="coltop width5">#</th>
					<th class="coltop width15">{PHP.L.Date} (GMT)</th>
					<th class="coltop width10">{PHP.L.Ip}</th>
					<th class="coltop width15">{PHP.L.User}</th>
					<th class="coltop width15">{PHP.L.Group}</th>
					<th class="coltop width40">{PHP.L.Log}</th>
				</tr>
				</thead>
				<tbody>
<!-- BEGIN: LOG_ROW -->
				<tr>
					<td class="textcenter">{ADMIN_LOG_ROW_LOG_ID}</td>
					<td class="textcenter">{ADMIN_LOG_ROW_DATE}</td>
					<td class="textcenter"><a href="{ADMIN_LOG_ROW_URL_IP_SEARCH}">{ADMIN_LOG_ROW_LOG_IP}</a></td>
					<td class="textcenter">{ADMIN_LOG_ROW_LOG_NAME}&nbsp;</td>
					<td class="textcenter"><a href="{ADMIN_LOG_ROW_URL_LOG_GROUP}" class="ajax">{ADMIN_LOG_ROW_LOG_GROUP}</a></td>
					<td>{ADMIN_LOG_ROW_LOG_TEXT}</td>
				</tr>
<!-- END: LOG_ROW -->
				</tbody>
			</table>
			<div class="pagination"><ul>{ADMIN_LOG_PAGINATION_PREV} {ADMIN_LOG_PAGNAV} {ADMIN_LOG_PAGINATION_NEXT}</ul></div>
			<p>{PHP.L.Total}: {ADMIN_LOG_TOTALITEMS}, {PHP.L.Onpage}: {ADMIN_LOG_ON_PAGE}</p>
<!-- END: MAIN -->