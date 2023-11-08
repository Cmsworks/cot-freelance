<!-- BEGIN: MAIN -->

<div class="breadcrumb">{BREADCRUMBS}</div>
<h1>{PHP.L.marketorders_addclaim_title}</h1>
<div class="customform">
	{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
	<form action="{CLAIM_FORM_SEND}" method="post" name="neworderform">
		<p>{CLAIM_FORM_TEXT}</p>
		<p><input type="submit" class="btn btn-large btn-danger" value="{PHP.L.marketorders_addclaim_button}" /></p>
	</form>
</div>

<!-- END: MAIN -->