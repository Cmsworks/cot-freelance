<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=payments.balance.billing.done
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('affiliate', 'plug');

$affs = affiliate_getaffiliates($pay['pay_userid']);
if(count($affs) > 0){
	$levelpays = affiliate_cfg_levelpays();
	for($level = 1; $level <= 10; $level++){
		if($affs[$level] > 0){
			$affid = $affs[$level];
			$levelpercent = ($levelpays[$affid][$level] > 0) ? $levelpays[$affid][$level] : $levelpays[0][$level];
			if($levelpercent > 0 && $pay['pay_summ'] > 0){
				if(cot_payments_updateuserbalance($affid, $pay['pay_summ']*$levelpercent/100, 'affiliate:'.$pay['pay_userid'])){
					if($affiliate = $db->query("SELECT * FROM $db_users WHERE user_id=".$affid)->fetch()){
						cot_mail($affiliate['user_email'], $L['affiliate_mail_newpayment_subject'], sprintf($L['affiliate_mail_newpayment_body'], $pay['pay_summ']*$levelpercent/100));
					}
				}
			}
		}
	}
}