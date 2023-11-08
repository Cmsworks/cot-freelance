<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * Order=20 
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payorders', 'plug');
require_once cot_incfile('payments', 'module');

// Проверяем платежки на оплату. Если есть то изменяем статус
if ($ordpays = cot_payments_getallpays('payorders', 'paid'))
{
	foreach ($ordpays as $pay)
	{
		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$customer = $db->query("SELECT * FROM $db_users WHERE user_id=".$pay['pay_userid'])->fetch();
			
			// отправляем пользователю детали операции на email
			$usr['timezone'] = cot_timezone_offset($customer['user_timezone'], true);
			$subject = $L['payorders_email_orderinfo_subject'];
			$body = sprintf($L['payorders_email_orderinfo_body'], $customer['user_name'], $pay['pay_desc'], $pay['pay_summ'], $pay['pay_id'], cot_date('d.m.Y в H:i', $pay['pay_pdate']));
			cot_mail($customer['user_email'], $subject, $body);
			
			// отправляем админу детали операции на email
			$subject = $L['payorders_email_orderinfo_admin_subject'];
			$body = sprintf($L['payorders_email_orderinfo_admin_body'], $customer['user_name'], $pay['pay_desc'], $pay['pay_summ'], $pay['pay_id'], cot_date('d.m.Y в H:i', $pay['pay_pdate']));
			cot_mail($cfg['adminemail'], $subject, $body);
			
			/* === Hook === */
			foreach (cot_getextplugins('payorders.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}