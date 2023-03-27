<?php

/**
 * Sbr plugin
 *
 * @package sbr
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('sbr', 'plug');
require_once cot_incfile('sbr', 'plug', 'resources');

// Global variables
global $db_sbr, $db_sbr_stages, $db_sbr_claims, $db_x;
$db_sbr = (isset($db_sbr)) ? $db_sbr : $db_x . 'sbr';
$db_sbr_stages = (isset($db_sbr_stages)) ? $db_sbr_stages : $db_x . 'sbr_stages';
$db_sbr_posts = (isset($db_sbr_posts)) ? $db_sbr_posts : $db_x . 'sbr_posts';
$db_sbr_claims = (isset($db_sbr_claims)) ? $db_sbr_claims : $db_x . 'sbr_claims';
$db_sbr_files = (isset($db_sbr_files)) ? $db_sbr_files : $db_x . 'sbr_files';

$cot_extrafields[$db_sbr] = (!empty($cot_extrafields[$db_sbr])) ? $cot_extrafields[$db_sbr] : array();


function cot_generate_sbrtags($item_data, $tag_prefix = '', $admin_rights = null, $pagepath_home = false)
{
	global $db, $cot_extrafields, $cfg, $L, $Ls, $R, $db_sbr, $db_sbr_stages, $sys;

	static $extp_first = null, $extp_main = null;

	if (is_null($extp_first))
	{
		$extp_first = cot_getextplugins('sbrtags.first');
		$extp_main = cot_getextplugins('sbrtags.main');
	}

	/* === Hook === */
	foreach ($extp_first as $pl)
	{
		include $pl;
	}
	/* ===== */
	if (!is_array($item_data))
	{
		$sql = $db->query("SELECT * FROM $db_sbr WHERE sbr_id = '" . (int)$item_data . "' LIMIT 1");
		$item_data = $sql->fetch();
	}

	if ($item_data['sbr_id'] > 0 && !empty($item_data['sbr_title']))
	{
		if (is_null($admin_rights))
		{
			$admin_rights = cot_auth('plug', 'sbr', 'A');
		}
		
		$patharray[] = array(cot_url('sbr'), $L['sbr']);
		$patharray[] = array(cot_url('sbr', 'id='.$item_data['sbr_id']), $item_data['sbr_title']);
		
		$itempath = cot_breadcrumbs($patharray, $pagepath_home, true);
		
		$temp_array = array(
			'ID' => $item_data['sbr_id'],
			'STATUS' => $item_data['sbr_status'],
			'LOCALSTATUS' => $L['sbr_status_'.$item_data['sbr_status']],
			'LABELSTATUS' => $R['sbr_labels'][$item_data['sbr_status']],
			'URL' => cot_url('sbr', 'id='.$item_data['sbr_id']),
			'TITLE' => $itempath,
			'SHORTTITLE' => $item_data['sbr_title'],
			'CREATEDATE' => date('d.m.Y H:i', $item_data['sbr_create']),
			'CREATEDATE_STAMP' => $item_data['sbr_create'],
			'BEGINDATE' => date('d.m.Y H:i', $item_data['sbr_begin']),
			'BEGINDATE_STAMP' => $item_data['sbr_begin'],
			'DONEDATE' => date('d.m.Y H:i', $item_data['sbr_done']),
			'DONEDATE_STAMP' => $item_data['sbr_done'],
			'COST' => $item_data['sbr_cost'],
			'TAX' => $item_data['sbr_tax'],
			'TOTAL' => $item_data['sbr_cost'] + $item_data['sbr_tax'],
			'USER_IS_ADMIN' => ($admin_rights || $usr['id'] == $item_data['item_userid']),
		);

		if ($admin_rights || $usr['id'] == $item_data['sbr_employer'])
		{
			$temp_array['ADMIN_EDIT'] = cot_rc_link(cot_url('sbr', 'm=edit&id=' . $item_data['sbr_id']), $L['Edit']);
			$temp_array['ADMIN_EDIT_URL'] = cot_url('sbr', 'm=edit&id=' . $item_data['sbr_id']);
		}

		// Extrafields
		if (isset($cot_extrafields[$db_sbr]))
		{
			foreach ($cot_extrafields[$db_sbr] as $exfld)
			{
				$tag = mb_strtoupper($exfld['field_name']);
				$temp_array[$tag . '_TITLE'] = isset($L['sbr_' . $exfld['field_name'] . '_title']) ? $L['sbr_' . $exfld['field_name'] . '_title'] : $exfld['field_description'];
				$temp_array[$tag] = cot_build_extrafields_data('sbr', $exfld, $item_data['item_' . $exfld['field_name']]);
			}
		}

		/* === Hook === */
		foreach ($extp_main as $pl)
		{
			include $pl;
		}
		/* ===== */
	}
	else
	{
		$temp_array = array(
			'TITLE' => (!empty($emptytitle)) ? $emptytitle : $L['Deleted'],
			'SHORTTITLE' => (!empty($emptytitle)) ? $emptytitle : $L['Deleted'],
		);
	}

	$return_array = array();
	foreach ($temp_array as $key => $val)
	{
		$return_array[$tag_prefix . $key] = $val;
	}

	return $return_array;
}



