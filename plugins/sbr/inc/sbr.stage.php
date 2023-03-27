<?php
/**
 * Stage info of sbr.
 *
 * @package sbr
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forms');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'sbr');

/* === Hook === */
foreach (cot_getextplugins('sbr.stage.first') as $pl)
{
	include $pl;
}
/* ===== */

if(!empty($num))
{
	$sql = $db->query("SELECT * FROM $db_sbr_stages WHERE stage_sid=" . $id . " AND stage_num=" . $num . " LIMIT 1");
	$stage = $sql->fetch();
}

$t->assign(array(
	'STAGE_NUM' => $stage['stage_num'],
	'STAGE_ID' => $stage['stage_id'],
	'STAGE_TITLE' => $stage['stage_title'],
	'STAGE_TEXT' => $stage['stage_text'],
	'STAGE_COST' => $stage['stage_cost'],
	'STAGE_DAYS' => $stage['stage_days'],
	'STAGE_STATUS' => $stage['stage_status'],
	'STAGE_BEGIN' => $stage['stage_begin'],
	'STAGE_DONE' => $stage['stage_done'],
	'STAGE_EXPIRE' => $stage['stage_expire'],
	'STAGE_EXPIREDATE' => $stage['stage_begin'] + $stage['stage_days']*24*60*60,
	'STAGE_EXPIREDAYS' => cot_build_timegap($sys['now'], $stage['stage_begin'] + $stage['stage_days']*24*60*60),
	'STAGE_DONE_URL' => cot_url('sbr', 'id=' . $id . '&num=' . $stage['stage_num'] . '&action=done'),
	'STAGE_CLAIM_URL' => cot_url('sbr', 'id=' . $id . '&num=' . $stage['stage_num'] . '&action=claim'),
	'STAGE_DECISION_URL' => cot_url('sbr', 'id=' . $id . '&num=' . $stage['stage_num'] . '&action=decision'),
));

$stagefiles = $db->query("SELECT * FROM $db_sbr_files WHERE file_sid=" . $id . " AND file_area='stage' AND file_code='".$stage['stage_num']."' ORDER BY file_id ASC")->fetchAll();
if(count($stagefiles) > 0)
{
	foreach($stagefiles as $file)
	{
		$t->assign(array(
			'FILE_ROW_ID' => $file['file_id'],
			'FILE_ROW_URL' => $file['file_url'],
			'FILE_ROW_TITLE' => $file['file_title'],
			'FILE_ROW_EXT' => $file['file_ext'],
			'FILE_ROW_SIZE' => $file['file_size'],
		));
		$t->parse('MAIN.SBR.STAGE.FILES.FILE_ROW');
	}
	$t->parse('MAIN.SBR.STAGE.FILES');
}

/* === Hook === */
foreach (cot_getextplugins('sbr.stage.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN.SBR.STAGE');
