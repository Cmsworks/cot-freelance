<?php
/**
 * Edit sbr.
 *
 * @package sbr
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forms');

$id = cot_import('id', 'G', 'INT');
//$stagescount = cot_import('stagescount', 'G', 'INT');

if ($id > 0) {
	$query_string = (!$usr['isadmin']) ? " AND sbr_employer=".$usr['id']."" : "";
	$sql = $db->query("SELECT * FROM $db_sbr WHERE sbr_id=" . $id . " " . $query_string . " LIMIT 1");
}

if (!$id || !$sql || $sql->rowCount() == 0) {
	cot_die_message(404, TRUE);
}
$sbr = $sql->fetch();

$cfg['msg_separate'] = true;

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'sbr');

/* === Hook === */
foreach (cot_getextplugins('sbr.edit.first') as $pl) {
	include $pl;
}
/* ===== */

if (!$usr['isadmin']) {
	// Редактировать можно только новую сделку, которая еще полностью не оформлена
	cot_block($usr['auth_write'] && ($sbr['sbr_status'] == 'new' || $sbr['sbr_status'] == 'confirm' || $sbr['sbr_status'] == 'refuse'));
}

if ($a == 'update') {
	cot_shield_protect();

	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'sbr', 'RWA');
	cot_block($usr['auth_write']);
	
	/* === Hook === */
	foreach (cot_getextplugins('sbr.edit.edit.first') as $pl) {
		include $pl;
	}
	/* ===== */
	
	$rsbrtitle = cot_import('rsbrtitle', 'P', 'TXT');
	$rsbrsubmit = cot_import('rsbrsubmit', 'P', 'ALP');
	
	$rstagetitle = cot_import('rstagetitle', 'P', 'ARR');
	$rstagetext = cot_import('rstagetext', 'P', 'ARR');
	$rstagecost = cot_import('rstagecost', 'P', 'ARR');
	$rstagedays = cot_import('rstagedays', 'P', 'ARR');
    $rStageExpire = cot_import('rstageexpire', 'P', 'ARR');

	// Валидация стадий
	cot_validate_stages($rstagetitle, $rstagetext, false);

	$rstagefiles = $_FILES['rstagefiles'];
	$rfilestoremove = cot_import('rfilestoremove', 'P', 'ARR');
	
	$stagescount = cot_import('stagescount', 'P', 'INT');
    if (empty($stagescount)) {
        $stagescount = 1;
    }
	
	/* === Hook === */
	foreach (cot_getextplugins('sbr.edit.edit.import') as $pl) {
		include $pl;
	}
	/* ===== */
	
	$rsbr['sbr_title'] = $rsbrtitle;

	cot_check(empty($rsbrtitle), $L['sbr_error_rsbrtitle'], 'rsbrtitle');
	
	for ($i = 1; $i <= $stagescount; $i++) {
        if (cot::$cfg['plugin']['sbr']['stages_on'] && $stagescount > 1) {
            // Если у нас только 1 этап. Название этапа можно не указывать
            cot_check(empty($rstagetitle[$i]), $L['sbr_error_rstagetitle'], 'rstagetitle[' . $i . ']');
        }
		cot_check(empty($rstagetext[$i]), $L['sbr_error_rstagetext'], 'rstagetext['.$i.']');
		cot_check(empty($rstagecost[$i]), $L['sbr_error_rstagecost'], 'rstagecost['.$i.']');
		cot_check((!empty($rstagecost[$i]) && $rstagecost[$i] < $cfg['plugin']['sbr']['mincost'] && $cfg['plugin']['sbr']['mincost'] > 0), $L['sbr_error_rstagecostmin'], 'rstagecost['.$i.']');
		cot_check((!empty($rstagecost[$i]) && $rstagecost[$i] > $cfg['plugin']['sbr']['maxcost'] && $cfg['plugin']['sbr']['maxcost'] > 0), $L['sbr_error_rstagecostmax'], 'rstagecost['.$i.']');

        if (!empty($rStageExpire[$i])) {
            $rStageExpire[$i] = cot_import_date($rStageExpire[$i], true, false, 'D');
        }
        if (empty($rStageExpire[$i])) {
            $rStageExpire[$i] = 0;
        }
        $rstagedays[$i] = (int) $rstagedays[$i];
        cot_check(
            empty($rstagedays[$i]) && empty($rStageExpire[$i]),
            cot::$L['sbr_error_rstagedays'],
            'rstagedays[' . $i . ']'
        );

		cot_check(
            (
                !empty($rstagedays[$i])
                && $rstagedays[$i] > $cfg['plugin']['sbr']['maxdays']
                && $cfg['plugin']['sbr']['maxdays'] > 0
            ),
            $L['sbr_error_rstagedaysmax'],
            'rstagedays['.$i.']'
        );

        cot_check(
            ($rStageExpire[$i] > 0 && $rStageExpire[$i] < cot::$sys['now']),
            'Дата окончания срока исполнения не может быть в прошлом',
            'rstageexpire[' . $i . ']'
        );
		
		/* === Hook === */
		foreach (cot_getextplugins('sbr.edit.edit.stages.error') as $pl) {
			include $pl;
		}
		/* ===== */

		$rsbr['sbr_cost'] += $rstagecost[$i];
	}

	$rsbr['sbr_tax'] = $rsbr['sbr_cost']*$cfg['plugin']['sbr']['tax']/100;
	
	/* === Hook === */
	foreach (cot_getextplugins('sbr.edit.edit.error') as $pl) {
		include $pl;
	}
	/* ===== */

	if (!cot_error_found()) {
		if ($rsbrsubmit == 'draft') {
			$rsbr['sbr_status'] = 'draft';
		} else {
			$rsbr['sbr_status'] = 'new';
			$rsbr['sbr_update'] = $sys['now'];
		}

		$db->update($db_sbr, $rsbr, "sbr_id = ?", $sbr['sbr_id']);
		$db->delete($db_sbr_stages, "stage_num > :stage_num AND stage_sid = :stage_sid", array(
			":stage_num" => $stagescount,
			":stage_sid" => $sbr['sbr_id'],
		));
		
		$stages = $db->query("SELECT * FROM $db_sbr_stages WHERE stage_sid=" . $sbr['sbr_id'] . " ORDER BY stage_num ASC")->fetchAll();
		foreach($stages as $stage) {
			$rstage['stage_title'] = $rstagetitle[$stage['stage_num']];
			$rstage['stage_text'] = $rstagetext[$stage['stage_num']];
			$rstage['stage_cost'] = $rstagecost[$stage['stage_num']];
			$rstage['stage_days'] = $rstagedays[$stage['stage_num']];
            $rstage['stage_expire'] = $rStageExpire[$stage['stage_num']];
			
			$db->update($db_sbr_stages, $rstage, "stage_num = :stage_num AND stage_sid = :stage_sid", array(
				":stage_num" => $stage['stage_num'],
				":stage_sid" => $sbr['sbr_id'],
			));
		}
		
		for ($i = $stage['stage_num'] + 1; $i <= $stagescount; $i++) {
			$rstage['stage_sid'] = $id;
			$rstage['stage_num'] = $i;
			$rstage['stage_title'] = $rstagetitle[$i];
			$rstage['stage_text'] = $rstagetext[$i];
			$rstage['stage_cost'] = $rstagecost[$i];
			$rstage['stage_days'] = $rstagedays[$i];
			
			$db->insert($db_sbr_stages, $rstage);
			$stageid = $db->lastInsertId();
		}

		if(is_array($rfilestoremove) && count($rfilestoremove) > 0)
		{
			$filestoremove = $db->query("SELECT * FROM $db_sbr_files WHERE file_sid=$id AND file_id IN (".implode(',', $rfilestoremove).")")->fetchAll();
			foreach($filestoremove as $row)
			{
				unlink($row['file_url']);
			}
			
			$db->delete($db_sbr_files, "file_id IN (".implode(',', $rfilestoremove).")");	
		}
		
		$sbr_path = $cfg['plugin']['sbr']['filepath'] . '/' . $id . '/';
		
		for($i = 1; $i <= $stagescount; $i++)
		{
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
		
		$performer = $db->query("SELECT * FROM $db_users WHERE user_id=" . $sbr['sbr_performer'])->fetch();
		$rsubject = cot_rc($L['sbr_mail_toperformer_edited_header'], array('sbr_title' => $rsbr['sbr_title']));
		$rbody = cot_rc($L['sbr_mail_toperformer_edited_body'], array(
			'performer_name' => $performer['user_name'],
			'employer_name' => $usr['profile']['user_name'],
			'sbr_title' => $rsbr['sbr_title'],
			'sbr_cost' => $rsbr['sbr_cost'].' '.$cfg['payments']['valuta'],	
			'sitename' => $cfg['maintitle'],
			'link' => COT_ABSOLUTE_URL . cot_url('sbr', "id=" . $id, '', true)
		));
		cot_mail ($performer['user_email'], $rsubject, $rbody);

		cot_sbr_sendpost($id, $L['sbr_posts_performer_edited'], $performer['user_id'], 0, 'info');
		cot_sbr_sendpost($id, $L['sbr_posts_employer_edited'], $usr['id'], 0, 'info');

		
		cot_redirect(cot_url('sbr', 'id=' . $id, '', true));
	}
}

