<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=admin
 * [END_COT_EXT]
 */
/**
 * Payments module
 *
 * @package payments
 * @version 1.1.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('payments', 'any');
cot_block($usr['isadmin']);

$p = cot_import('p', 'G', 'ALP');

$t = new XTemplate(cot_tplfile('payments.admin', 'module', true));

require_once cot_incfile('payments', 'module');

$adminpath[] = array(cot_url('admin', 'm=extensions'), $L['Extensions']);
$adminpath[] = array(cot_url('admin', 'm=extensions&a=details&mod='.$m), $cot_modules[$m]['title']);
$adminpath[] = array(cot_url('admin', 'm='.$m), $L['Administration']);
$adminhelp = $L['adm_help_payments'];

if($p == 'payouts')
{
	
	if($a == 'done' && isset($id)){

		$payout = $db->query("SELECT * FROM $db_payments_outs
			WHERE out_id=".$id)->fetch();

		$rpayout['out_date'] = $sys['now'];
		$rpayout['out_status'] = 'done';

		$db->update($db_payments_outs, $rpayout, "out_id=".$id);
		cot_redirect(cot_url('admin', 'm=payments&p=payouts'));
	}

	$payouts = $db->query("SELECT * FROM $db_payments_outs AS o
		LEFT JOIN $db_users AS u ON u.user_id=o.out_userid
		WHERE 1
		ORDER BY o.out_id DESC")->fetchAll();

	foreach($payouts as $payout){
		$t->assign(array(
			'PAYOUT_ROW_DATE' => $payout['out_date'],
			'PAYOUT_ROW_STATUS_ID' => $payout['out_status'],
			'PAYOUT_ROW_SUMM' => $payout['out_summ'],
			'PAYOUT_ROW_DETAILS' => $payout['out_details'],
			'PAYOUT_ROW_DONE_URL' => cot_url('admin', 'm=payments&p=payouts&a=done&id='.$payout['out_id']),
		));
		$t->assign(cot_generate_usertags($payout, 'PAYOUT_ROW_USER_'));
		$t->parse('MAIN.PAYOUTS.PAYOUT_ROW');
	}
	$t->parse('MAIN.PAYOUTS');
}
else
{

	list($pn, $d, $d_url) = cot_import_pagenav('d', $cfg['maxrowsperpage']);
	$id = cot_import('id', 'G', 'INT');

	list($pg, $d, $durl) = cot_import_pagenav('d', $cfg['maxrowsperpage']);

	$where['status'] = "pay_status='done'";
	$where['summ'] = 'pay_summ>0';

	if(isset($id))
	{
		$where['userid'] = 'pay_userid=' . $id;
		$urr = $db->query("SELECT * FROM $db_users WHERE user_id=" . (int)$id)->fetch();
		$t->assign(cot_generate_usertags($urr, 'USER_'));
	}	

	$where = array_filter($where);
	$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';

	$pays = $db->query("SELECT * FROM $db_payments AS p
		LEFT JOIN $db_users AS u ON u.user_id=p.pay_userid
		$where 
		ORDER BY pay_pdate DESC, pay_id DESC LIMIT $d, " . $cfg['maxrowsperpage'])->fetchAll();

	$totalitems = $db->query("SELECT COUNT(*) FROM $db_payments $where")->fetchColumn();

	$pagenav = cot_pagenav('admin', 'm=payments&id='.$id, $d, $totalitems, $cfg['maxrowsperpage']);

	$t->assign(array(
		'PAGENAV_PAGES' => $pagenav['main'],
		'PAGENAV_PREV' => $pagenav['prev'],
		'PAGENAV_NEXT' => $pagenav['next']
	));

	foreach($pays as $pay)
	{
		$t->assign(cot_generate_paytags($pay, 'PAY_ROW_'));
		
		if($pay['pay_userid'] > 0)
		{
			$t->assign(cot_generate_usertags($pay, 'PAY_ROW_USER_'));
		}
		else
		{
			$t->assign(array(
				'PAY_ROW_USER_ID' => 0,
				'PAY_ROW_USER_NICKNAME' => $L['Guest'],
			));
		}
		
		$t->parse('MAIN.PAYMENTS.PAY_ROW');	
	}

	if(!empty($id))
	{
		$where_string = 'AND pay_userid='.$id;
	}
	$inbalance = $db->query("SELECT SUM(pay_summ) as summ FROM $db_payments AS p
		WHERE pay_area='balance' AND pay_summ>0 $where_string AND pay_status='done'")->fetchColumn();

	$outbalance = $db->query("SELECT SUM(pay_summ) as summ FROM $db_payments AS p
		WHERE pay_area='balance' AND pay_summ<0 $where_string AND pay_status='done'")->fetchColumn();

	$credit = $db->query("SELECT SUM(pay_summ) as summ FROM $db_payments AS p
		WHERE pay_area!='balance' $where_string AND pay_status='done'")->fetchColumn();

	$t->assign(array(
		'INBALANCE' => number_format($inbalance, 2, '.', ' '),
		'OUTBALANCE' => number_format(abs($outbalance), 2, '.', ' '),
		'BALANCE' => number_format($inbalance - abs($outbalance), 2, '.', ' '),
		'CREDIT' => number_format($credit, 2, '.', ' '),
	));

	$t->parse('MAIN.PAYMENTS');
}

$t->parse('MAIN');
$adminmain = $t->text('MAIN');
