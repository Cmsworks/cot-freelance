<?php
/**
 * Add sbr.
 *
 * @package sbr
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forms');

$pid = cot_import('pid', 'G', 'INT');
$uid = cot_import('uid', 'G', 'INT');
$stagescount = cot_import('stagescount', 'G', 'INT');
if(empty($stagescount)) $stagescount = 1;

$cfg['msg_separate'] = true;

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'sbr');

/* === Hook === */
foreach (cot_getextplugins('sbr.add.first') as $pl)
{
	include $pl;
}
/* ===== */

cot_block($usr['auth_write'] && $uid != $usr['id']);

if ($a == 'add')
{
	cot_shield_protect();

	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'sbr', 'RWA');
	cot_block($usr['auth_write']);
	
	/* === Hook === */
	foreach (cot_getextplugins('sbr.add.add.first') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	$rsbrtitle = cot_import('rsbrtitle', 'P', 'TXT');
	$rsbrsubmit = cot_import('rsbrsubmit', 'P', 'ALP');
	
	$rstagetitle = cot_import('rstagetitle', 'P', 'ARR');
	$rstagetext = cot_import('rstagetext', 'P', 'ARR');
	$rstagecost = cot_import('rstagecost', 'P', 'ARR');
	$rstagedays = cot_import('rstagedays', 'P', 'ARR');
	
	$rstagefiles = $_FILES['rstagefiles'];

	$stagescount = cot_import('stagescount', 'P', 'INT');
	
	/* === Hook === */
	foreach (cot_getextplugins('sbr.add.add.import') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if(empty($uid))
	{
		$rsbrperformer = cot_import('rsbrperformer', 'P', 'TXT', 100, TRUE);
		$rsbr['sbr_performer'] = $db->query("SELECT user_id FROM $db_users WHERE user_name = ? LIMIT 1", array($rsbrperformer))->fetchColumn();
		if (empty($rsbr['sbr_performer'])) cot_error('sbr_error_rsbrperformer', 'rsbrperformer');
		if ($rsbr['sbr_performer'] == $usr['id']) cot_error('sbr_error_rsbrperformernotyou', 'rsbrperformer');
	}
	else
	{
		$rsbr['sbr_performer'] = $uid;
	}
	
	cot_check(empty($rsbrtitle), $L['sbr_error_rsbrtitle'], 'rsbrtitle');
	
	for($i = 1; $i <= $stagescount; $i++)
	{
		cot_check(empty($rstagetitle[$i]), $L['sbr_error_rstagetitle'], 'rstagetitle['.$i.']');
		cot_check(empty($rstagetext[$i]), $L['sbr_error_rstagetext'], 'rstagetext['.$i.']');
		cot_check(empty($rstagecost[$i]), $L['sbr_error_rstagecost'], 'rstagecost['.$i.']');
		cot_check((!empty($rstagecost[$i]) && $rstagecost[$i] < $cfg['plugin']['sbr']['mincost'] && $cfg['plugin']['sbr']['mincost'] > 0), $L['sbr_error_rstagecostmin'], 'rstagecost['.$i.']');
		cot_check((!empty($rstagecost[$i]) && $rstagecost[$i] > $cfg['plugin']['sbr']['maxcost'] && $cfg['plugin']['sbr']['maxcost'] > 0), $L['sbr_error_rstagecostmax'], 'rstagecost['.$i.']');
		cot_check(empty($rstagedays[$i]), $L['sbr_error_rstagedays'], 'rstagedays['.$i.']');
		cot_check((!empty($rstagedays[$i]) && $rstagedays[$i] > $cfg['plugin']['sbr']['maxdays'] && $cfg['plugin']['sbr']['maxdays'] > 0), $L['sbr_error_rstagedaysmax'], 'rstagedays['.$i.']');

		/* === Hook === */
		foreach (cot_getextplugins('sbr.add.add.stages.error') as $pl)
		{
			include $pl;
		}
		/* ===== */

		$rsbr['sbr_cost'] += $rstagecost[$i];
	}

	$rsbr['sbr_tax'] = $rsbr['sbr_cost']*$cfg['plugin']['sbr']['tax']/100;
	
	$rsbr['sbr_title'] = $rsbrtitle;
	$rsbr['sbr_pid'] = $pid;
	$rsbr['sbr_employer'] = $usr['id'];
	
	/* === Hook === */
	foreach (cot_getextplugins('sbr.add.add.error') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	if (!cot_error_found())
	{
		$rsbr['sbr_status'] = 'new';
		$rsbr['sbr_create'] = $sys['now'];

		$db->insert($db_sbr, $rsbr);
		$id = $db->lastInsertId();
		
		for($i = 1; $i <= $stagescount; $i++)
		{
			$rstage['stage_sid'] = $id;
			$rstage['stage_num'] = $i;
			$rstage['stage_title'] = $rstagetitle[$i];
			$rstage['stage_text'] = $rstagetext[$i];
			$rstage['stage_cost'] = $rstagecost[$i];
			$rstage['stage_days'] = $rstagedays[$i];
			
			$db->insert($db_sbr_stages, $rstage);
			$stageid = $db->lastInsertId();
			
			$sbr_path = $cfg['plugin']['sbr']['filepath'] . '/' . $id . '/';
			if (!file_exists($sbr_path))
			{
				mkdir($sbr_path);
				@chmod($sbr_path, $cfg['dir_perms']);
			}

			for($j = 0; $j < 10; $j++)
			{
				if($rstagefiles['size'][$i][$j] > 0 && $rstagefiles['error'][$i][$j] == 0)
				{
					$u_tmp_name_file = $rstagefiles['tmp_name'][$i][$j];
					$u_type_file = $rstagefiles['type'][$i][$j];
					$u_name_file = $rstagefiles['name'][$i][$j];
					$u_size_file = $rstagefiles['size'][$i][$j];

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
								$u_newname_file = $i."_".md5(uniqid(rand(),true)).".".$f_extension;
								$file = $sbr_path . $u_newname_file;

								move_uploaded_file($u_tmp_name_file, $file);
								@chmod($file, 0766);

								$rfile['file_sid'] = $id;
								$rfile['file_url'] = $file;
								$rfile['file_title'] = $u_name_file;
								$rfile['file_area'] = 'stage';
								$rfile['file_code'] = $i;
								$rfile['file_ext'] = $f_extension;
								$rfile['file_size'] = floor($u_size_file / 1024);
								
								$db->insert($db_sbr_files, $rfile);
							}
						}
					}
				}
			}
		}

		$performer = $db->query("SELECT * FROM $db_users WHERE user_id=" . $rsbr['sbr_performer'])->fetch();
		$rsubject = cot_rc($L['sbr_mail_toperformer_new_header'], array('sbr_title' => $rsbr['sbr_title']));
		$rbody = cot_rc($L['sbr_mail_toperformer_new_body'], array(
			'performer_name' => $performer['user_name'],
			'employer_name' => $usr['profile']['user_name'],
			'sbr_title' => $rsbr['sbr_title'],
			'sbr_cost' => $rsbr['sbr_cost'].' '.$cfg['payments']['valuta'],	
			'sitename' => $cfg['maintitle'],
			'link' => COT_ABSOLUTE_URL . cot_url('sbr', "id=" . $id, '', true)
		));
		cot_mail ($performer['user_email'], $rsubject, $rbody);

		cot_sbr_sendpost($id, $L['sbr_posts_performer_new'], $rsbr['sbr_performer'], 0, 'info');
		cot_sbr_sendpost($id, $L['sbr_posts_employer_new'], $usr['id'], 0, 'info');
		
		cot_redirect(cot_url('sbr', 'id=' . $id, '', true));
	}
}

