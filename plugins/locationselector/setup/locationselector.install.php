<?php
/**
 * Uninstallation handler
 *
 * @package locationselector
 * @version 2.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

global $db_users, $db_projects, $db_market, $db_folio;

// Add field if missing
if (!$db->fieldExists($db_users, "user_region"))
{
	$db->query("ALTER TABLE `$db_users` ADD COLUMN `user_region` INT( 11 ) NOT NULL DEFAULT '0'");
}

if (!$db->fieldExists($db_users, "user_city"))
{
	$db->query("ALTER TABLE `$db_users` ADD COLUMN `user_city` INT( 11 ) NOT NULL DEFAULT '0'");
}
