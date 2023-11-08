<!-- BEGIN: MAIN -->

<h1>{PHP.L.orderform_title}</h1>

{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
<form action="{ORDERFORM_ACTION}" method="post" id="form_orderform" class="form-horizontal">
	<div class="control-group">
		<label class="control-label">{PHP.L.orderform_form_name}</label>
		<div class="controls">
			{ORDERFORM_FORM_NAME}
		</div>
	</div>
	<!-- IF {PHP.usr.id} == 0 -->
	<div class="control-group">
		<label class="control-label">{PHP.L.orderform_form_email}</label>
		<div class="controls">
			{ORDERFORM_FORM_EMAIL}
		</div>
	</div>
	<!-- ENDIF -->
	<div class="control-group">
		<label class="control-label">{PHP.L.orderform_form_phone}</label>
		<div class="controls">
			{ORDERFORM_FORM_PHONE}
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">{PHP.L.orderform_form_quantity}</label>
		<div class="controls">
			{ORDERFORM_FORM_QUANTITY}
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">{PHP.L.orderform_form_comment}</label>
		<div class="controls">
			{ORDERFORM_FORM_COMMENT}
		</div>
	</div>
	<div class="control-group">
		<label class="control-label"></label>
		<div class="controls">
			<button class="btn btn-primary" type="submit">{PHP.L.orderform_sendorder}</button>
		</div>
	</div>
</form>

<!-- END: MAIN -->