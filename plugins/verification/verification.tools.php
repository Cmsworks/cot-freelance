<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=tools
[END_COT_EXT]
==================== */

/**
 * Verification of the identity of the freelancers. Checks the scanned passport.
 *
 * @plugin Verification
 * @version 1.0
 * @author Dr2005alex
 * @copyright Copyright (c) Dr2005alex
 *
 */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'verification');
cot_block($usr['isadmin']);
require_once cot_incfile('verification', 'plug', 'resources');
require_once cot_incfile('verification', 'plug', 'config');
require cot_langfile('verification', 'plug');


$t = new XTemplate(cot_tplfile('verification.tools', 'plug', true));

$adminhelp = $L['ver_tools_help'];
$adminsubtitle = $L['ver_tools_title'];

                $fi=0;
				$dir = opendir($ver_file_patch);
				while(($file = readdir($dir)) !== false) {

					if($file != '..' && $file != '.' && $file != $conf_dir_new){
					    $fi++;
	                    $vrf_user = explode('-', $file);

  	                $t->assign(array(
	                       "INDEX"     => $fi,
	                       "FILE_PATH" => $ver_file_patch.$file,
	                       "USER" => cot_build_user($vrf_user[0], $vrf_user[1]),
						   "ONCLICK" => "OnClick = \"$('#pth_".$fi."').fadeOut(600);return ajaxSend({ method: 'GET', url: '".cot_url('plug', 'r=verification&action=activate','',true)."', data:'index=".$fi."&user=".$vrf_user[0]."&imgurl=".urlencode($ver_file_patch.$file)."'   ,divId: 'at_".$fi."', errMsg: '".$L['ajaxSenderror']."' });\"",
						   "DELETE_ONCLICK" => "OnClick = \"return ajaxSend({ method: 'GET', url: '".cot_url('plug', 'r=verification&action=delete','',true)."', data:'index=".$fi."&user=".$vrf_user[0]."&imgurl=".urlencode($ver_file_patch.$file)."'   ,divId: 'at_".$fi."', errMsg: '".$L['ajaxSenderror']."' });\"",

	                ));
                    $t->parse("MAIN.ROW.ADMIN_ACT");
			        $t->parse("MAIN.ROW");


	                }
				}
				closedir($dir);



$t->parse('MAIN');
if (COT_AJAX)
{
	$t->out('MAIN');
}
else
{
	$adminmain = $t->text('MAIN');
}
