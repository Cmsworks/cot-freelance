<!-- BEGIN: MAIN -->

	<div class="breadcrumb">{PM_PAGETITLE}</div>
<!-- BEGIN: BEFORE_AJAX -->
		<div id="ajaxBlock">
<!-- END: BEFORE_AJAX -->

			<div class="block">
				<p class="small">{PM_SUBTITLE}</p>
				<p class="paging">
					{PM_INBOX}<span class="spaced">{PHP.cfg.separator}</span>{PM_SENTBOX}<span class="spaced">{PHP.cfg.separator}</span>{PM_SENDNEWPM}<br />
					{PHP.L.Filter}: {PM_FILTER_UNREAD}, {PM_FILTER_STARRED}, {PM_FILTER_ALL}
				</p>
				<form action="{PM_FORM_UPDATE}" method="post" name="update" id="update" class="ajax">
					<table class="table">
						<thead>
							<tr>
								<th class="width10">
									<!-- IF {PHP.cfg.jquery} --><input class="checkbox" type="checkbox" value="{PHP.themelang.pm.Selectall}/{PHP.themelang.pm.Unselectall}" onclick="$('.checkbox').attr('checked', this.checked);" /><!-- ENDIF -->
								</th>
								<th class="width5">{PHP.L.Status}</th>
								<th class="width5">
									<div class="pm-star pm-star-readonly">
										<a href="#" title ="{PHP.L.pm_starred}"> &nbsp; </a>
									</div>
								</th>
								<th class="width40">{PHP.L.Subject}</th>
								<th class="width15">{PM_SENT_TYPE}</th>
								<th class="width15">{PHP.L.Date}</th>
								<th class="width15">{PHP.L.Action}</th>
							</tr>
						</thead>
						<tbody>
<!-- BEGIN: PM_ROW -->
						<tr>
							<td class="centerall {PM_ROW_ODDEVEN}"><input type="checkbox" class="checkbox" name="msg[{PM_ROW_ID}]" /></td>
							<td class="centerall {PM_ROW_ODDEVEN}">{PM_ROW_ICON_STATUS}</td>
							<td class="centerall {PM_ROW_ODDEVEN}">{PM_ROW_STAR}</td>
							<td class="{PM_ROW_ODDEVEN}">
								<p class="strong">{PM_ROW_TITLE}</p>
								<p class="small">{PM_ROW_DESC}</p>
							</td>
							<td class="centerall {PM_ROW_ODDEVEN}">{PM_ROW_USER_NAME}</td>
							<td class="centerall {PM_ROW_ODDEVEN}">{PM_ROW_DATE}</td>
							<td class="centerall {PM_ROW_ODDEVEN}">{PM_ROW_ICON_EDIT} {PM_ROW_ICON_DELETE}</td>
						</tr>
<!-- END: PM_ROW -->
<!-- BEGIN: PM_ROW_EMPTY -->
						<tr>
							<td class="centerall" colspan="7">{PHP.L.None}</td>
						</tr>
<!-- END: PM_ROW_EMPTY -->
						</tbody>
					</table>
					<!-- IF {PHP.jj} > 0 -->
					<p class="paging">
						<span class="strong">{PHP.L.pm_selected}:</span>
						<select name="action" size="1">
							<option value="delete" >{PHP.L.Delete}</option>
							<option value="star" selected="selected">{PHP.L.pm_putinstarred}</option>
						</select>
						<button type="submit" name="delete">{PHP.L.Confirm}</button>
					</p>
					<p class="paging">{PM_PAGEPREV}{PM_PAGES}{PM_PAGENEXT}</p>
					<!-- ENDIF -->
				</form>
			</div>
			<!-- IF {PHP.cfg.jquery} AND {PHP.cfg.pm.turnajax} -->
			<script type="text/javascript" src="{PHP.cfg.modules_dir}/pm/js/pm.js"></script>
			<!-- ENDIF -->

<!-- BEGIN: AFTER_AJAX -->
		</div>
<!-- END: AFTER_AJAX -->

<!-- END: MAIN -->