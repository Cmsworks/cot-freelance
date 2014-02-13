<!-- BEGIN: MAIN -->
		<h2>Disk Cache</h2>
		{FILE "{PHP.cfg.themes_dir}/admin/{PHP.cfg.admintheme}/warnings.tpl"}
		<div class="block  btn-toolbar">
				<a href="{ADMIN_DISKCACHE_URL_REFRESH}" class="ajax btn large btn">{PHP.L.Refresh}</a>
				<a href="{ADMIN_DISKCACHE_URL_PURGE}" class="ajax btn large btn">{PHP.L.adm_purgeall}</a>
		</div>
		<div class="block">
			<table class="cells table table-bordered table-striped">
				<thead>
				<tr>
					<th class="coltop width25">{PHP.L.Item}</th>
					<th class="coltop width25">{PHP.L.Files}</th>
					<th class="coltop width25">{PHP.L.Size}</th>
					<th class="coltop width25">{PHP.L.Delete}</th>
				</tr>
				</thead>
				<tbody>
<!-- BEGIN: ADMIN_DISKCACHE_ROW -->
				<tr>
					<td class="textcenter">{ADMIN_DISKCACHE_ITEM_NAME}</td>
					<td class="textcenter">{ADMIN_DISKCACHE_FILES}</td>
					<td class="textcenter">{ADMIN_DISKCACHE_SIZE}</td>
					<td class="centerall"><a title="{PHP.L.Delete}" href="{ADMIN_DISKCACHE_ITEM_DEL_URL}" class="ajax btn">{PHP.L.Delete}</a></td>
				</tr>
<!-- END: ADMIN_DISKCACHE_ROW -->
				<tr class="strong">
					<td class="centerall">{PHP.L.Total}:</td>
					<td class="centerall">{ADMIN_DISKCACHE_CACHEFILES}</td>
					<td class="centerall">{ADMIN_DISKCACHE_CACHESIZE}</td>
					<td class="centerall">&nbsp;</td>
				</tr>
				</tbody>
			</table>
		</div>
<!-- END: MAIN -->