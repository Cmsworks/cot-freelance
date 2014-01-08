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
	'BALANCE_PAYOUT_URL' => cot_url('payments', 'm=balance&n=payout'),
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

if ($n == 'payout')
{
	if ($a == 'add')
	{

		$summ = cot_import('summ', 'P', 'NUM');
		$details = cot_import('details', 'P', 'TXT');
		
		$ubalance = cot_payments_getuserbalance($usr['id']);
			
		cot_check(empty($details), 'payments_balance_payout_error_details');
		cot_check(empty($summ), 'payments_balance_payout_error_summ');
		cot_check($summ > $ubalance, 'payments_balance_payout_error_balance');	

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
				$payinfo['pay_summ'] = $summ;
				$payinfo['pay_cdate'] = $sys['now'];
				$payinfo['pay_pdate'] = $sys['now'];
				$payinfo['pay_adate'] = $sys['now'];
				$payinfo['pay_status'] = 'done';
				$payinfo['pay_desc'] = $L['payments_balance_payout_desc'];

				$db->insert($db_payments, $payinfo);
				$pid = $db->lastInsertId();

				cot_payments_updateuserbalance($usr['id'], -$summ, $pid);
			}
			cot_redirect(cot_url('payments', 'm=balance&n=history', '', true));
		}
		cot_redirect(cot_url('payments', 'm=balance&n=payout', '', true));
	}
	
	$payouts = $db->query("SELECT * FROM $db_payments_outs AS o
		LEFT JOIN $db_payments AS p ON p.pay_code=o.out_id AND p.pay_area='payout'
		WHERE out_userid=" . $usr['id'] . "
		ORDER BY pay_cdate ASC")->fetchAll();
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
			$t->parse('MAIN.PAYOUTFORM.PAYOUTS.PAYOUT_ROW');
		}
		$t->parse('MAIN.PAYOUTFORM.PAYOUTS');
	}
	
	cot_display_messages($t, 'MAIN.PAYOUTFORM');

	$t->assign(array(
		'PAYOUT_FORM_ACTION_URL' => cot_url('payments', 'm=balance&n=payout&a=add'),
		'PAYOUT_FORM_SUMM' => (!empty($rsumm)) ? $rsumm : $summ,
		'PAYOUT_FORM_DETAILS' => $details,
	));
	$t->parse('MAIN.PAYOUTFORM');
}

if ($n == 'transfer')
{
	if ($a == 'add')
	{

		$summ = cot_import('summ', 'P', 'NUM');
		$username = cot_import('username', 'P', 'TXT', 100, TRUE);
		$comment = cot_import('comment', 'P', 'TXT');
		
		$ubalance = cot_payments_getuserbalance($usr['id']);
		
		$user = $db->query("SELECT * FROM $db_users WHERE user_name = ? LIMIT 1", array($username))->fetch();
		
		cot_check(empty($user), 'payments_balance_transfer_error_username');
		cot_check(empty($comment), 'payments_balance_transfer_error_comment');
		cot_check(empty($summ), 'payments_balance_transfer_error_summ');
		cot_check($summ > $ubalance, 'payments_balance_transfer_error_balance');	

		if(!cot_error_found())
		{
			$payinfo['pay_userid'] = $usr['id'];
			$payinfo['pay_area'] = 'transfer';
			$payinfo['pay_code'] = $user['user_id'];
			$payinfo['pay_summ'] = $summ;
			$payinfo['pay_cdate'] = $sys['now'];
			$payinfo['pay_pdate'] = $sys['now'];
			$payinfo['pay_adate'] = $sys['now'];
			$payinfo['pay_status'] = 'done';
			$payinfo['pay_desc'] = sprintf($L['payments_balance_transfer_desc'], $usr['name'], $user['user_name'], $comment);

			$db->insert($db_payments, $payinfo);
			$pid = $db->lastInsertId();
			cot_payments_updateuserbalance($usr['id'], -$summ, $pid);
			
			$payinfo['pay_userid'] = $user['user_id'];
			$payinfo['pay_area'] = 'balance';
			$payinfo['pay_code'] = $pid;
			$payinfo['pay_summ'] = $summ;
			$payinfo['pay_cdate'] = $sys['now'];
			$payinfo['pay_pdate'] = $sys['now'];
			$payinfo['pay_adate'] = $sys['now'];
			$payinfo['pay_status'] = 'done';
			$payinfo['pay_desc'] = sprintf($L['payments_balance_transfer_desc'], $usr['name'], $user['user_name'], $comment);

			$db->insert($db_payments, $payinfo);
			$pid = $db->lastInsertId();
			
			cot_redirect(cot_url('payments', 'm=balance&n=history', '', true));
		}
		cot_redirect(cot_url('payments', 'm=balance&n=transfer', '', true));
	}
	
	cot_display_messages($t, 'MAIN.TRANSFERFORM');

	$t->assign(array(
		'TRANSFER_FORM_ACTION_URL' => cot_url('payments', 'm=balance&n=transfer&a=add'),
		'TRANSFER_FORM_SUMM' => (!empty($rsumm)) ? $rsumm : $summ,
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