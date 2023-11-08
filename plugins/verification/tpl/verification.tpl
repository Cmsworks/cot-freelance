<!-- BEGIN: MAIN -->

<!-- BEGIN: START -->

<p>{PHP.L.ver_txt1}</p>
<div align="center" class="padding10"><img src="{PHP.cfg.plugins_dir}/verification/img/verification.png" width="699" height="133" alt="" border="0"></div>
<p>{PHP.L.ver_txt6}</p>
<div align="center">
	<table>
	<tr>
		<td style="text-align:center;padding:20px;" ><div align="center">
			<strong>{PHP.L.ver_checked}</strong></div><img src="{PHP.cfg.plugins_dir}/verification/img/v_g.png" class="padding10"  width="100" height="100" alt="" border="0">
			<div align="center" class="padding10" >{PHP|cot_rc('vrf_activ_icon')}{PHP.L.ver_name1}</div>

		</td>
		<td style="text-align:center;padding:20px;" >
			<div align="center"><strong>{PHP.L.ver_nochecked}</strong></div><img src="{PHP.cfg.plugins_dir}/verification/img/v_m.png" class="padding10"  width="100" height="100" alt="" border="0">
			<div align="center" class="padding10" >{PHP.L.ver_name2}</div>
		</td>
	</tr>
	</table>
</div>
<p>{PHP.L.ver_txt2}</p>
<p>{PHP.L.ver_txt3}&nbsp;{PHP|cot_rc('vrf_activ_icon')}{PHP.L.ver_txt4}</p>
<p>{PHP.L.ver_txt5}</p>
<br />
<form name="confirm" action="{PHP.action}" method="post">
    <p>
		<input name="confirm" id="confirm" value="ON" type="checkbox"  onClick="if (this.checked) {document.getElementById('subconfirm').disabled = false;} else {document.getElementById('subconfirm').disabled = true;}">&nbsp;<label for="confirm" id="label_confirm" >{PHP.L.ver_confirm}</label>
    </p>
	<p>
		<input type="submit" value="{PHP.L.ver_vrf_txt}" id="linkverifi" class="btn btn-success" >
		<div id="errors_confirm" style="font-size:11px; color:red"></div>

	</p>
</form>

{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}

<!-- END: START -->

<!-- BEGIN: FORM -->
<h1>{PHP.L.ver_confirm_title}</h1>
	<form name="confirm" action="{PHP.action}" method="post" enctype="multipart/form-data">
		<input name="act" type="hidden" value="sendform">
		<p>{PHP.L.ver_file_title}.</p>
		{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
		<p style="padding:20px 0px;"><input name="scanpassport" type="file" accept="{PHP.ext_file}"></p>
		<p>{PHP.L.ver_file_ext}: {PHP.ext_txt}</p>
		<p>{PHP.L.ver_file_max}: {PHP.up_max} Mb </p>
		<p class="padding20-0"><input type="submit" value="{PHP.L.Submit}" class="btn btn-success" ></p>
	</form>
<!-- END: FORM -->

<!-- BEGIN: STATUSEXIST -->
<h1>{PHP.L.ver_statusexist_title}</h1>
<p>{PHP.L.ver_statusexist_desc}</p>
<!-- END: STATUSEXIST -->

<!-- BEGIN: EXIST -->
<h1>{PHP.L.ver_exist_title}</h1>
<p>{PHP.L.ver_exist_desc}</p>
<div align="center" class="ver_img_box"><img src="{PHP.img_mod_url}" ></div>
<!-- END: EXIST -->

<!-- BEGIN: SEND -->
<h1>{PHP.L.ver_file_send_mess}</h1>
<p>{PHP.L.ver_file_send_mess_desc}</p>
<div align="center" class="ver_img_box"><img src="{PHP.img_mod_url}" ></div>
<!-- END: SEND -->

<!-- END: MAIN -->