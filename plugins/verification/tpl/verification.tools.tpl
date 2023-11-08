<!-- BEGIN: MAIN -->

<div class="jqmWindowVerification" >  </div>

<h2>{PHP.L.ver_tools_title}</h2>

<table class="cells" >
<tr><td class="coltop width5">#</td><td class="coltop ">{PHP.L.Author}</td><td class="coltop width70">{PHP.L.ver_tools_link_img}</td><td class="coltop width25">{PHP.L.ver_tools_admin_action}</td></tr>
<!-- BEGIN: ROW -->
<tr>
<td class="textcenter">
{INDEX}
</td>
<td class="textcenter">
{USER}
</td>
<td class="textcenter">
<span id="pth_{INDEX}">
 <a href="{FILE_PATH} "  class="trigger_jgm_vrf"  OnClick="vrf_win_jqm('{FILE_PATH}');return false;" >{FILE_PATH} </a>
</span>
</td>
<td class="centerall action relative">

<span id="at_{INDEX}">
<!-- BEGIN: ADMIN_ACT -->
<a href="javascript:false" title="{PHP.L.ver_tools_admin_action_confirm}" {ONCLICK} class="button special">{PHP.L.ver_tools_admin_action_confirm}</a>
<a href="javascript:false" title="{PHP.L.Delete}" {DELETE_ONCLICK} class="button">{PHP.L.Delete}</a>
<!-- END: ADMIN_ACT -->
</span>

</td>
</tr>
<!-- END: ROW -->
</table>

<!-- BEGIN: IMAGE -->
<img src="{PHP.imgurl}" alt="" border="0">
<div align="left"><a href="{PHP.imgurl}" >{PHP.L.ver_tools_view_img}</a></div>
<a class="jqmClose">{PHP.L.ver_tools_close}</a>
<!-- END: IMAGE -->

<!-- BEGIN: ACTIV -->
<img src="plugins/verification/img/ver_icon.png" width="15" height="15" alt="" border="0" >{PHP.L.ver_tools_admin_action_done}
<!-- END: ACTIV -->

<!-- BEGIN: DELETE -->
<div align="center">
<span class="vrf_info_win">{PHP.L.ver_tools_delete_confirm}
  <span class="vrf-arrow-border"></span>
  <span class="vrf-arrow"></span>
</span>

<a href="javascript:false" title="{PHP.L.ver_tools_yes}" {DEL_ONCLICK} class="button special">{PHP.L.ver_tools_yes}</a>
<a href="javascript:false" title="{PHP.L.ver_tools_no}" {BACK_ONCLICK} class="button">{PHP.L.ver_tools_no}</a>
</div>
<!-- END: DELETE-->

<!-- END: MAIN -->