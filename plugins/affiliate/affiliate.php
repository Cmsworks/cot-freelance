<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=standalone
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

cot_block($usr['id']);

$out['subtitle'] = $L['affiliate'];
$out['head'] .= $R['code_noindex'];

$t = new XTemplate(cot_tplfile('affiliate', 'plug'));

$t->assign('REFERALS_TREE', affiliate_referalstree($usr['id'], $usr['id']));

$affs = affiliate_getaffiliates($usr['id']);

$summ = 0;

$pays = $db->query("SELECT * FROM $db_payments 
	WHERE pay_userid=" . $usr['id'] . " AND pay_status='done' AND pay_code LIKE 'affiliate%'
	ORDER BY pay_pdate DESC")->fetchAll();
foreach ($pays as $pay)
{
	$summ += $pay['pay_summ'];
			
	$paycode = explode(':', $pay['pay_code']);
	$referalid = $paycode[1];
	if(!empty($referalid)){
		$t->assign(cot_generate_usertags($referalid, 'PAY_ROW_REFERAL_'));
	}
	
	$t->assign(cot_generate_paytags($pay, 'PAY_ROW_'));
	$t->parse('MAIN.PAYMENTS.PAY_ROW');
}

$t->assign('PAYMENT_SUMM', $summ);

$t->parse('MAIN.PAYMENTS');
