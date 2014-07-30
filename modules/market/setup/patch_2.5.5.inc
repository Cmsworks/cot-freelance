<?php
/**
 * 2.5.5
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('market', 'module');

global $db_market, $cfg;

if (!$db->fieldExists($db_market, "item_update"))
{
	$db->query("ALTER TABLE `$db_market` ADD COLUMN `item_update` INT( 11 ) NOT NULL");
}