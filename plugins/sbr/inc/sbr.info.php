<?php
/**
 * Info sbr.
 *
 * @package sbr
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$sqllist_rowset = $db->query("SELECT * FROM $db_sbr_stages WHERE stage_sid=" . $sbr['sbr_id'] . " ORDER BY stage_num ASC")->fetchAll();
foreach ($sqllist_rowset as $stage)
{
	$t->assign(array(
		'STAGE_ROW_NUM' => $stage['stage_num'],
		'STAGE_ROW_ID' => $stage['stage_id'],
		'STAGE_ROW_TITLE' => $stage['stage_title'],
		'STAGE_ROW_TEXT' => $stage['stage_text'],
		'STAGE_ROW_COST' => $stage['stage_cost'],
		'STAGE_ROW_DAYS' => $stage['stage_days'],
		'STAGE_ROW_STATUS' => $stage['stage_status'],
		'STAGE_ROW_BEGIN' => $stage['stage_begin'],
		'STAGE_ROW_DONE' => $stage['stage_done'],
		'STAGE_ROW_EXPIRE' => $stage['stage_expire'],
		'STAGE_ROW_EXPIREDATE' => $stage['stage_begin'] + $stage['stage_days']*24*60*60,
		'STAGE_ROW_EXPIREDAYS' => cot_build_timegap($sys['now'], $stage['stage_begin'] + $stage['stage_days']*24*60*60),
		'STAGE_ROW_DONE_URL' => cot_url('sbr', 'id=' . $id . '&stageid=' . $stage['stage_id'] . '&a=done'),
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
			$t->parse('MAIN.SBR.INFO.STAGE_ROW.FILES.FILE_ROW');
		}
		$t->parse('MAIN.SBR.INFO.STAGE_ROW.FILES');
	}

	if($stage['stage_status'] == 'arbitration')
	{
		require_once cot_incfile('arbitration', 'plug');

		$arb = $db->query("SELECT * FROM $db_arbitration 
			WHERE arb_area='sbr' AND arb_code=".$stage['stage_id']." 
				AND (arb_defendantid=".$sbr['sbr_employer']." AND arb_claimantid=".$sbr['sbr_performer']." OR arb_defendantid=".$sbr['sbr_performer']." AND arb_claimantid=".$sbr['sbr_employer'].")")->fetch();

		$t->assign(array(
			"ARB_ID" => $arb['arb_id'],
			"ARB_DATE" => $arb['arb_date'],
			"ARB_TITLE" => $arb['arb_title'],
			"ARB_TEXT" => $arb['arb_claimtext'],
		));
	}

	/* === Hook === */
	foreach (cot_getextplugins('sbr.stages.tags') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse('MAIN.SBR.INFO.STAGE_ROW');
}

if(!empty($role) && ($sbr['sbr_status'] != 'cancel' || $sbr['sbr_status'] != 'arbitration'))
{
	$t->parse('MAIN.SBR.INFO.' . strtoupper($role));
}

$t->parse('MAIN.SBR.INFO');