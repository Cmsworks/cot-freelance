<!-- BEGIN: MAIN -->

	<div class="breadcrumb">{USERS_REGISTER_TITLE}</div>
	<div class="well">
		{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
		<form name="login" action="{USERS_REGISTER_SEND}" method="post" enctype="multipart/form-data" >
			<table class="table">
				<!-- IF {USERS_REGISTER_GROUPSELECT} -->
				<tr>
					<td class="width30">{PHP.L.profile_group}:</td>
					<td class="width70">{USERS_REGISTER_GROUPSELECT} *</td>
				</tr>
				<!-- ENDIF -->
				<tr>
					<td class="width30">{PHP.L.Username}:</td>
					<td class="width70">{USERS_REGISTER_USER} *</td>
				</tr>
				<!-- IF {PHP.cot_plugins_active.locationselector} -->
				<tr>
					<td>{PHP.L.Country}:</td>
					<td>{USERS_REGISTER_LOCATION}</td>
				</tr>
				<!-- ELSE -->
				<tr>
					<td>{PHP.L.Country}:</td>
					<td>{USERS_REGISTER_COUNTRY}</td>
				</tr>
				<!-- ENDIF -->
				<tr>
					<td>{PHP.L.users_validemail}:</td>
					<td>
						{USERS_REGISTER_EMAIL} *
						<p class="small">{PHP.L.users_validemailhint}</p>
					</td>
				</tr>
				<tr>
					<td>{PHP.L.Password}:</td>
					<td>{USERS_REGISTER_PASSWORD} *</td>
				</tr>
				<tr>
					<td>{PHP.L.users_confirmpass}:</td>
					<td>{USERS_REGISTER_PASSWORDREPEAT} *</td>
				</tr>
				<tr>
					<td>{USERS_REGISTER_VERIFYIMG}</td>
					<td>{USERS_REGISTER_VERIFYINPUT} *</td>
				</tr>
				<!-- IF {USERS_REGISTER_USERAGREEMENT} -->
				<tr>
					<td>{PHP.L.useragreement}</td>
					<td><label class="checkbox">{USERS_REGISTER_USERAGREEMENT} *</label></td>
				</tr>
				<!-- ENDIF -->
				<tr>
					<td></td>
					<td>
						<button class="btn btn-primary btn-large">{PHP.L.Submit}</button>
					</td>
				</tr>
			</table>
		</form>
	</div>

<!-- END: MAIN -->