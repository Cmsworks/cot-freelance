<?php
/**
 * 1.1.8.1
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('payments', 'module');

global $db_payments_transfers;

if (!$db->fieldExists($db_payments_transfers, "trn_done"))
{
	$db->query("ALTER TABLE `$db_payments_transfers` ADD COLUMN `trn_done` int(11) NOT NULL");
}