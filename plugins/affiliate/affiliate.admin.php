<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=tools
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('affiliate', 'plug');

$t = new XTemplate(cot_tplfile('affiliate.admin', 'plug'));

$affiliates = $db->query("SELECT user_referal FROM $db_users WHERE user_referal!=0")->fetchAll();
if(is_array($affiliates)){
	foreach ($affiliates as $affiliate){
		$affs[] = $affiliate['user_referal'];
	}
}

if(is_array($affs)){
	$sql = $db->query("SELECT * FROM $db_users WHERE user_maingrp>3 AND user_id IN (".implode(',', $affs).")");
	while($urr = $sql->fetch()){
		$t->assign(cot_generate_usertags($urr, 'REF_ROW_'));
		$t->assign(array(
			'REF_ROW_TREE' => affiliate_referalstree($urr['user_id'], $urr['user_id'], 'admin', 0)
		));
		$t->parse('MAIN.REF_ROW');
	}
}

$summ = 0;

$pays = $db->query("SELECT * FROM $db_payments AS p
	LEFT JOIN $db_users AS u ON u.user_id=p.pay_userid
	WHERE pay_status='done' AND pay_code LIKE 'affiliate:%'
	ORDER BY pay_pdate DESC")->fetchAll();
foreach ($pays as $pay)
{
	$summ += $pay['pay_summ'];
			
	$paycode = explode(':', $pay['pay_code']);
	$referalid = $paycode[1];
	if(!empty($referalid)){
		$t->assign(cot_generate_usertags($referalid, 'PAY_ROW_REFERAL_'));
	}
	
	$t->assign(cot_generate_usertags($pay, 'PAY_ROW_PARTNER_'));
	$t->assign(cot_generate_paytags($pay, 'PAY_ROW_'));
	$t->parse('MAIN.PAYMENTS.PAY_ROW');
}

$t->assign('PAYMENT_SUMM', $summ);

$t->parse('MAIN.PAYMENTS');

$t->parse("MAIN");
$plugin_body .= $t->text("MAIN");