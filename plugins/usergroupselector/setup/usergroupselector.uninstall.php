<?php
/**
 * Uninstallation handler
 *
 * @package usergroupselector
 * @version 2.1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

global $db_users;

// Remove column from table
if ($db->fieldExists($db_users, "user_usergroup"))
{
	$db->query("ALTER TABLE `$db_users` DROP COLUMN `user_usergroup`");
}