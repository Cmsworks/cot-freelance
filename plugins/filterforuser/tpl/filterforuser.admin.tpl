<!-- BEGIN: MAIN -->
<h3>{PHP.L.filterforuser}</h3>
<p>{PHP.L.allowtypes}</p>
{FILE "{PHP.cfg.system_dir}/admin/tpl/warnings.tpl"}
	<table class="table table-striped">
		<!-- BEGIN: OPT_ROW -->
			<tr>
				<td width="60%">{FILTERFORUSER_ADD_OPTION}</td>
				<td><a type="submit" class="btn btn-default" href="{FILTERFORUSER_ADD}" >{FILTERFORUSER_ADD_TITLE}</a></td> 
			</tr>
		<!-- END: OPT_ROW -->
	</table>
<!-- END: MAIN -->