function cot_sbr_counters()
{
	global $db, $db_sbr, $db_sbr_files, $usr, $R;
	
	$counters['all'] = 0;
	
	$sbrstat = array();
	$sbrstat = $db->query("SELECT sbr_status as status, COUNT(*) as count FROM $db_sbr 
		WHERE (sbr_employer=" . $usr['id'] . " OR sbr_performer=" . $usr['id'] . ") 
		GROUP BY sbr_status")->fetchAll();
	foreach ($sbrstat as $stat)
	{
		$counters[$stat['status']] = $stat['count'];
		$counters['all'] += $stat['count'];
	}
	
	foreach ($R['sbr_statuses'] as $status)
	{
		$counters[$status] = ($counters[$status] > 0) ? $counters[$status] : 0;
	}
	
	return $counters;
}

function cot_sbr_sendpost($id, $text, $to, $from = 0, $type = '', $mail = false, $rfiles = array())
{
	global $db, $db_sbr_posts, $db_sbr, $db_sbr_files, $db_users, $sys, $cfg, $L, $R;
	
	$rpost['post_sid'] = $id;
	$rpost['post_text'] = $text;
	$rpost['post_date'] = $sys['now'];
	$rpost['post_from'] = $from;
	$rpost['post_to'] = $to;
	$rpost['post_type'] = $type;

	/* === Hook === */
	foreach (cot_getextplugins('sbr.post.add.query') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	if($db->insert($db_sbr_posts, $rpost))
	{
		$postid = $db->lastInsertId();
		
		$sbr_path = $cfg['plugin']['sbr']['filepath'] . '/' . $id . '/';
		if (!file_exists($sbr_path))
		{
			mkdir($sbr_path);
			@chmod($sbr_path, $cfg['dir_perms']);
		}
		
		for($j = 0; $j < 10; $j++)
		{
			if($rfiles['size'][$j] > 0 && $rfiles['error'][$j] == 0)
			{
				$u_tmp_name_file = $rfiles['tmp_name'][$j];
				$u_type_file = $rfiles['type'][$j];
				$u_name_file = $rfiles['name'][$j];
				$u_size_file = $rfiles['size'][$j];

				$u_name_file  = str_replace("\'",'',$u_name_file );
				$u_name_file  = trim(str_replace("\"",'',$u_name_file ));
				$dotpos = strrpos($u_name_file,".")+1;
				$f_extension = substr($u_name_file, $dotpos, 5);

				if(!empty($u_tmp_name_file))
				{
					$fcheck = cot_file_check($u_tmp_name_file, $u_name_file, $f_extension);
					if($fcheck == 1){
						if(in_array($f_extension, explode(',', $cfg['plugin']['sbr']['extensions'])))
						{
							$u_newname_file = $postid."_".md5(uniqid(rand(),true)).".".$f_extension;
							$file = $sbr_path . $u_newname_file;

							move_uploaded_file($u_tmp_name_file, $file);
							@chmod($file, 0766);

							$rfile['file_sid'] = $id;
							$rfile['file_url'] = $file;
							$rfile['file_title'] = $u_name_file;
							$rfile['file_area'] = 'post';
							$rfile['file_code'] = $postid;
							$rfile['file_ext'] = $f_extension;
							$rfile['file_size'] = floor($u_size_file / 1024);

							$db->insert($db_sbr_files, $rfile);
						}
					}
				}
			}
		}

		// Отправка сообщения на почту!
		if($mail)
		{
			$sbr = $db->query("SELECT * FROM $db_sbr WHERE sbr_id=" . $id)->fetch();
			
			if(!empty($to))
			{
				$recipients[] = $db->query("SELECT * FROM $db_users WHERE user_id=" . $to)->fetch();
			}
			else
			{
				$recipients[] = $db->query("SELECT * FROM $db_users WHERE user_id=" . $sbr['sbr_performer'])->fetch();
				$recipients[] = $db->query("SELECT * FROM $db_users WHERE user_id=" . $sbr['sbr_employer'])->fetch();
			}
			
			if(!empty($from))
			{
				$sender = $db->query("SELECT * FROM $db_users WHERE user_id=" . $from)->fetch();
			}
			
			foreach($recipients as $recipient)
			{
				if(!empty($from))
				{
					$rsubject = cot_rc($L['sbr_mail_posts_header'], array('sbr_id' => $id, 'sbr_title' => $sbr['sbr_title']));
					$rbody = cot_rc($L['sbr_mail_posts_body'], array(
						'user_name' => $recipient['user_name'],	
						'sender_name' => $sender['user_name'],	
						'post_text' => $text,	
						'sitename' => $cfg['maintitle'],
						'link' => COT_ABSOLUTE_URL . cot_url('sbr', "id=" . $id, '', true)
					));
				}
				else
				{
					$rsubject = cot_rc($L['sbr_mail_notification_header'], array('sbr_id' => $id, 'sbr_title' => $sbr['sbr_title']));
					$rbody = cot_rc($L['sbr_mail_notification_body'], array(
						'user_name' => $recipient['user_name'],
						'post_text' => $text,	
						'sitename' => $cfg['maintitle'],
						'link' => COT_ABSOLUTE_URL . cot_url('sbr', "id=" . $id, '', true)
					));
				}
				cot_mail ($recipient['user_email'], $rsubject, $rbody, '', false, null, true);
			}
		}

		/* === Hook === */
		foreach (cot_getextplugins('sbr.post.add.done') as $pl)
		{
			include $pl;
		}
		/* ===== */

		return $db->lastInsertId();
	}
	
	return false;
}

/**
 * Вычищаем ненужные символы из названий и текстов стадий
 *
 * @param array $rstagetitle Массив из title стадий
 * @param array $rstagetext Массив из text стадий
 * @param bool $purifier TRUE - вычистить внутренности скриптов, FALSE - заменить допустимыми символами
 */
function cot_validate_stages(&$rstagetitle, &$rstagetext, $purifier = false) {
	// Если включен плагин htmlpurifier, то очищаем через него
	if ($purifier === true) {
		if (cot_plugin_active('htmlpurifier') && function_exists('htmlpurifier_filter')) {
			foreach ($rstagetitle as $key => $value) {
				$rstagetitle[$key] = htmlpurifier_filter($value, false);
			}
			foreach ($rstagetext as $key => $value) {
				$rstagetext[$key] = htmlpurifier_filter($value, false);
			}
		}
		else {
			error_log('Попытка функции cot_validate_stages валидировать title и text с помощью неактивного плагина htmlpurifier');
			return false;
		}
	}
	// Иначе производим замену наподобии cot_import с фильтром 'TXT'
	else {
		foreach ($rstagetitle as $key => $value) {
			$rstagetitle[$key] = str_replace('<', '&lt;', trim($value));
		}
		foreach ($rstagetext as $key => $value) {
			$rstagetext[$key] = str_replace('<', '&lt;', trim($value));
		}
	}
}

