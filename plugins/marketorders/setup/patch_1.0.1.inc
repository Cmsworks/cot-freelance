<?php
/**
 * 1.0.1
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('marketorders', 'plug');

global $db_market_orders, $cfg;

if (!$db->fieldExists($db_market_orders, "order_email"))
{
	$db->query("ALTER TABLE `$db_market_orders` ADD COLUMN `order_email` varchar(255) collate utf8_unicode_ci NOT NULL");
}
