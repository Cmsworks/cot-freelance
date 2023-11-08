<?php

/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
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
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('verification', 'plug', 'resources');
// Check permissions and enablement
list($auth_read, $auth_write, $auth_admin) = cot_auth('plug', 'verification');
cot_block($auth_write);

require_once cot_incfile('verification', 'plug', 'config');
require_once cot_langfile('verification', 'plug');
require_once cot_incfile('uploads');

$act = cot_import('act','P','TXT');
$type = cot_import('type','G','TXT');
$confirm = cot_import('confirm','P','TXT');

$action = cot_url('plug','e=verification&type=passport');


if(empty($act) && empty($type))$t->parse("MAIN.START");

if($confirm != "ON" && empty($act) && !empty($type))
{
	cot_error($L['ver_confirm_error'], 'confirm');
    cot_display_messages($t,'MAIN.START');
	$t->parse("MAIN.START");return;

	}

if($type == 'passport'){ // for verification passport

         if($usr['profile']['user_verification_status']){
          $t->parse("MAIN.STATUSEXIST"); return;
         }


		 $code = 'scanpassport';
		 $ext_img = explode(',', $cfg['plugin']['verification']['img_ext']);
		 $file_exist_error =  false;



				// ����� ������������ �����
				$dir = opendir($ver_file_patch);
				while(($file = readdir($dir)) !== false) {
				    $mass_sa = strstr($file,$ver_file_name);
				    if($mass_sa != "") {
				        $file_exist_error = true; $img_mod_url = $ver_file_patch.$mass_sa;
				    }
				}
				closedir($dir);

		// data
		$up_max = ((int)$cfg['plugin']['verification']['img_max_size'] < ((cot_get_uploadmax())/1000 )) ? $cfg['plugin']['verification']['img_max_size'] : (cot_get_uploadmax())/1000;



			$ext_i = 0;
			foreach ($ext_img as $ext)
			{
				if($ext_i > 0){$ext_file .= ","; $ext_txt .= ", ";}
				$ext_file .= "image/".$ext;
				$ext_txt .= $ext;
				$ext_i++;
			}

		if($file_exist_error){$t->parse("MAIN.EXIST"); return;}

		if($act == 'sendform'){

			if($_FILES[$code]['size'] > 0 )
			{   // �������� �����
				@clearstatcache();
					$file = $_FILES[$code];
					if (!empty($file['tmp_name']) && $file['size'] > 0 && is_uploaded_file($file['tmp_name']))
					{
						$gd_supported = $ext_img;
                                                
                                                $exrarr = explode(".", $file['name']);
                                                $file_ext = mb_strtolower(end($exrarr));
                                                
						$fcheck = cot_file_check($file['tmp_name'], $file['name'], $file_ext);
						if(in_array($file_ext, $gd_supported) && $fcheck == 1)
						{
						    $file['name']= cot_safename($file['name'], true);
						    // ������� ��������� ��� RANDOM
							$RANDOM = cot_randomstring();
							$filename_full = $ver_file_name.$RANDOM.'.'.$file_ext;
							$filepath = $ver_file_patch.$filename_full;

							if(file_exists($filepath))
							{
								unlink($filepath);
							}

							move_uploaded_file($file['tmp_name'], $filepath);
							@chmod($filepath, $cfg['file_perms']);

							/* === Hook === */
							foreach (cot_getextplugins('verification.fileload') as $pl)
							{
								include $pl;
							}
							/* ===== */

						}
						elseif($fcheck == 2)
						{
							cot_error(sprintf($L['ver_filemimemissing'], $file_ext), $code);
						}
						else
						{
							cot_error(sprintf($L['ver_imgnotvalid'], $file_ext), $code);
						}
					}

			}else{
			 cot_error($L['ver_nofile'], $code);
			}


		if (!cot_error_found())
		  {
           require_once cot_incfile('configuration');
			/* === Hook === */
			foreach (cot_getextplugins('verification.fileload.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
			$cfg['verification_plug']['verification_count']++;
                     cot_config_modify('verification_plug', array('0'=>array('order' => '99', 'name' => 'verification_count','type' => '0', 'value' => "{$cfg['verification_plug']['verification_count']}")),true);
                    
                    if ($cache){
                      $cache->db->remove('cot_cfg', 'system');
                    }
		    $img_mod_url = $filepath;
		    $t->parse("MAIN.SEND");

		    if(!empty($cfg['plugin']['verification']['mail_notify'])){

                $rsubject = $L['ver_mnotif_ttl'];
                $rbody = sprintf($L['ver_mnotif_txt'], htmlspecialchars($usr['name']));
                cot_mail($cfg['plugin']['verification']['mail_notify'], $rsubject, $rbody);

		    	}

		    return;
		  	}

		cot_display_messages($t,'MAIN.FORM');

		}

		$t->parse("MAIN.FORM");
}
