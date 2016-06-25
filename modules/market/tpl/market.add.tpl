<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PHP.L.market_add_product_title}</div>
<div class="customform">
	{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
	<form action="{PRDADD_FORM_SEND}" method="post" name="newwork" enctype="multipart/form-data">
		<table class="cells" border="0" cellspacing="1" cellpadding="2">
			<tr>
				<td align="right" style="width:176px;">{PHP.L.Category}:</td>
				<td>{PRDADD_FORM_CAT}</td>
			</tr>
			<tr>
				<td align="right">{PHP.L.Title}:</td>
				<td>{PRDADD_FORM_TITLE}</td>
			</tr>
			<tr<!-- IF !{PHP.usr.isadmin} --> class="hidden"<!-- ENDIF -->>
				<td align="right">{PHP.L.Alias}:</td>
				<td>{PRDADD_FORM_ALIAS}</td>
			</tr>
			<tr>
				<td align="right">{PHP.L.market_location}:</td>
				<td>{PRDADD_FORM_LOCATION}</td>
			</tr>
			<tr<!-- IF !{PHP.usr.isadmin} --> class="hidden"<!-- ENDIF -->>
				<td align="right">{PHP.L.Parser}:</td>
				<td>{PRDADD_FORM_PARSER}</td>
			</tr>
			<tr>
				<td align="right">{PHP.L.Text}:</td>
				<td>{PRDADD_FORM_TEXT}</td>
			</tr>
			<!-- BEGIN: TAGS -->
			<tr>
				<td>{PRDADD_FORM_TAGS_TITLE}:</td>
				<td>{PRDADD_FORM_TAGS} ({PRDADD_FORM_TAGS_HINT})</td>
			</tr>
			<!-- END: TAGS -->
			<tr>
				<td align="right">{PHP.L.market_price}:</td>
				<td>{PRDADD_FORM_COST} {PHP.cfg.payments.valuta}</td>
			</tr>
			<!-- IF {PHP.cot_plugins_active.marketorders} -->
			<tr>
				<td align="right">{PHP.L.marketorders_file}:</td>
				<td>{PRDADD_FORM_FILE}</td>
			</tr>
			<!-- ENDIF -->
			<tr>
				<td align="right">{PHP.L.Image}:</td>
				<td>
					{PRDADD_FORM_MAVATAR}
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" class="btn btn-info" value="{PHP.L.Submit}" />
				</td>
			</tr>
		</table>
	</form>
</div>

<!-- END: MAIN -->