$out['subtitle'] = $L['sbr_edittitle'];
$out['head'] .= $R['code_noindex'];

$mskin = cot_tplfile(array('sbr', 'edit'), 'plug');

/* === Hook === */
foreach (cot_getextplugins('sbr.edit.main') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

$t->assign(cot_generate_sbrtags($sbr, 'SBR_'));

$t->assign(cot_generate_usertags($sbr['sbr_performer'], 'SBR_PERFORMER_'));
if(!empty($sbr['sbr_pid']))
{
	$t->assign(cot_generate_projecttags($sbr['sbr_pid'], 'SBR_PROJECT_'));
}

$patharray[] = array(cot_url('sbr'), $L['sbr']);
$patharray[] = array(cot_url('sbr', 'm=edit&id='.$id), $L['sbr_edittitle']);

$t->assign(array(
	'SBREDIT_TITLE' => cot_breadcrumbs($patharray, $cfg['homebreadcrumb'], true),
	'SBREDIT_SUBTITLE' => $L['sbr_edittitle'],
	'SBREDIT_ADMINEMAIL' => "mailto:".$cfg['adminemail'],
	'SBREDIT_FORM_SEND' => cot_url('sbr', 'm=edit&id='.$id.'&a=update'),
	'SBREDIT_FORM_OWNER' => cot_build_user($usr['id'], htmlspecialchars($usr['name'])),
	'SBREDIT_FORM_OWNERID' => $usr['id'],
	'SBREDIT_FORM_MAINTITLE' => cot_inputbox('text', 'rsbrtitle', $sbr['sbr_title']),
));	

$stages = $db->query("SELECT * FROM $db_sbr_stages WHERE stage_sid=" . $sbr['sbr_id'] . " ORDER BY stage_num ASC")->fetchAll();
if (empty($stagescount)) {
    $stagescount = count($stages);
}

foreach($stages as $stage) {
	$t->assign(array(
		'STAGEEDIT_FORM_NUM' => $stage['stage_num'],
		'STAGEEDIT_FORM_TITLE' => cot_inputbox('text', 'rstagetitle['.$stage['stage_num'].']', $stage['stage_title']),
		'STAGEEDIT_FORM_TEXT' => cot_textarea('rstagetext['.$stage['stage_num'].']', $stage['stage_text'], 10, 120, '', 'input_textarea'),
		'STAGEEDIT_FORM_COST' => cot_inputbox(
            'text',
            'rstagecost['.$stage['stage_num'].']',
            $stage['stage_cost'],
            array('class' => 'stagecost', 'maxlength' => '100')
        ),
		'STAGEEDIT_FORM_DAYS' => cot_inputbox(
            'text',
            'rstagedays['.$stage['stage_num'].']',
            !empty($stage['stage_days']) ? $stage['stage_days'] : '',
            ['maxlength' => '100']
        ),
        'STAGEEDIT_FORM_EXPIRE' => cot_inputbox(
            'datetime-local',
            'rstageexpire[' . $stage['stage_num'] . ']',
            !empty($stage['stage_expire']) ?
                cot_date('Y-m-d\TH:i:s', $stage['stage_expire'])
                : cot_date('Y-m-d\TH:i:s', $sbr['sbr_create']),
            ['min' => cot_date('Y-m-d\TH:i:s', $sbr['sbr_create'])]
        ),
	));

	$stagefiles = $db->query("SELECT * FROM $db_sbr_files WHERE file_sid=" . $sbr['sbr_id'] . " AND file_area='stage' AND file_code='".$stage['stage_num']."' ORDER BY file_id ASC")->fetchAll();
	foreach($stagefiles as $file)
	{
		$t->assign(array(
			'FILE_ROW_ID' => $file['file_id'],
			'FILE_ROW_URL' => $file['file_url'],
			'FILE_ROW_TITLE' => $file['file_title'],
			'FILE_ROW_EXT' => $file['file_ext'],
			'FILE_ROW_SIZE' => $file['file_size'],
		));
		$t->parse('MAIN.STAGE_ROW.FILE_ROW');
	}
	
	/* === Hook === */
	foreach (cot_getextplugins('sbr.edit.stages.tags') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse('MAIN.STAGE_ROW');
}

for ($i = $stage['stage_num'] + 1; $i <= $stagescount; $i++)
{
	$t->assign(array(
		'STAGEEDIT_FORM_NUM' => $i,
		'STAGEEDIT_FORM_TITLE' => cot_inputbox('text', 'rstagetitle['.$i.']', $rstagetitle[$i]),
		'STAGEEDIT_FORM_TEXT' => cot_textarea('rstagetext['.$i.']', $rstagetext[$i], 10, 120, '', 'input_textarea'),
		'STAGEEDIT_FORM_COST' => cot_inputbox('text', 'rstagecost['.$i.']', $rstagecost[$i], array('class' => 'stagecost', 'size' => '10', 'maxlength' => '100')),
		'STAGEEDIT_FORM_DAYS' => cot_inputbox('text', 'rstagedays['.$i.']', $rstagedays[$i], array('size' => '10', 'maxlength' => '100')),
        'STAGEEDIT_FORM_EXPIRE' => cot_inputbox(
            'datetime-local',
            'rstageexpire['.$i.']',
            !empty($rStageExpire[$i]) ?
                cot_date('Y-m-d\TH:i:s', $rStageExpire[$i])
                : cot_date('Y-m-d\TH:i:s'),
            ['min' => cot_date('Y-m-d\TH:i:s')]
        ),
	));

	/* === Hook === */
	foreach (cot_getextplugins('sbr.edit.stages.tags') as $pl) {
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
		'SBREDIT_FORM_'.$uname => $exfld_val,
		'SBREDIT_FORM_'.$uname.'_TITLE' => $exfld_title,
		'SBREDIT_FORM_EXTRAFLD' => $exfld_val,
		'SBREDIT_FORM_EXTRAFLD_TITLE' => $exfld_title
		));
	$t->parse('MAIN.EXTRAFLD');
}

// Error and message handling
cot_display_messages($t);

/* === Hook === */
foreach (cot_getextplugins('sbr.edit.tags') as $pl)
{
	include $pl;
}
/* ===== */
