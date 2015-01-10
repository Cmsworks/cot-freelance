<?php
/**
 * 1.1.7
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('payments', 'module');

global $db_payments;

if (!$db->fieldExists($db_payments, "pay_redirect"))
{
	$db->query("ALTER TABLE `$db_payments` ADD COLUMN `pay_redirect` varchar(255) NOT NULL");
}