<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('paymarketbold', 'plug');
require_once cot_incfile('market', 'module');
require_once cot_incfile('payments', 'module');

if ($pays = cot_payments_getallpays('market.bold', 'paid'))
{
	foreach ($pays as $pay)
	{		
		$adv = $db->query("SELECT item_bold FROM $db_market WHERE item_id=" . $pay['pay_code'])->fetch();
		$initialtime = ($adv['item_bold'] > $sys['now']) ? $adv['item_bold'] : $sys['now'];
		$rboldexpire = $initialtime + $pay['pay_time'];

		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$db->update($db_market,  array('item_bold' => (int)$rboldexpire), "item_id=".(int)$pay['pay_code']);

			/* === Hook === */
			foreach (cot_getextplugins('paymarketbold.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}