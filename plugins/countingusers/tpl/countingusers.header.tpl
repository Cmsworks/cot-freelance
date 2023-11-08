<!-- BEGIN: MAIN -->			
 			<table class="table table-striped">
 				<!-- IF {HEADER_COUNT_USR_ALL} -->
				<tr>
					<td>{PHP.L.fr_users_title}</td>
					<td><span class="label label-info">{HEADER_COUNT_USR_ALL}</span></td>
				</tr>
				<!-- ENDIF -->
 				<!-- IF {HEADER_COUNT_USR_4} -->
				<tr>
					<td>{PHP.L.fr_freelancers_title}</td>
					<td><span class="label label-info">{HEADER_COUNT_USR_4}</span></td>
				</tr>
				<!-- ENDIF -->
				<!-- IF {HEADER_COUNT_USR_7} -->
				<tr>
					<td>{PHP.L.fr_employers_title}</td>
					<td><span class="label label-info">{HEADER_COUNT_USR_7}</span></td>
				</tr>
				<!-- ENDIF -->
				<!-- IF {HEADER_COUNT_USR_8} -->
				<tr>
					<td>{PHP.L.fr_traders_title}</td>
					<td><span class="label label-info">{HEADER_COUNT_USR_8}</span></td>
				</tr>
				<!-- ENDIF -->
				<!-- IF {HEADER_COUNT_PRJ_0} -->
				<tr>
					<td>{PHP.L.fr_projects_title}</td>
					<td><span class="label label-info">{HEADER_COUNT_PRJ_0}</span></td>
				</tr>
				<!-- ENDIF -->
				<!-- IF !{HEADER_COUNT_PRJ_OPENFROM} == '' -->
				<tr>
					<td>{PHP.L.fr_projects_from_title}</td>
					<td><span class="label label-info">{HEADER_COUNT_PRJ_OPENFROM}</span></td>
				</tr>
				<!-- ENDIF -->
				<!-- IF {HEADER_COUNT_PRD_0} -->
				<tr>
					<td>{PHP.L.fr_market_title}</td>
					<td><span class="label label-info">{HEADER_COUNT_PRD_0}</span></td>
				</tr>
				<!-- ENDIF -->
			</table> 
<!-- END: MAIN -->