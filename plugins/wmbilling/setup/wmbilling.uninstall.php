<?php

/**
 * Uninstallation handler
 *
 * @package wmbilling
 * @version 1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD License
 */
defined('COT_CODE') or die('Wrong URL');

global $db_payments;

if ($db->fieldExists($db_payments, "pay_wmrnd"))
{
	$db->query("ALTER TABLE `$db_payments` DROP COLUMN `pay_wmrnd`");
}
?>