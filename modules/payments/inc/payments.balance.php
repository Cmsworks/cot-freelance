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

$t = new XTemplate(cot_tplfile('payments.balance', 'module'));

$t->assign(array(
	'BALANCE_SUMM' => cot_payments_getuserbalance($usr['id']),
	'BALANCE_BILLING_URL' => cot_url('payments', 'm=balance&n=billing'),
	'BALANCE_HISTORY_URL' => cot_url('payments', 'm=balance&n=history'),
	'BALANCE_PAYOUT_URL' => cot_url('payments', 'm=balance&n=payouts'),
	'BALANCE_TRANSFER_URL' => cot_url('payments', 'm=balance&n=transfer'),
));

if ($n == 'billing')
{

	$pid = cot_import('pid', 'G', 'INT');

	if ($a == 'buy')
	{

		$summ = cot_import('summ', 'P', 'NUM');
		cot_check(empty($summ), 'payments_balance_billing_error_summ');

		if (!cot_error_found())
		{
			$options['desc'] = $L['payments_balance_billing_desc'];
			$options['code'] = $pid;

			cot_payments_create_order('balance', $summ, $options);
		}
	}

	cot_display_messages($t, 'MAIN.BILLINGFORM');

	$t->assign(array(
		'BALANCE_FORM_ACTION_URL' => cot_url('payments', 'm=balance&n=billing&a=buy&pid=' . $pid),
		'BALANCE_FORM_SUMM' => (!empty($rsumm)) ? $rsumm : $summ,
	));
	$t->parse('MAIN.BILLINGFORM');
}

if ($n == 'payouts')
{
	cot_block($cfg['payments']['payouts_enabled']);
	
	if ($a == 'send')
	{

		$summ = cot_import('summ', 'P', 'NUM');
		$details = cot_import('details', 'P', 'TXT');
		
		$total = $summ + $summ*$cfg['payments']['payouttax']/100;
		
		$ubalance = cot_payments_getuserbalance($usr['id']);
			
		cot_check(empty($details), 'payments_balance_payout_error_details');
		cot_check(empty($summ), 'payments_balance_payout_error_summ');
		cot_check($total > $ubalance, 'payments_balance_payout_error_balance');	
		cot_check($cfg['payments']['payoutmin'] > 0 && $summ < $cfg['payments']['payoutmin'], sprintf($L['payments_balance_payout_error_min'], $cfg['payments']['payoutmin'], $cfg['payments']['valuta']));	
		cot_check($cfg['payments']['payoutmax'] > 0 && $summ > $cfg['payments']['payoutmax'], sprintf($L['payments_balance_payout_error_max'], $cfg['payments']['payoutmax'], $cfg['payments']['valuta']));	

		if(!cot_error_found())
		{
			$rpayout['out_userid'] = $usr['id'];
			$rpayout['out_summ'] = $summ;
			$rpayout['out_details'] = $details;
			$rpayout['out_status'] = 'process';

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
			foreach ($payouts as $payout)
			{
				$t->assign(array(
					'PAYOUT_ROW_ID' => $payout['out_id'],
					'PAYOUT_ROW_SUMM' => $payout['out_summ'],
					'PAYOUT_ROW_CDATE' => $payout['pay_cdate'],
					'PAYOUT_ROW_DATE' => $payout['out_date'],
				));
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
			'PAYOUT_FORM_DETAILS' => $details,
		));
		$t->parse('MAIN.PAYOUTFORM');
	}
}

