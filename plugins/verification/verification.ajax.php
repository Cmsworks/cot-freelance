<?PHP
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
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

defined('COT_PLUG') or die('Wrong URL');
require_once cot_incfile('verification', 'plug', 'config');
require_once cot_langfile('verification', 'plug');
require_once cot_incfile('configuration');

$action = cot_import('action','G','TXT');
$imgurl = cot_import('imgurl','G','TXT');
$user = cot_import('user','G','INT');
$index = cot_import('index','G','INT');
cot_sendheaders();

if ($action == 'image'){
$vrft = new XTemplate(cot_tplfile('verification.tools', 'plug', true));
$vrft->parse("MAIN.IMAGE");
echo $vrft->text("MAIN.IMAGE");

}
if ($action == 'activate'){
$vrf_file = explode('/',$imgurl);
$vrf_filename = $vrf_file[(count($vrf_file) - 1)];

if(is_file($imgurl) && rename($imgurl, $ver_file_patch_new.$vrf_filename ))
{
		$cfg['verification_plug']['verification_count']--;
		cot_config_modify('verification_plug', array('0'=>array('order' => '99', 'name' => 'verification_count','type' => '0', 'value' => "{$cfg['verification_plug']['verification_count']}")),true);
                if ($cache){
                    $cache->db->remove('cot_cfg', 'system');
                }
                
        $db->update($db_users, array('user_verification_status' => 1), "user_id='".$user."'");
		$vt = new XTemplate(cot_tplfile('verification.tools', 'plug', true));
		$vt->parse("MAIN.ACTIV");
		echo $vt->text("MAIN.ACTIV");
}else echo "error rename file";

}

if ($action == 'delete'){
$vt = new XTemplate(cot_tplfile('verification.tools', 'plug', true));
  	                $vt->assign(array(
						   "DEL_ONCLICK" => "OnClick = \"$('#at_".$index."').fadeOut(600);return ajaxSend({ method: 'GET', url: '".cot_url('plug', 'r=verification&action=remove','',true)."', data:'index=".$index."&user=".$user."&imgurl=".urlencode($imgurl)."'   ,divId: 'pth_".$index."', errMsg: '".$L['ajaxSenderror']."' });\"",
						   "BACK_ONCLICK" => "OnClick = \"return ajaxSend({ method: 'GET', url: '".cot_url('plug', 'r=verification&action=back','',true)."', data:'index=".$index."&user=".$user."&imgurl=".urlencode($imgurl)."'   ,divId: 'at_".$index."', errMsg: '".$L['ajaxSenderror']."' });\"",
	                ));

$vt->parse("MAIN.DELETE");
echo $vt->text("MAIN.DELETE");
}

if ($action == 'back'){
$vt = new XTemplate(cot_tplfile('verification.tools', 'plug', true));

  	                $vt->assign(array(
						   "ONCLICK" => "OnClick = \"$('#pth_".$index."').fadeOut(600);return ajaxSend({ method: 'GET', url: '".cot_url('plug', 'r=verification&action=activate','',true)."', data:'index=".$index."&user=".$user."&imgurl=".urlencode($imgurl)."'   ,divId: 'at_".$index."', errMsg: '".$L['ajaxSenderror']."' });\"",
						   "DELETE_ONCLICK" => "OnClick = \"return ajaxSend({ method: 'GET', url: '".cot_url('plug', 'r=verification&action=delete','',true)."', data:'index=".$index."&user=".$user."&imgurl=".urlencode($imgurl)."'   ,divId: 'at_".$index."', errMsg: '".$L['ajaxSenderror']."' });\"",

	                ));

$vt->parse("MAIN.ROW.ADMIN_ACT");
echo $vt->text("MAIN.ROW.ADMIN_ACT");
}

if ($action == 'remove'){

							if(file_exists($imgurl))
							{
								unlink($imgurl);
							}
$cfg['verification_plug']['verification_count']--;
cot_config_modify('verification_plug', array('0'=>array('order' => '99', 'name' => 'verification_count','type' => '0', 'value' => "{$cfg['verification_plug']['verification_count']}")),true);
if($cache)$cache->db->remove('cot_cfg', 'system');
echo $L['ver_tools_delete_confirm_done'];
}