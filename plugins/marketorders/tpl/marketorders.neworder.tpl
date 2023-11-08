<!-- BEGIN: MAIN -->

<div class="breadcrumb">{BREADCRUMBS}</div>
<h1>{PHP.L.marketorders_neworder_title}</h1>
<div class="customform">
	{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
	<form action="{NEWORDER_FORM_SEND}" method="post" name="neworderform">
		<table class="table">
			<tr>
				<td align="right" style="width:176px;">{PHP.L.marketorders_neworder_product}:</td>
				<td>[ID {NEWORDER_PRD_ID}] {NEWORDER_PRD_SHORTTITLE}</td>
			</tr>
			<tr>
				<td align="right">{PHP.L.marketorders_neworder_count}:</td>
				<td>{NEWORDER_FORM_COUNT}</td>
			</tr>
			<tr>
				<td align="right">{PHP.L.marketorders_neworder_comment}:</td>
				<td>{NEWORDER_FORM_COMMENT}</td>
			</tr>
			<tr>
				<td align="right">{PHP.L.marketorders_neworder_total}:</td>
				<td><span id="total">{NEWORDER_PRD_COST}</span> {PHP.cfg.payments.valuta}</td>
			</tr>
			<!-- IF {PHP.usr.id} == 0 -->
			<tr>
				<td align="right">{PHP.L.marketorders_neworder_email}:</td>
				<td>{NEWORDER_FORM_EMAIL}</td>
			</tr>
			<!-- ENDIF -->
			<tr>
				<td></td>
				<td>
					<input type="submit" class="btn btn-large btn-success" value="{PHP.L.marketorders_neworder_button}" />
				</td>
			</tr>
		</table>
	</form>
				
	<script>
	
		$().ready(function() {
			$('#count').bind('change click keyup', function (){
				var prdcost = {PHP.item.item_cost};
				var count = $('input[name="rcount"]').val();
				$('#total').html(prdcost*count);
			});
		});
		
	</script>
	
</div>

<!-- END: MAIN -->