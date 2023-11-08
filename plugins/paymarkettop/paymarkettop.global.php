<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('paymarkettop', 'plug');
require_once cot_incfile('market', 'module');
require_once cot_incfile('payments', 'module');

if ($pays = cot_payments_getallpays('market.top', 'paid'))
{
	foreach ($pays as $pay)
	{		
		$adv = $db->query("SELECT item_top FROM $db_market WHERE item_id=" . $pay['pay_code'])->fetch();
		$initialtime = ($adv['item_top'] > $sys['now']) ? $adv['item_top'] : $sys['now'];
		$rtopexpire = $initialtime + $pay['pay_time'];

		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$db->update($db_market,  array('item_top' => (int)$rtopexpire), "item_id=".(int)$pay['pay_code']);

			/* === Hook === */
			foreach (cot_getextplugins('paymrttop.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}