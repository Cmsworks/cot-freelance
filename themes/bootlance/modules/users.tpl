<!-- BEGIN: MAIN -->
	<div class="breadcrumb">{USERS_TITLE}</div>
	<h1>
	<!-- IF {PHP.cat} -->
		{CATTITLE}
	<!-- ELSE -->
		{USERS_TITLE}
	<!-- ENDIF -->
	</h1>
	<div class="row">
		<div class="span3">
			<div class="well well-small">{USERCATEGORIES_CATALOG}</div>
		</div>
		<div class="span9">
		
			<div class="well">
				<form action="{SEARCH_ACTION_URL}" method="get">
					<input type="hidden" name="f" value="search" />
					<input type="hidden" name="e" value="users" />
					<input type="hidden" name="group" value="{PHP.group}" />
					<input type="hidden" name="cat" value="{PHP.cat}" />
					<input type="hidden" name="l" value="{PHP.lang}" />
					<p>{PHP.L.Location}: {SEARCH_LOCATION}</p>
					<div class="row">
						<div class="span7"><input type="text" name="sq" value="{PHP.sq}" class="schstring"/></div>
						<div class="span1"><button type="submit" class="btn btn-success">{PHP.L.Search}</button></div>
					</div>
				</form>
			</div>
			
			<!-- BEGIN: USERS_ROW -->
				<div class="row">
					<div class="span1">
						{USERS_ROW_AVATAR}
					</div>
					<div class="span8">
						<div class="pull-right">
							<span class="label label-info">{USERS_ROW_USERPOINTS}</span>
						</div>
						<strong>{USERS_ROW_NAME}</strong><!-- IF {USERS_ROW_ISPRO} --> <span class="label label-important">PRO</span><!-- ENDIF -->
						<p>{USERS_ROW_COUNTRY} {USERS_ROW_REGION} {USERS_ROW_CITY}</p>
					</div>
				</div>
				<hr/>
			<!-- END: USERS_ROW -->

			<!-- IF {USERS_TOP_TOTALUSERS} > 0 -->
			<div class="pagination"><ul>{USERS_TOP_PAGEPREV}{USERS_TOP_PAGNAV}{USERS_TOP_PAGENEXT}</ul></div>
			<!-- ELSE -->
			<div class="alert">{PHP.L.Noitemsfound}</div>
			<!-- ENDIF -->
		</div>
	</div>
		

<!-- END: MAIN -->