if ($n == 'transfer')
{
	cot_block($cfg['payments']['transfers_enabled']);
	
	if ($a == 'add')
	{

		$summ = cot_import('summ', 'P', 'NUM');
		$username = cot_import('username', 'P', 'TXT', 100, TRUE);
		$comment = cot_import('comment', 'P', 'TXT');
		
		$taxsumm = $summ*$cfg['payments']['transfertax']/100;
		
		if($cfg['payments']['transfertaxfromrecipient'])
		{
			$sendersumm = $summ;
			$recipientsumm = $summ - $taxsumm;
		}
		else 
		{
			$sendersumm = $summ + $taxsumm;
			$recipientsumm = $summ;
		}
		
		$ubalance = cot_payments_getuserbalance($usr['id']);
		
		$recipient = $db->query("SELECT * FROM $db_users WHERE user_name = ? LIMIT 1", array($username))->fetch();
		
		cot_check(empty($recipient), 'payments_balance_transfer_error_username');
		cot_check(empty($comment), 'payments_balance_transfer_error_comment');
		cot_check(empty($summ), 'payments_balance_transfer_error_summ');
		cot_check($sendersumm > $ubalance, 'payments_balance_transfer_error_balance');	
		cot_check($cfg['payments']['transfermin'] > 0 && $summ < $cfg['payments']['transfermin'], sprintf($L['payments_balance_transfer_error_min'], $cfg['payments']['transfermin'], $cfg['payments']['valuta']));	
		cot_check($cfg['payments']['transfermax'] > 0 && $summ > $cfg['payments']['transfermax'], sprintf($L['payments_balance_transfer_error_max'], $cfg['payments']['transfermax'], $cfg['payments']['valuta']));

		if(!cot_error_found())
		{
			$payinfo['pay_userid'] = $usr['id'];
			$payinfo['pay_area'] = 'transfer';
			$payinfo['pay_code'] = $recipient['user_id'];
			$payinfo['pay_summ'] = $sendersumm;
			$payinfo['pay_cdate'] = $sys['now'];
			$payinfo['pay_pdate'] = $sys['now'];
			$payinfo['pay_adate'] = $sys['now'];
			$payinfo['pay_status'] = 'done';
			$payinfo['pay_desc'] = sprintf($L['payments_balance_transfer_desc'], $usr['name'], $recipient['user_name'], $comment);

			$db->insert($db_payments, $payinfo);
			$pid = $db->lastInsertId();
			cot_payments_updateuserbalance($usr['id'], -$sendersumm, $pid);
			
			$payinfo['pay_userid'] = $recipient['user_id'];
			$payinfo['pay_area'] = 'balance';
			$payinfo['pay_code'] = $pid;
			$payinfo['pay_summ'] = $recipientsumm;
			$payinfo['pay_cdate'] = $sys['now'];
			$payinfo['pay_pdate'] = $sys['now'];
			$payinfo['pay_adate'] = $sys['now'];
			$payinfo['pay_status'] = 'done';
			$payinfo['pay_desc'] = sprintf($L['payments_balance_transfer_desc'], $usr['name'], $recipient['user_name'], $comment);

			$db->insert($db_payments, $payinfo);
			$pid = $db->lastInsertId();
			
			// Отправка уведомления админу о переводе между пользователями
			$subject = $L['payments_balance_transfer_admin_subject'];
			$body = sprintf($L['payments_balance_transfer_admin_body'], $usr['name'], $recipient['user_name'], $summ, $taxsumm, $sendersumm, $recipientsumm, $cfg['payments']['valuta'], cot_date('d.m.Y в H:i', $sys['now']), $comment);
			cot_mail($cfg['adminemail'], $subject, $body);
			
			// Отправка уведомления админу о переводе между пользователями
			$subject = $L['payments_balance_transfer_recipient_subject'];
			$body = sprintf($L['payments_balance_transfer_recipient_body'], $usr['name'], $recipient['user_name'], $summ, $taxsumm, $sendersumm, $recipientsumm, $cfg['payments']['valuta'], cot_date('d.m.Y в H:i', $sys['now']), $comment);
			cot_mail($recipient['user_email'], $subject, $body);
			
			cot_redirect(cot_url('payments', 'm=balance&n=history', '', true));
		}
		cot_redirect(cot_url('payments', 'm=balance&n=transfer', '', true));
	}
	
	cot_display_messages($t, 'MAIN.TRANSFERFORM');

	$t->assign(array(
		'TRANSFER_FORM_ACTION_URL' => cot_url('payments', 'm=balance&n=transfer&a=add'),
		'TRANSFER_FORM_SUMM' => cot_inputbox('text', 'summ', $summ),
		'TRANSFER_FORM_TAX' => $taxsumm,
		'TRANSFER_FORM_TOTAL' => (!empty($sendersumm)) ? $sendersumm : 0,
		'TRANSFER_FORM_COMMENT' => $comment,
		'TRANSFER_FORM_USERNAME' => $username,
	));
	$t->parse('MAIN.TRANSFERFORM');
}

if ($n == 'history')
{
	$pays = $db->query("SELECT * FROM $db_payments 
		WHERE pay_userid=" . $usr['id'] . " AND pay_status='done' AND pay_summ>0
		ORDER BY pay_pdate DESC")->fetchAll();
	foreach ($pays as $pay)
	{
		$t->assign(cot_generate_paytags($pay, 'HIST_ROW_'));
		$t->parse('MAIN.HISTORY.HIST_ROW');
	}
	$t->parse('MAIN.HISTORY');
}

$t->parse('MAIN');
$module_body = $t->text('MAIN');
?>