<?php

/**
 * Payments module
 *
 * @package payments
 * @version 1.1.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('payments', 'any', 'RWA');
cot_block($usr['auth_write']);

require_once cot_incfile('forms');

$n = cot_import('n', 'G', 'ALP');
$pid = cot_import('pid', 'G', 'INT');
$rsumm = cot_import('rsumm', 'G', 'NUM');

if (empty($n))
{
	$n = 'history';
}

/* === Hook === */
foreach (cot_getextplugins('payments.balance.first') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate(cot_tplfile('payments.balance', 'module'));

/* === Hook === */
foreach (cot_getextplugins('payments.balance.main') as $pl)
{
	include $pl;
}
/* ===== */

$t->assign(array(
	'BALANCE_SUMM' => cot_payments_getuserbalance($usr['id']),
	'BALANCE_BILLING_URL' => cot_url('payments', 'm=balance&n=billing'),
	'BALANCE_HISTORY_URL' => cot_url('payments', 'm=balance&n=history'),
	'BALANCE_PAYOUT_URL' => cot_url('payments', 'm=balance&n=payouts'),
	'BALANCE_TRANSFER_URL' => cot_url('payments', 'm=balance&n=transfers'),
));

if ($n == 'billing')
{

	$pid = cot_import('pid', 'G', 'INT');

	/* === Hook === */
	foreach (cot_getextplugins('payments.balance.billing.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($a == 'buy')
	{

		$summ = cot_import('summ', 'P', 'NUM');

		/* === Hook === */
		foreach (cot_getextplugins('payments.balance.billing.import') as $pl)
		{
			include $pl;
		}
		/* ===== */

		cot_check(empty($summ), 'payments_balance_billing_error_emptysumm');
		cot_check(!empty($summ) && $summ < 0, 'payments_balance_billing_error_wrongsumm');

		/* === Hook === */
		foreach (cot_getextplugins('payments.balance.billing.validate') as $pl)
		{
			include $pl;
		}
		/* ===== */

		if (!cot_error_found())
		{
			$options['desc'] = $L['payments_balance_billing_desc'];
			$options['code'] = $pid;

			/* === Hook === */
			foreach (cot_getextplugins('payments.balance.billing.options') as $pl)
			{
				include $pl;
			}
			/* ===== */

			cot_payments_create_order('balance', $summ, $options);
		}
	}

	cot_display_messages($t, 'MAIN.BILLINGFORM');

	$rsumm = (!empty($rsumm)) ? $rsumm : $summ;

	$t->assign(array(
		'BALANCE_FORM_ACTION_URL' => cot_url('payments', 'm=balance&n=billing&a=buy&pid=' . $pid),
		'BALANCE_FORM_SUMM' => cot_inputbox('text', 'summ', $rsumm),
	));

	/* === Hook === */
	foreach (cot_getextplugins('payments.balance.billing.tags') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse('MAIN.BILLINGFORM');
}

if ($n == 'payouts')
{
	cot_block($cfg['payments']['payouts_enabled']);

	$payouttax_array = explode('|', $cfg['payments']['payouttax']);
	if(is_array($payouttax_array)){
		foreach ($payouttax_array as $j => $potaxs){
			if($j > 0){
				$utax_array = explode(',', $potaxs);
				if($utax_array[0] == $usr['id'] && isset($utax_array[1])){
					$utax = $utax_array[1];
				}
			}
		}
		if(isset($utax)){
			$cfg['payments']['payouttax'] = $utax;
		}else{
			$cfg['payments']['payouttax'] = $payouttax_array[0];
		}
	}
	
	/* === Hook === */
	foreach (cot_getextplugins('payments.balance.payouts.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($a == 'send')
	{

		$summ = cot_import('summ', 'P', 'NUM');
		$details = cot_import('details', 'P', 'TXT');
		
		$total = $summ + $summ*$cfg['payments']['payouttax']/100;
		
		/* === Hook === */
		foreach (cot_getextplugins('payments.balance.payouts.import') as $pl)
		{
			include $pl;
		}
		/* ===== */

		$ubalance = cot_payments_getuserbalance($usr['id']);
			
		cot_check(empty($details), 'payments_balance_payout_error_details');
		cot_check(empty($summ), 'payments_balance_payout_error_emptysumm');
		cot_check(!empty($summ) && $summ < 0, 'payments_balance_payout_error_wrongsumm');
		cot_check($total > $ubalance, 'payments_balance_payout_error_balance');	
		cot_check($cfg['payments']['payoutmin'] > 0 && $summ < $cfg['payments']['payoutmin'], sprintf($L['payments_balance_payout_error_min'], $cfg['payments']['payoutmin'], $cfg['payments']['valuta']));	
		cot_check($cfg['payments']['payoutmax'] > 0 && $summ > $cfg['payments']['payoutmax'], sprintf($L['payments_balance_payout_error_max'], $cfg['payments']['payoutmax'], $cfg['payments']['valuta']));	

		/* === Hook === */
		foreach (cot_getextplugins('payments.balance.payouts.validate') as $pl)
		{
			include $pl;
		}
		/* ===== */

		if(!cot_error_found())
		{
			$rpayout['out_userid'] = $usr['id'];
			$rpayout['out_summ'] = $summ;
			$rpayout['out_details'] = $details;
			$rpayout['out_status'] = 'process';

			/* === Hook === */
			foreach (cot_getextplugins('payments.balance.payouts.options') as $pl)
			{
				include $pl;
			}
			/* ===== */

			if($db->insert($db_payments_outs, $rpayout)){
				$oid = $db->lastInsertId();

				$payinfo['pay_userid'] = $usr['id'];
				$payinfo['pay_area'] = 'payout';
				$payinfo['pay_code'] = $oid;
				$payinfo['pay_summ'] = $total;
				$payinfo['pay_cdate'] = $sys['now'];
				$payinfo['pay_pdate'] = $sys['now'];
				$payinfo['pay_adate'] = $sys['now'];
				$payinfo['pay_status'] = 'done';
				$payinfo['pay_desc'] = $L['payments_balance_payout_desc'];

				$db->insert($db_payments, $payinfo);
				$pid = $db->lastInsertId();

				cot_payments_updateuserbalance($usr['id'], -$total, $pid);

				// Отправка уведомления админу о новой заявке на вывод
				$subject = $L['payments_balance_payout_admin_subject'];
				$body = sprintf($L['payments_balance_payout_admin_body'], $usr['name'], $summ.' '.$cfg['payments']['valuta'], $oid, cot_date('d.m.Y в H:i', $sys['now']), $details);
				cot_mail($cfg['adminemail'], $subject, $body);
				
				/* === Hook === */
				foreach (cot_getextplugins('payments.balance.payouts.done') as $pl)
				{
					include $pl;
				}
				/* ===== */
			}
			cot_redirect(cot_url('payments', 'm=balance&n=history', '', true));
		}
		cot_redirect(cot_url('payments', 'm=balance&n=payouts&a=add', '', true));
	}
	
	if($a != 'add')
	{
		$payouts = $db->query("SELECT * FROM $db_payments_outs AS o
			LEFT JOIN $db_payments AS p ON p.pay_code=o.out_id AND p.pay_area='payout'
			WHERE out_userid=" . $usr['id'] . "
			ORDER BY pay_cdate DESC")->fetchAll();
		if(count($payouts) > 0)
		{
			/* === Hook === */
			$extp = cot_getextplugins('payments.balance.payouts.loop');
			/* ===== */

			foreach ($payouts as $payout)
			{
				$t->assign(array(
					'PAYOUT_ROW_ID' => $payout['out_id'],
					'PAYOUT_ROW_SUMM' => $payout['out_summ'],
					'PAYOUT_ROW_CDATE' => $payout['pay_cdate'],
					'PAYOUT_ROW_DATE' => $payout['out_date'],
					'PAYOUT_ROW_STATUS' => $payout['out_status'],
					'PAYOUT_ROW_LOCALSTATUS' => $L['payments_balance_payout_status_'.$payout['out_status']],
				));

				/* === Hook - Part2 : Include === */
				foreach ($extp as $pl)
				{
					include $pl;
				}
				/* ===== */
				
				$t->parse('MAIN.PAYOUTS.PAYOUT_ROW');
			}
		}
		$t->parse('MAIN.PAYOUTS');
	}
	else
	{
		cot_display_messages($t, 'MAIN.PAYOUTFORM');

		$t->assign(array(
			'PAYOUT_FORM_ACTION_URL' => cot_url('payments', 'm=balance&n=payouts&a=send'),
			'PAYOUT_FORM_SUMM' => cot_inputbox('text', 'summ', $summ),
			'PAYOUT_FORM_TAX' => $summ*$cfg['payments']['payouttax']/100,
			'PAYOUT_FORM_TOTAL' => (!empty($total)) ? $total : 0,
			'PAYOUT_FORM_DETAILS' => cot_textarea('details', $details, 10, 80),
		));

		/* === Hook === */
		foreach (cot_getextplugins('payments.balance.payouts.form') as $pl)
		{
			include $pl;
		}
		/* ===== */

		$t->parse('MAIN.PAYOUTFORM');
	}
}

if ($n == 'transfers')
{
	cot_block($cfg['payments']['transfers_enabled']);
	
	/* === Hook === */
	foreach (cot_getextplugins('payments.balance.transfers.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($a == 'send')
	{

		$summ = cot_import('summ', 'P', 'NUM');
		$username = cot_import('username', 'P', 'TXT', 100, TRUE);
		$comment = cot_import('comment', 'P', 'TXT');
		
		$taxsumm = $summ*$cfg['payments']['transfertax']/100;
		
		/* === Hook === */
		foreach (cot_getextplugins('payments.balance.transfers.import') as $pl)
		{
			include $pl;
		}
		/* ===== */

		if($cfg['payments']['transfertaxfromrecipient'])
		{
			$sendersumm = $summ;
		}
		else 
		{
			$sendersumm = $summ + $taxsumm;
		}
		
		$ubalance = cot_payments_getuserbalance($usr['id']);
		
		$recipient = $db->query("SELECT * FROM $db_users WHERE user_name='".$db->prep($username)."' LIMIT 1")->fetch();
		
		cot_check(empty($recipient), 'payments_balance_transfer_error_username', 'username');
		cot_check(!empty($recipient) && $username == $usr['name'], 'payments_balance_transfer_error_yourself', 'username');
		cot_check(empty($summ), 'payments_balance_transfer_error_emptysumm', 'summ');
		cot_check(!empty($summ) && $summ < 0, 'payments_balance_transfer_error_wrongsumm', 'summ');
		cot_check($sendersumm > $ubalance, 'payments_balance_transfer_error_balance', 'summ');	
		cot_check($cfg['payments']['transfermin'] > 0 && $summ < $cfg['payments']['transfermin'], sprintf($L['payments_balance_transfer_error_min'], $cfg['payments']['transfermin'], $cfg['payments']['valuta']), 'summ');	
		cot_check($cfg['payments']['transfermax'] > 0 && $summ > $cfg['payments']['transfermax'], sprintf($L['payments_balance_transfer_error_max'], $cfg['payments']['transfermax'], $cfg['payments']['valuta']), 'summ');
		cot_check(empty($comment), 'payments_balance_transfer_error_comment', 'comment');

		/* === Hook === */
		foreach (cot_getextplugins('payments.balance.transfers.validate') as $pl)
		{
			include $pl;
		}
		/* ===== */

		if(!cot_error_found())
		{
			$rtransfer['trn_from'] = $usr['id'];
			$rtransfer['trn_to'] = $recipient['user_id'];
			$rtransfer['trn_summ'] = $summ;
			$rtransfer['trn_comment'] = $comment;
			$rtransfer['trn_status'] = 'process';
			$rtransfer['trn_date'] = $sys['now'];

			/* === Hook === */
			foreach (cot_getextplugins('payments.balance.transfers.options') as $pl)
			{
				include $pl;
			}
			/* ===== */

			if($db->insert($db_payments_transfers, $rtransfer)){
				$tid = $db->lastInsertId();

				$payinfo['pay_userid'] = $usr['id'];
				$payinfo['pay_area'] = 'transfer';
				$payinfo['pay_code'] = $tid;
				$payinfo['pay_summ'] = $sendersumm;
				$payinfo['pay_cdate'] = $sys['now'];
				$payinfo['pay_pdate'] = $sys['now'];
				$payinfo['pay_adate'] = $sys['now'];
				$payinfo['pay_status'] = 'done';
				$payinfo['pay_desc'] = sprintf($L['payments_balance_transfer_desc'], $usr['name'], $recipient['user_name'], $comment);

				$db->insert($db_payments, $payinfo);
				$pid = $db->lastInsertId();
				cot_payments_updateuserbalance($usr['id'], -$sendersumm, $pid);
				
				// Отправка уведомления админу о переводе между пользователями
				$subject = $L['payments_balance_transfer_admin_subject'];
				$body = sprintf($L['payments_balance_transfer_admin_body'], $usr['name'], $recipient['user_name'], $summ, $taxsumm, $sendersumm, $recipientsumm, $cfg['payments']['valuta'], cot_date('d.m.Y в H:i', $sys['now']), $comment);
				cot_mail($cfg['adminemail'], $subject, $body);
				
				/* === Hook === */
				foreach (cot_getextplugins('payments.balance.transfers.done') as $pl)
				{
					include $pl;
				}
				/* ===== */

			}
			
			cot_redirect(cot_url('payments', 'm=balance&n=history', '', true));
		}
		cot_redirect(cot_url('payments', 'm=balance&n=transfers&a=add', '', true));
	}
	
	if($a != 'add')
	{
		$transfers = $db->query("SELECT * FROM $db_payments_transfers AS t
			LEFT JOIN $db_payments AS p ON p.pay_code=t.trn_id AND p.pay_area='transfer'
			WHERE trn_from=" . $usr['id'] . "
			ORDER BY pay_cdate DESC")->fetchAll();
		if(count($transfers) > 0)
		{
			/* === Hook === */
			$extp = cot_getextplugins('payments.balance.transfers.loop');
			/* ===== */

			foreach ($transfers as $transfer)
			{
				$t->assign(array(
					'TRANSFER_ROW_ID' => $transfer['trn_id'],
					'TRANSFER_ROW_SUMM' => $transfer['trn_summ'],
					'TRANSFER_ROW_DATE' => $transfer['trn_date'],
					'TRANSFER_ROW_DONE' => $transfer['trn_done'],
					'TRANSFER_ROW_COMMENT' => $transfer['trn_comment'],
					'TRANSFER_ROW_STATUS' => $transfer['trn_status'],
					'TRANSFER_ROW_LOCALSTATUS' => $L['payments_balance_transfer_status_'.$transfer['trn_status']],
				));
				$t->assign(cot_generate_usertags($transfer['trn_to'], 'TRANSFER_ROW_FOR_'));

				/* === Hook - Part2 : Include === */
				foreach ($extp as $pl)
				{
					include $pl;
				}
				/* ===== */

				$t->parse('MAIN.TRANSFERS.TRANSFER_ROW');
			}
		}
		$t->parse('MAIN.TRANSFERS');
	}
	else
	{
		$t->assign(array(
			'TRANSFER_FORM_ACTION_URL' => cot_url('payments', 'm=balance&n=transfers&a=send'),
			'TRANSFER_FORM_SUMM' => cot_inputbox('text', 'summ', $summ),
			'TRANSFER_FORM_TAX' => (!empty($taxsumm)) ? $taxsumm : 0,
			'TRANSFER_FORM_TOTAL' => (!empty($sendersumm)) ? $sendersumm : 0,
			'TRANSFER_FORM_COMMENT' => cot_textarea('comment', $comment, 5, 40, '', ''),
			'TRANSFER_FORM_USERNAME' => cot_inputbox('text', 'username', $username),
		));
		
		/* === Hook === */
		foreach (cot_getextplugins('payments.balance.transfers.form') as $pl)
		{
			include $pl;
		}
		/* ===== */

		cot_display_messages($t, 'MAIN.TRANSFERFORM');

		$t->parse('MAIN.TRANSFERFORM');
	}
}

if ($n == 'history')
{
	list($pg, $d, $durl) = cot_import_pagenav('d', $cfg['maxrowsperpage']);

	$totallines = $db->query("SELECT COUNT(*) FROM $db_payments 
		WHERE pay_userid=" . $usr['id'] . " AND pay_status='done' AND pay_summ>0")->fetchColumn();
	$pays = $db->query("SELECT * FROM $db_payments 
		WHERE pay_userid=" . $usr['id'] . " AND pay_status='done' AND pay_summ>0
		ORDER BY pay_pdate DESC LIMIT $d, ".$cfg['maxrowsperpage'])->fetchAll();

	$pagenav = cot_pagenav('payments', 'm=balance', $d, $totallines, $cfg['maxrowsperpage']);

	$t->assign(array(
		'HISTORY_COUNT' => $totallines,
		'PAGENAV_PAGES' => $pagenav['main'],
		'PAGENAV_PREV' => $pagenav['prev'],
		'PAGENAV_NEXT' => $pagenav['next'],
		'PAGENAV_CURRENTPAGE' => $pagenav['current'],
	));

	/* === Hook === */
	$extp = cot_getextplugins('payments.balance.history.loop');
	/* ===== */

	foreach ($pays as $pay)
	{
		$t->assign(cot_generate_paytags($pay, 'HIST_ROW_'));

		/* === Hook - Part2 : Include === */
		foreach ($extp as $pl)
		{
			include $pl;
		}
		/* ===== */

		$t->parse('MAIN.HISTORY.HIST_ROW');
	}
	$t->parse('MAIN.HISTORY');
}

/* === Hook === */
foreach (cot_getextplugins('payments.balance.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$module_body = $t->text('MAIN');
?>