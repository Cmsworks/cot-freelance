<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
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
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payments', 'module');


$cot_billings = array();

/* === Hook === */
foreach (cot_getextplugins('payments.billing.register') as $pl)
{
	include $pl;
}
/* ===== */


// Проверяем платежки на оплату пополнение счета.
if ($balancepays = cot_payments_getallpays('balance', 'paid'))
{
	foreach ($balancepays as $pay)
	{
		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{

			if (!empty($pay['pay_code']))
			{
				$dpay = cot_payments_payinfo($pay['pay_code']);
				if (!empty($dpay))
				{
					$ubalance = cot_payments_getuserbalance($dpay['pay_userid']);
					if ($ubalance >= $dpay['pay_summ'] && cot_payments_updatestatus($dpay['pay_id'], 'paid'))
					{
						cot_payments_updateuserbalance($dpay['pay_userid'], -$dpay['pay_summ'], $dpay['pay_id']);
					}
				}
			}

			/* === Hook === */
			foreach (cot_getextplugins('payments.balance.billing.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}

if ($cfg['payments']['clearpaymentsdays'] > 0)
{
	$clearpaymentsdate = $sys['now'] - $cfg['payments']['clearpaymentsdays'] * 24 * 60 * 60;
	$db->delete($db_payments, "pay_status!='done' AND pay_cdate<" . $clearpaymentsdate);
}
?>