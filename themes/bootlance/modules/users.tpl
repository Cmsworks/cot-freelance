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
				<form action="{USERS_TOP_FILTER_ACTION}" method="post">
					<input type="hidden" name="gm" value="{PHP.gm}"/>
					<div class="row">
						<div class="span7"><input type="text" name="y" value="{PHP.y}" class="schstring"/></div>
						<div class="span1"><button type="submit" class="btn">{PHP.L.Submit}</button></div>
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