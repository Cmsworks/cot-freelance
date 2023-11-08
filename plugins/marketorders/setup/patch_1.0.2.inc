<?php
/**
 * 1.0.2
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('market', 'module');
require_once cot_incfile('marketorders', 'plug');

global $db_market_orders, $db_market, $cfg;

if (!$db->fieldExists($db_market_orders, "order_seller"))
{
	$db->query("ALTER TABLE `$db_market_orders` ADD COLUMN `order_seller` int(11) NOT NULL");
}

$marketorders = $db->query("SELECT * FROM $db_market_orders AS o
	LEFT JOIN $db_market AS m ON m.item_id=o.order_pid
	WHERE 1")->fetchAll();
foreach ($marketorders as $marketorder)
{
	if($marketorder['item_userid'] > 0)
	{
		$db->update($db_market_orders, array('order_seller' => $marketorder['item_userid']), 'order_id='.$marketorder['order_id']);
	}
}
