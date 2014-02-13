<!-- BEGIN: MAIN -->

{FILE "{PHP.cfg.themes_dir}/admin/{PHP.cfg.admintheme}/warnings.tpl"}

<h2>{PHP.L.Configuration}</h2>

<!-- BEGIN: EDIT -->

    <form name="saveconfig" id="saveconfig" action="{ADMIN_CONFIG_FORM_URL}" method="post">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th style="width:25%;">{PHP.L.Key}</th>
            <th>{PHP.L.Value}</th>
            <th style="width:5%;">{PHP.L.Reset}</th>
          </tr>
        </thead>
        <tbody>
          <!-- BEGIN: ADMIN_CONFIG_ROW -->

          <!-- BEGIN: ADMIN_CONFIG_FIELDSET_BEGIN -->
          <tr>
            <th colspan="3" style="text-align:center;">
        <big>{ADMIN_CONFIG_FIELDSET_TITLE}</big>
        </th>
        </tr>
        <!-- END: ADMIN_CONFIG_FIELDSET_BEGIN -->

        <!-- BEGIN: ADMIN_CONFIG_ROW_OPTION -->
        <tr>
          <td>{ADMIN_CONFIG_ROW_CONFIG_TITLE}:
            <!-- IF {ADMIN_CONFIG_ROW_CONFIG_MORE} -->
            <div style="font-size: 0.85em; opacity: 0.6;">{ADMIN_CONFIG_ROW_CONFIG_MORE}</div>
            <!-- ENDIF -->
          </td>
          <td>
            {ADMIN_CONFIG_ROW_CONFIG}
          </td>
          <td>
            <a href="{ADMIN_CONFIG_ROW_CONFIG_MORE_URL}" class="btn btn-mini">
              {PHP.L.Reset}
            </a>
          </td>
        </tr>
        <!-- END: ADMIN_CONFIG_ROW_OPTION -->

        <!-- BEGIN: ADMIN_CONFIG_FIELDSET_END -->
        <!-- END: ADMIN_CONFIG_FIELDSET_END -->

        <!-- END: ADMIN_CONFIG_ROW -->
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3">
              <button type="submit" class="btn btn-primary button">{PHP.L.Update}</button>
            </td>
          </tr>
        </tfoot>
      </table>
    </form>

<!-- END: EDIT -->

<!-- BEGIN: DEFAULT -->

<!-- BEGIN: ADMIN_CONFIG_COL -->

<h3>{ADMIN_CONFIG_COL_CAPTION}:</h3>
<div class="row">
<!-- BEGIN: ADMIN_CONFIG_ROW -->
	<div class="span3">
		<div class="thumbnail">
			<a href="{ADMIN_CONFIG_ROW_URL}">
				<!-- IF {ADMIN_CONFIG_ROW_ICO} --> 
				<img src="{ADMIN_CONFIG_ROW_ICO}" style="height: 32px!important;">
				<!-- ELSE -->
				<img src="{PHP.cfg.system_dir}/admin/img/plugins32.png" style="height: 32px!important;">
				<!-- ENDIF -->
				{ADMIN_CONFIG_ROW_NAME}
			</a>
		</div>
		<br/>
	</div>
<!-- END: ADMIN_CONFIG_ROW -->
</div>
<div class="clear"></div>

<!-- END: ADMIN_CONFIG_COL -->

<!-- END: DEFAULT -->

<!-- END: MAIN -->