<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.auth.check.done
 * Order=11
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

$referal = $db->query("SELECT * FROM $db_users WHERE user_id=".$ruserid)->fetch();
if($referal['user_logcount'] <= 1 && $referal['user_referal'] > 0)
{
	$partner = $db->query("SELECT * FROM $db_users WHERE user_id=".$referal['user_referal'])->fetch();

	// Сообщаем партнеру о новом реферале
	cot_mail($partner['user_email'], $L['affiliate_mail_newreferal_subject'], sprintf($L['affiliate_mail_newreferal_body'], $partner['user_name'], $referal['user_name']));

	// Начисляем баллы в рейтинг за нового реферала
	if(cot_plugin_active('userpoints') && $cfg['plugin']['affiliate']['refpoints'] > 0)
	{
		cot_setuserpoints($cfg['plugin']['affiliate']['refpoints'], 'affiliate', $referal['user_referal'], $ruserid);
	}	

	// Начисляем на счет партнера вознаграждение за нового реферала
	if($cfg['plugin']['affiliate']['refpay'] > 0)
	{
		$payinfo['pay_userid'] = $partner['user_id'];
		$payinfo['pay_area'] = 'balance';
		$payinfo['pay_code'] = 'affiliate:'.$ruserid;
		$payinfo['pay_summ'] = $cfg['plugin']['affiliate']['refpay'];
		$payinfo['pay_cdate'] = $sys['now'];
		$payinfo['pay_pdate'] = $sys['now'];
		$payinfo['pay_adate'] = $sys['now'];
		$payinfo['pay_status'] = 'done';
		$payinfo['pay_desc'] = $L['affiliate_refpay_desc'];

		if($db->insert($db_payments, $payinfo))
		{
			cot_mail($partner['user_email'], $L['affiliate_refpay_mail_subject'], sprintf($L['affiliate_refpay_mail_body'], $partner['user_name']));
			cot_log("Payment for referal");
		}
	}
}	