$out['subtitle'] = $L['sbr_addtitle'];
$out['head'] .= $R['code_noindex'];

$mskin = cot_tplfile(array('sbr', 'add'), 'plug');

/* === Hook === */
foreach (cot_getextplugins('sbr.add.main') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

if(!empty($uid))
{
	$t->assign(cot_generate_usertags($uid, 'SBR_PERFORMER_'));
}
else
{
	$t->assign('SBRADD_FORM_PERFORMER', cot_inputbox('text', 'rsbrperformer', $rsbrperformer, 'placeholder="'.$L['sbr_performer_placeholder'].'"'));
}

if(!empty($pid))
{
	$t->assign(cot_generate_projecttags($pid, 'SBR_PROJECT_'));
}

$patharray[] = array(cot_url('sbr'), $L['sbr']);
$patharray[] = array(cot_url('sbr', 'm=add&pid='.$pid.'&uip='.$uid), $L['sbr_addtitle']);

$t->assign(array(
	'SBRADD_TITLE' => cot_breadcrumbs($patharray, $cfg['homebreadcrumb'], true),
	'SBRADD_SUBTITLE' => $L['sbr_addtitle'],
	'SBRADD_ADMINEMAIL' => "mailto:".$cfg['adminemail'],
	'SBRADD_FORM_SEND' => cot_url('sbr', 'm=add&pid='.$pid.'&uid='.$uid.'&a=add'),
	'SBRADD_FORM_OWNER' => cot_build_user($usr['id'], htmlspecialchars($usr['name'])),
	'SBRADD_FORM_OWNERID' => $usr['id'],
	'SBRADD_FORM_MAINTITLE' => cot_inputbox('text', 'rsbrtitle', $rsbr['sbr_title']),
));	
	
for($i = 1; $i <= $stagescount; $i++)
{
	$t->assign(array(
		'STAGEADD_FORM_NUM' => $i,
		'STAGEADD_FORM_TITLE' => cot_inputbox('text', 'rstagetitle['.$i.']', $rstagetitle[$i]),
		'STAGEADD_FORM_TEXT' => cot_textarea('rstagetext['.$i.']', $rstagetext[$i], 10, 120, '', 'input_textarea'),
		'STAGEADD_FORM_COST' => cot_inputbox('text', 'rstagecost['.$i.']', $rstagecost[$i], array('class' => 'stagecost', 'size' => '10', 'maxlength' => '100')),
		'STAGEADD_FORM_DAYS' => cot_inputbox('text', 'rstagedays['.$i.']', $rstagedays[$i], array('size' => '10', 'maxlength' => '100')),
	));

	/* === Hook === */
	foreach (cot_getextplugins('sbr.add.stages.tags') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse('MAIN.STAGE_ROW');
}

// Extra fields
foreach($cot_extrafields[$db_sbr] as $exfld)
{
	$uname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields('rsbr'.$exfld['field_name'], $exfld, $rsbr['sbr_'.$exfld['field_name']]);
	$exfld_title = isset($L['sbr_'.$exfld['field_name'].'_title']) ?  $L['sbr_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
	$t->assign(array(
		'SBRADD_FORM_'.$uname => $exfld_val,
		'SBRADD_FORM_'.$uname.'_TITLE' => $exfld_title,
		'SBRADD_FORM_EXTRAFLD' => $exfld_val,
		'SBRADD_FORM_EXTRAFLD_TITLE' => $exfld_title
		));
	$t->parse('MAIN.EXTRAFLD');
}

// Error and message handling
cot_display_messages($t);

/* === Hook === */
foreach (cot_getextplugins('sbr.add.tags') as $pl)
{
	include $pl;
}
/* ===== */
