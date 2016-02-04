<?php
/**
 * Uninstallation handler
 *
 * @package userpoints
 * @version 2.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

global $db_users;

// Remove column from table
if ($db->fieldExists($db_users, "user_userpoints"))
{
	$db->query("ALTER TABLE `$db_users` DROP COLUMN `user_userpoints`");
}

if ($db->fieldExists($db_users, "user_userpointsauth"))
{
	$db->query("ALTER TABLE `$db_users` DROP COLUMN `user_userpointsauth`");
}