<!-- BEGIN: MAIN -->

		<!-- BEGIN: USERS_AUTH_MAINTENANCE -->
			<div class="error clear">
				<h4>{PHP.L.users_maintenance1}</h4>
				<p>{PHP.L.users_maintenance2}</p>
			</div>
		<!-- END: USERS_AUTH_MAINTENANCE -->

		<div class="row">
			<div class="offset3 span5 form-signin">
				<div class="mboxHD">{USERS_AUTH_TITLE}</div>
				<form name="login" action="{USERS_AUTH_SEND}" method="post">
					<table class="main">
						<tr>
							<td class="width30">{PHP.L.users_nameormail}:</td>
							<td class="width70">{USERS_AUTH_USER}</td>
						</tr>
						<tr>
							<td>{PHP.L.Password}:</td>
							<td class="width70">{USERS_AUTH_PASSWORD}</td>
						</tr>
						<tr>
							<td></td>
							<td><label class="checkbox">{USERS_AUTH_REMEMBER}&nbsp; {PHP.L.users_rememberme}</label></td>
						</tr>
						<tr>
							<td></td>
							<td>
								<button type="submit" name="rlogin" class="btn btn-large btn-primary" value="0">{PHP.L.Login}</button>
								<br/>
								<br/>
								<a href="{PHP|cot_url('users', 'm=passrecover')}">{PHP.L.users_lostpass}</a>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>

<!-- END: MAIN -->