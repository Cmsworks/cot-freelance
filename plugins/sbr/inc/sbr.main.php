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

$id = cot_import('id', 'G', 'INT');
$num = cot_import('num', 'G', 'INT');
$stageid = cot_import('stageid', 'G', 'INT'); // Нигде не используется
$action = cot_import('action', 'G', 'ALP');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'sbr');
cot_block($usr['auth_read']);

/* === Hook === */
foreach (cot_getextplugins('sbr.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($id > 0)
{
	$query_string = (!$usr['isadmin']) ? " AND (sbr_employer=".$usr['id']." OR sbr_performer=".$usr['id'].")" : "";
	$sql = $db->query("SELECT * FROM $db_sbr WHERE sbr_id=" . $id . " " . $query_string . " LIMIT 1");
}

if (!$id || !$sql || $sql->rowCount() == 0)
{
	cot_block();
}
$sbr = $sql->fetch();

// Действия только для Заказчика
if($usr['id'] == $sbr['sbr_employer'])
{
	$role = 'employer';
	
	// Если сделка согласована, то можно оплатить.
	if($a == 'pay' && $sbr['sbr_status'] == 'confirm')
	{
		/* === Hook === */
		foreach (cot_getextplugins('sbr.pay.first') as $pl)
		{
			include $pl;
		}
		/* ===== */
		
		$totalcost = $sbr['sbr_cost'] + $sbr['sbr_tax'];
				
		$options['desc'] = cot_rc($L['sbr_paydesc'], array('sbr_title' => $sbr['sbr_title']));
		$options['code'] = $id;
		
		/* === Hook === */
		foreach (cot_getextplugins('sbr.pay.main') as $pl)
		{
			include $pl;
		}
		/* ===== */
		
		// Переход на оплату в Payments
		cot_payments_create_order('sbr', $totalcost, $options);
	}
	
	// Если сделка согласована или на согласовании, то еще можно ее отменить. В иных случаях только через арбитраж
	if($a == 'cancel' && ($sbr['sbr_status'] == 'new' || $sbr['sbr_status'] == 'refuse' || $sbr['sbr_status'] == 'confirm'))
	{
		
		/* === Hook === */
		foreach (cot_getextplugins('sbr.cancel.first') as $pl)
		{
			include $pl;
		}
		/* ===== */
		
		// Отправка уведомления Исполнителю
		
		// Изменение статуса сделки
		if($db->update($db_sbr, array('sbr_status' => 'cancel'), "sbr_id=" . $id))
		{
			cot_sbr_sendpost($id, $L['sbr_posts_performer_cancel'], $sbr['sbr_performer'], 0, 'warning', true);
			cot_sbr_sendpost($id, $L['sbr_posts_employer_cancel'], $sbr['sbr_employer'], 0, 'warning', true);
		
			/* === Hook === */
			foreach (cot_getextplugins('sbr.cancel.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
		
		cot_redirect(cot_url('sbr', 'id=' . $id, '', true));
	}
	
	// Принятие этапа (Завершение этапа и оплата Исполнителю суммы за этап)
	if(!empty($num) && $a == 'done' && $sbr['sbr_status'] == 'process') {
		cot_shield_protect();

		if ($stage = $db->query("SELECT * FROM $db_sbr_stages WHERE stage_sid=" . $id . " AND stage_status='process' AND stage_num=" . $num)->fetch())
		{
			$rtext = cot_import('rtext', 'P', 'TXT');
			
			/* === Hook === */
			foreach (cot_getextplugins('sbr.stage.done.first') as $pl)
			{
				include $pl;
			}
			/* ===== */
			
			$rstage['stage_done'] = $sys['now'];
			$rstage['stage_status'] = 'done';
			
			if($db->update($db_sbr_stages, $rstage, "stage_sid=" . $id . " AND stage_num=" . $num))
			{				
				$payperformerwithtax = $stage['stage_cost'] - $stage['stage_cost']*$cfg['plugin']['sbr']['tax_performer']/100;
				
				// Выплата Исполнителю
				$payinfo['pay_userid'] = $sbr['sbr_performer'];
				$payinfo['pay_area'] = 'balance';
				$payinfo['pay_code'] = 'sbr:'.$id.';stage:'.$stage['stage_num'];
				$payinfo['pay_summ'] = $payperformerwithtax;
				$payinfo['pay_cdate'] = $sys['now'];
				$payinfo['pay_pdate'] = $sys['now'];
				$payinfo['pay_adate'] = $sys['now'];
				$payinfo['pay_status'] = 'done';
				$payinfo['pay_desc'] = cot_rc($L['sbr_stage_done_payments_desc'], 
					array(
						'sbr_title' => $sbr['sbr_title'], 
						'stage_title' => $stage['stage_title'], 
						'stage_num' => $stage['stage_num']
					)
				);

				if($db->insert($db_payments, $payinfo))
				{
					$tax = $cfg['plugin']['sbr']['tax'] + $cfg['plugin']['sbr']['tax_performer'];

					if($cfg['plugin']['sbr']['adminid'] > 0 && $tax > 0)
					{
						$payinfo['pay_userid'] = $cfg['plugin']['sbr']['adminid'];
						$payinfo['pay_area'] = 'balance';
						$payinfo['pay_code'] = 'sbr:'.$id.';stage:'.$stage['stage_num'];
						$payinfo['pay_summ'] = $stage['stage_cost']*$tax/100;
						$payinfo['pay_cdate'] = $sys['now'];
						$payinfo['pay_pdate'] = $sys['now'];
						$payinfo['pay_adate'] = $sys['now'];
						$payinfo['pay_status'] = 'done';
						$payinfo['pay_desc'] = cot_rc($L['sbr_stage_tax_payments_desc'], 
							array(
								'sbr_title' => $sbr['sbr_title'], 
								'stage_title' => $stage['stage_title'], 
								'stage_num' => $stage['stage_num']
							)
						);

						$db->insert($db_payments, $payinfo);
					}

					if(!empty($rtext))
					{
						cot_sbr_sendpost($id, $rtext, $sbr['sbr_performer'], $usr['id']);
					}
					
					cot_sbr_sendpost(
						$id, 
						cot_rc($L['sbr_posts_performer_stage_done'], 
							array(
								'stage_num' => $stage['stage_num'], 
								'stage_title' => $stage['stage_title'],
								'stage_cost' => $stage['stage_cost'],
								'valuta' => $cfg['payments']['valuta'],
							)
						), 
						$sbr['sbr_performer'], 
						0, 
						'success',
						true
					);
					
					cot_sbr_sendpost(
						$id, 
						cot_rc($L['sbr_posts_employer_stage_done'], 
							array(
								'stage_num' => $stage['stage_num'], 
								'stage_title' => $stage['stage_title'],
								'stage_cost' => $stage['stage_cost'],
								'valuta' => $cfg['payments']['valuta'],
							)
						), 
						$sbr['sbr_employer'], 
						0, 
						'success',
						true
					);
			
					// Запуск следующего этапа на исполнение, если он существует
					$nextstagenum = $num + 1;		
					if($nstageid = $db->query("SELECT stage_id FROM $db_sbr_stages WHERE stage_sid=" . $id . " AND stage_num=" . $nextstagenum)->fetchColumn())
					{
						$nstage['stage_begin'] = $sys['now'];
						$nstage['stage_status'] = 'process';
						$db->update($db_sbr_stages, $nstage, "stage_id=" . $nstageid);
					}
					
					//  Если нет этапов на исполнении, то завершить сделку полностью
					$notstartedstages = (bool)$db->query("SELECT COUNT(*) FROM $db_sbr_stages WHERE stage_sid=" . $id . " AND stage_status='process'")->fetchColumn();
					if(!$notstartedstages)
					{
						$rsbr['sbr_done'] = $sys['now'];
						$rsbr['sbr_status'] = 'done';
						$db->update($db_sbr, $rsbr, "sbr_id=" . $id);
						
						cot_sbr_sendpost($id, $L['sbr_posts_performer_done'], $sbr['sbr_performer'], 0, 'success', true);
						cot_sbr_sendpost($id, $L['sbr_posts_employer_done'], $sbr['sbr_employer'], 0, 'success', true);
					}

					/* === Hook === */
					foreach (cot_getextplugins('sbr.stage.done.done') as $pl)
					{
						include $pl;
					}
					/* ===== */
				}
			}
		}

        $urlParams = ['id' => $id,];
        $stagesCount = cot::$db->query(
            'SELECT COUNT(*) FROM ' . cot::$db->sbr_stages . ' WHERE stage_sid = :id',
            ['id' => $id,]
        )->fetchColumn();
        if (cot::$cfg['plugin']['sbr']['stages_on'] && $stagesCount > 1) {
            $urlParams['num'] = $num;
        }

		cot_redirect(cot_url('sbr', $urlParams, '', true));
	}

// Действия только для Исполнителя
} elseif (cot::$usr['id'] == $sbr['sbr_performer']) {
	$role = 'performer';
	
	// Если сделка на согласовании, то можно подтвердить участие
	if($a == 'confirm' && $sbr['sbr_status'] == 'new')
	{
		/* === Hook === */
		foreach (cot_getextplugins('sbr.confirm.first') as $pl)
		{
			include $pl;
		}
		/* ===== */
		
		// Отправка уведомления Заказчику
		
		// Изменение статуса сделки
		if($db->update($db_sbr, array('sbr_status' => 'confirm'), "sbr_id=" . $id))
		{
		
			cot_sbr_sendpost($id, $L['sbr_posts_performer_confirm'], $sbr['sbr_performer'], 0, 'info', true);
			cot_sbr_sendpost($id, $L['sbr_posts_employer_confirm'], $sbr['sbr_employer'], 0, 'info', true);
			
			/* === Hook === */
			foreach (cot_getextplugins('sbr.confirm.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
		
		cot_redirect(cot_url('sbr', 'id=' . $id, '', true));
	}
	
	// Если сделка согласована или на согласовании, то еще можно отказаться. В иных случаях отказаться можно только через арбитраж.
	if($a == 'refuse' && ($sbr['sbr_status'] == 'new' || $sbr['sbr_status'] == 'confirm'))
	{
		/* === Hook === */
		foreach (cot_getextplugins('sbr.refuse.first') as $pl)
		{
			include $pl;
		}
		/* ===== */
		
		// Отправка уведомления Заказчику
		
		// Изменение статуса сделки
		if($db->update($db_sbr, array('sbr_status' => 'refuse'), "sbr_id=" . $id))
		{
			cot_sbr_sendpost($id, $L['sbr_posts_performer_refuse'], $sbr['sbr_performer'], 0, 'warning', true);
			cot_sbr_sendpost($id, $L['sbr_posts_employer_refuse'], $sbr['sbr_employer'], 0, 'warning', true);
			
			/* === Hook === */
			foreach (cot_getextplugins('sbr.refuse.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
		
		cot_redirect(cot_url('sbr', 'id=' . $id, '', true));
	}
}

// Обращение в арбитраж
if (!empty($num) && $a == 'claim' && $sbr['sbr_status'] == 'process') {
	cot_shield_protect();

    $urlParams = ['id' => $id,];
    $stagesCount = cot::$db->query(
        'SELECT COUNT(*) FROM ' . cot::$db->sbr_stages . ' WHERE stage_sid = :id',
        ['id' => $id,]
    )->fetchColumn();
    if (cot::$cfg['plugin']['sbr']['stages_on'] && $stagesCount > 1) {
        $urlParams['num'] = $num;
    }

	if($stage = $db->query("SELECT * FROM $db_sbr_stages WHERE stage_sid=" . $id . " AND stage_status='process' AND stage_num=" . $num)->fetch())
	{

		$rtext = cot_import('rtext', 'P', 'TXT');

		/* === Hook === */
		foreach (cot_getextplugins('sbr.stage.claim.import') as $pl)
		{
			include $pl;
		}
		/* ===== */
		
		cot_check(empty($rtext), 'sbr_claim_add_error_text', 'rtext');

		if(!cot_error_found())
		{
			$rclaim['claim_text'] = $rtext;
			$rclaim['claim_from'] = $usr['id'];
			$rclaim['claim_date'] = $sys['now'];
			$rclaim['claim_sid'] = $id;
			$rclaim['claim_stage'] = $num;
			$rclaim['claim_status'] = 'new';
			
			if($db->insert($db_sbr_claims, $rclaim))
			{
				$rstage['stage_claim'] = $sys['now'];
				$rstage['stage_status'] = 'claim';

				if($db->update($db_sbr_stages, $rstage, "stage_sid=" . $id . " AND stage_num=" . $num))
				{						
					cot_sbr_sendpost(
						$id, 
						cot_rc(
							$L['sbr_posts_stage_claim'], array(
								'from_name' => $usr['name'],
								'claim_text' => $rclaim['claim_text'],
							)
						), 
						$sbr['sbr_performer'], 
						0, 
						'error',
						true
					);
					cot_sbr_sendpost(
						$id, 
						cot_rc(
							$L['sbr_posts_stage_claim'], array(
								'from_name' => $usr['name'],
								'claim_text' => $rclaim['claim_text'],
							)
						), 
						$sbr['sbr_employer'], 
						0, 
						'error',
						true
					);
			
					$db->update($db_sbr, array('sbr_claim' => $sys['now'], 'sbr_status' => 'claim'), "sbr_id=" . $id);
				}
			}
			cot_redirect(cot_url('sbr', $urlParams, '', true));
		}
	}

    $urlParams['action'] = 'claim';
	cot_redirect(cot_url('sbr', $urlParams, '', true));
}

// Принятие решения арбитражной комиссией
if (!empty($num) && $a == 'decision' && $sbr['sbr_status'] == 'claim' && $usr['isadmin']) {
	cot_shield_protect();

    $urlParams = ['id' => $id,];
    $stagesCount = cot::$db->query(
        'SELECT COUNT(*) FROM ' . cot::$db->sbr_stages . ' WHERE stage_sid = :id',
        ['id' => $id,]
    )->fetchColumn();
    if (cot::$cfg['plugin']['sbr']['stages_on'] && $stagesCount > 1) {
        $urlParams['num'] = $num;
    }

	if($stage = $db->query("SELECT * FROM $db_sbr_stages WHERE stage_sid=" . $id . " AND stage_status='claim' AND stage_num=" . $num)->fetch())
	{

		$rtext = cot_import('rdecisiontext', 'P', 'TXT');
		$payperformer = cot_import('payperformer', 'P', 'NUM');
		$payemployer = cot_import('payemployer', 'P', 'NUM');

		/* === Hook === */
		foreach (cot_getextplugins('sbr.stage.decision.import') as $pl)
		{
			include $pl;
		}
		/* ===== */
		
		cot_check(empty($rtext), 'sbr_claim_decision_error_text', 'rdecisiontext');
		cot_check(($payperformer + $payemployer != $stage['stage_cost']), 'sbr_claim_decision_error_pay', 'payemployer');

		if(!cot_error_found())
		{
			$rclaim['claim_done'] = $sys['now'];
			$rclaim['claim_status'] = 'new';
			
			if($db->update($db_sbr_claims, $rclaim, "claim_sid=".$id." AND claim_stage=".$num))
			{
				$rstage['stage_done'] = $sys['now'];
				$rstage['stage_status'] = 'done';

				if($db->update($db_sbr_stages, $rstage, "stage_sid=" . $id . " AND stage_num=" . $num))
				{						
					$payperformerwithtax = $payperformer - $payperformer*$cfg['plugin']['sbr']['tax_performer']/100;
					
					// Выплата Исполнителю
					if($payperformer > 0)
					{
						$payinfo['pay_userid'] = $sbr['sbr_performer'];
						$payinfo['pay_area'] = 'balance';
						$payinfo['pay_code'] = 'sbr:'.$id.';stage:'.$num;
						$payinfo['pay_summ'] = $payperformerwithtax;
						$payinfo['pay_cdate'] = $sys['now'];
						$payinfo['pay_pdate'] = $sys['now'];
						$payinfo['pay_adate'] = $sys['now'];
						$payinfo['pay_status'] = 'done';
						$payinfo['pay_desc'] = cot_rc($L['sbr_claim_payments_performer_desc'], 
							array(
								'sbr_title' => $sbr['sbr_title'], 
								'stage_title' => $stage['stage_title'], 
								'stage_num' => $stage['stage_num']
							)
						);

						if($db->insert($db_payments, $payinfo)) 
						{
							$tax = $cfg['plugin']['sbr']['tax'] + $cfg['plugin']['sbr']['tax_performer'];

							if($cfg['plugin']['sbr']['adminid'] > 0 && $tax > 0)
							{
								$payinfo['pay_userid'] = $cfg['plugin']['sbr']['adminid'];
								$payinfo['pay_area'] = 'balance';
								$payinfo['pay_code'] = 'sbr:'.$id.';stage:'.$num;
								$payinfo['pay_summ'] = $payperformer*$tax/100;
								$payinfo['pay_cdate'] = $sys['now'];
								$payinfo['pay_pdate'] = $sys['now'];
								$payinfo['pay_adate'] = $sys['now'];
								$payinfo['pay_status'] = 'done';
								$payinfo['pay_desc'] = cot_rc($L['sbr_claim_payments_admin_desc'], 
									array(
										'sbr_title' => $sbr['sbr_title'], 
										'stage_title' => $stage['stage_title'], 
										'stage_num' => $stage['stage_num']
									)
								);

								$db->insert($db_payments, $payinfo);
							}
						}
					}

					// Выплата Заказчику
					if($payemployer > 0)
					{
						$payinfo['pay_userid'] = $sbr['sbr_employer'];
						$payinfo['pay_area'] = 'balance';
						$payinfo['pay_code'] = 'sbr:'.$id.';stage:'.$num;
						$payinfo['pay_summ'] = $payemployer;
						$payinfo['pay_cdate'] = $sys['now'];
						$payinfo['pay_pdate'] = $sys['now'];
						$payinfo['pay_adate'] = $sys['now'];
						$payinfo['pay_status'] = 'done';
						$payinfo['pay_desc'] = cot_rc($L['sbr_claim_payments_employer_desc'], 
							array(
								'sbr_title' => $sbr['sbr_title'], 
								'stage_title' => $stage['stage_title'], 
								'stage_num' => $stage['stage_num']
							)
						);

						$db->insert($db_payments, $payinfo);
					}
					
					cot_sbr_sendpost(
						$id, 
						cot_rc(
							$L['sbr_posts_performer_stage_claim_decision_payment'], array(
								'sbr_title' => $sbr['sbr_title'], 
								'stage_title' => $stage['stage_title'], 
								'stage_num' => $stage['stage_num'],
								'payperformer' => (!empty($payperformer)) ? $payperformer : 0,
								'payemployer' => (!empty($payemployer)) ? $payemployer : 0,
								'decision' => $rtext,
								'valuta' => $cfg['payments']['valuta'],
							)
						), 
						$sbr['sbr_performer'], 
						0, 
						'warning',
						true
					);
					cot_sbr_sendpost(
						$id, 
						cot_rc(
							$L['sbr_posts_employer_stage_claim_decision_payment'], array(
								'sbr_title' => $sbr['sbr_title'], 
								'stage_title' => $stage['stage_title'], 
								'stage_num' => $stage['stage_num'],
								'payperformer' => (!empty($payperformer)) ? $payperformer : 0,
								'payemployer' => (!empty($payemployer)) ? $payemployer : 0,
								'decision' => $rtext,
								'valuta' => $cfg['payments']['valuta'],
							)
						), 
						$sbr['sbr_employer'], 
						0, 
						'warning',
						true
					);
			
					// Запуск следующего этапа на исполнение, если он существует
					$nextstagenum = $num + 1;		
					if($nstageid = $db->query("SELECT stage_id FROM $db_sbr_stages WHERE stage_sid=" . $id . " AND stage_num=" . $nextstagenum)->fetchColumn())
					{
						$nstage['stage_begin'] = $sys['now'];
						$nstage['stage_status'] = 'process';
						$db->update($db_sbr_stages, $nstage, "stage_id=" . $nstageid);
					}
					
					//  Если нет этапов на исполнении, то завершить сделку полностью
					$notstartedstages = (bool)$db->query("SELECT COUNT(*) FROM $db_sbr_stages WHERE stage_sid=" . $id . " AND stage_status='process'")->fetchColumn();
					if(!$notstartedstages)
					{
						$rsbr['sbr_done'] = $sys['now'];
						$rsbr['sbr_status'] = 'done';
						$db->update($db_sbr, $rsbr, "sbr_id=" . $id);
						
						cot_sbr_sendpost($id, $L['sbr_posts_performer_done'], $sbr['sbr_performer'], 0, 'success', true);
						cot_sbr_sendpost($id, $L['sbr_posts_employer_done'], $sbr['sbr_employer'], 0, 'success', true);
					}
					else
					{
						$db->update($db_sbr, array('sbr_claim' => $sys['now'], 'sbr_status' => 'process'), "sbr_id=" . $id);
					}

					/* === Hook === */
					foreach (cot_getextplugins('sbr.stage.done.done') as $pl)
					{
						include $pl;
					}
					/* ===== */
				}
			}
			cot_redirect(cot_url('sbr', $urlParams, '', true));
		}
	}

    $urlParams['action'] = 'decision';
	cot_redirect(cot_url('sbr', $urlParams, '', true));
}

$to = null;
if ($a == 'addpost') {
	cot_shield_protect();
	
	$rposttext = cot_import('rposttext', 'P', 'HTM');
	$to = cot_import('to', 'P', 'ALP');
	
	/* === Hook === */
	foreach (cot_getextplugins('sbr.post.add.import') as $pl) {
		include $pl;
	}
	/* ===== */

	if (empty($_FILES)) {
		cot_check(empty($rposttext), $L['sbr_posts_error_textempty'], 'rposttext');
	}
	
	if (!cot_error_found()) {
        $post_type = '';
		if (cot::$usr['isadmin']) {
			if ($to != 'all') {
				$recipient = ($to == 'employer') ? $sbr['sbr_employer'] : $sbr['sbr_performer'];
			} else {
				$recipient = 0;
				$post_type = 'info';
			}
		} else {
			$recipient = ($role == 'employer') ? $sbr['sbr_performer'] : $sbr['sbr_employer'];
		}
		
		$postid = cot_sbr_sendpost($id, $rposttext, $recipient, $usr['id'], $post_type, true, $_FILES['rpostfiles']);
	}

    $urlParams = ['id' => $id,];
    $stagesCount = cot::$db->query(
        'SELECT COUNT(*) FROM ' . cot::$db->sbr_stages . ' WHERE stage_sid = :id',
        ['id' => $id,]
    )->fetchColumn();
    if (cot::$cfg['plugin']['sbr']['stages_on'] && $stagesCount > 1) {
        $urlParams['num'] = $num;
    }

	cot_redirect(cot_url('sbr', $urlParams, '#addpost', true));
}

$out['subtitle'] = $sbr['sbr_title'];
$out['head'] .= $R['code_noindex'];

$mskin = cot_tplfile(array('sbr', $role), 'plug');

/* === Hook === */
foreach (cot_getextplugins('sbr.main') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

$t->assign(cot_generate_projecttags($sbr['sbr_pid'], 'SBR_PROJECT_'));
$t->assign(cot_generate_usertags($sbr['sbr_employer'], 'SBR_EMPLOYER_'));
$t->assign(cot_generate_usertags($sbr['sbr_performer'], 'SBR_PERFORMER_'));
$t->assign(cot_generate_sbrtags($sbr, 'SBR_', $usr['isadmin'], $cfg['homebreadcrumb']));

$sqllist_rowset = $db->query("SELECT * FROM $db_sbr_stages WHERE stage_sid=" . $id . " ORDER BY stage_num ASC")->fetchAll();
$stagesCount = 0;
if (!empty($sqllist_rowset)) {
    foreach ($sqllist_rowset as $stage) {
        $stagesCount++;
        $t->assign(array(
            'STAGENAV_ROW_ID' => $stage['stage_id'],
            'STAGENAV_ROW_NUM' => $stage['stage_num'],
            'STAGENAV_ROW_TITLE' => $stage['stage_title'],
            'STAGENAV_ROW_TEXT' => $stage['stage_text'],
            'STAGENAV_ROW_STATUS' => $stage['stage_status'],
            'STAGENAV_ROW_URL' => cot_url('sbr', 'id=' . $id . '&num=' . $stage['stage_num']),
        ));
        $t->parse('MAIN.STAGENAV_ROW');
    }
}
if (empty($action)) {
	if (!empty($num)) {
		require_once cot_incfile('sbr', 'plug', 'stage');
	} else {
		require_once cot_incfile('sbr', 'plug', 'info');
        // Информацию о последнем (или единственном этапе) сделки выводим и на основной странице сделки
        if (!empty($stage['stage_num'])) {
            $num = $stage['stage_num'];
            require_once cot_incfile('sbr', 'plug', 'stage');
            $num = 0;
        }
	}

	if (!empty($role)) {
		$query_string = " AND (post_to=0 OR post_to=" . $usr['id'] . " OR post_from=" . $usr['id'] . ")";
	}
	/* === Hook === */
	foreach (cot_getextplugins('sbr.posts.query') as $pl)
	{
		include $pl;
	}
	/* ===== */
	$posts = $db->query("SELECT * FROM $db_sbr_posts 
		WHERE post_sid=" . $id . " ".$query_string ."
		ORDER BY post_date ASC")->fetchAll();

	/* === Hook === */
	$extp = cot_getextplugins('sbr.posts.loop');
	/* ===== */

	foreach ($posts as $post)
	{
		if($post['post_from'] > 0) 
		{
			$t->assign(cot_generate_usertags($post['post_from'], 'POST_ROW_FROM_'));
		}
		else
		{
			$t->assign('POST_ROW_FROM_NAME', '');
		}
		
		if($post['post_to'] > 0) 
		{
			$t->assign(cot_generate_usertags($post['post_to'], 'POST_ROW_TO_'));
		}
		else
		{
			$t->assign('POST_ROW_TO_NAME', '');
		}

		$t->assign(array(
			'POST_ROW_FROM_ID' => $post['post_from'],
			'POST_ROW_ID' => $post['post_id'],
			'POST_ROW_TEXT' => $post['post_text'],
			'POST_ROW_TYPE' => $post['post_type'],
			'POST_ROW_DATE' => date('d.m.Y H:i:s', $post['post_date']),
		));
		/* === Hook - Part2 : Include === */
		foreach ($extp as $pl)
		{
			include $pl;
		}
		/* ===== */	
		
		$postfiles = $db->query("SELECT * FROM $db_sbr_files WHERE file_sid=" . $id . " AND file_area='post' AND file_code='".$post['post_id']."' ORDER BY file_id ASC")->fetchAll();
		if(count($postfiles) > 0)
		{
			foreach($postfiles as $file)
			{
				$t->assign(array(
					'FILE_ROW_ID' => $file['file_id'],
					'FILE_ROW_URL' => $file['file_url'],
					'FILE_ROW_TITLE' => $file['file_title'],
					'FILE_ROW_EXT' => $file['file_ext'],
					'FILE_ROW_SIZE' => $file['file_size'],
				));
				$t->parse('MAIN.SBR.POSTS.POST_ROW.FILES.FILE_ROW');
			}
			$t->parse('MAIN.SBR.POSTS.POST_ROW.FILES');
		}
		$t->parse('MAIN.SBR.POSTS.POST_ROW');
	}

	$t->assign([
		'POST_FORM_ACTION' => cot_url('sbr', 'id=' . $id . '&num=' . $num . '&a=addpost'),
		'POST_FORM_TO' => cot_selectbox($to, 'to', $R['sbr_posts_to_values'], $R['sbr_posts_to_titles']),
        'STAGES_COUNT' => $stagesCount,
	]);
	
	cot_display_messages($t, 'MAIN.SBR.POSTS.POSTFORM');
	
	$t->parse('MAIN.SBR.POSTS.POSTFORM');

	$t->parse('MAIN.SBR.POSTS');

	/* === Hook === */
	foreach (cot_getextplugins('sbr.tags') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse('MAIN.SBR');
}

$urlParams = ['id' => $id, 'num' => $num,];
if ($action == 'done') {
	// Действие доступно только для заказчика
	cot_block($role == 'employer');

    $urlParams['a'] = 'done';
	$t->assign([
		'STAGEDONE_FORM_ACTION' => cot_url('sbr', $urlParams),
		'STAGEDONE_FORM_TEXT' => cot_textarea('rtext', (isset($rtext) ? $rtext : ''), 5, 80),
	]);
	
	cot_display_messages($t, 'MAIN.STAGEDONE');
	
	$t->parse('MAIN.STAGEDONE');
}

if ($action == 'claim') {
	$stage = $db->query("SELECT * FROM $db_sbr_stages WHERE stage_sid=" . $id . " AND stage_num=" . $num)->fetch();
	
	cot_block(!empty($role) && $sbr['sbr_status'] == 'process' && $stage['stage_status'] == 'process');

    $urlParams['a'] = 'claim';
	$t->assign([
		'CLAIM_FORM_ACTION' => cot_url('sbr', $urlParams),
		'CLAIM_FORM_TEXT' => cot_textarea('rtext', $rtext, 5, 80),
	]);

	cot_display_messages($t, 'MAIN.CLAIM');
	
	$t->parse('MAIN.CLAIM');
}

if ($action == 'decision') {
	cot_block($usr['isadmin'] && $sbr['sbr_status'] == 'claim');

    $urlParams['a'] = 'decision';
	$t->assign(array(
		'DECISION_FORM_ACTION' => cot_url('sbr', $urlParams),
		'DECISION_FORM_TEXT' => cot_textarea('rdecisiontext', $rtext, 5, 80),
		'DECISION_FORM_PAYPERFORMER' => cot_inputbox('text', 'payperformer', $payperformer),
		'DECISION_FORM_PAYEMPLOYER' => cot_inputbox('text', 'payemployer', $payemployer),
	));
	
	cot_display_messages($t, 'MAIN.DECISION');
	
	$t->parse('MAIN.DECISION');
}