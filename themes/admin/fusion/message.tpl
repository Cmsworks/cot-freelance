<!-- BEGIN: MAIN -->

<div class="container" style="margin-top:50px;">
  <h1 style="margin:10px 0;">{MESSAGE_TITLE}</h1>
  <div class="well" style="padding:0;">
    <div style="margin:25px 20px;">{MESSAGE_BODY}</div>
    <!-- BEGIN: MESSAGE_CONFIRM -->
    <div class="form-actions" style="margin-bottom:0;">
      <a id="confirmYes" href="{MESSAGE_CONFIRM_YES}" class="btn btn-primary"><i class="icon-ok icon-white"></i> {PHP.L.Yes}</a>
      <a id="confirmNo" href="{MESSAGE_CONFIRM_NO}" class="btn btn-default"><i class="icon-remove"></i> {PHP.L.No}</a>
    </div>
    <!-- END: MESSAGE_CONFIRM -->
  </div>
</div>

<!-- END: MAIN -->