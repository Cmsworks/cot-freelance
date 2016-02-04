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

// Add field if missing
if (!$db->fieldExists($db_users, "user_userpoints"))
{
	$db->query("ALTER TABLE `$db_users` ADD COLUMN `user_userpoints` float NOT NULL");
}
if (!$db->fieldExists($db_users, "user_userpointsauth"))
{
	$db->query("ALTER TABLE `$db_users` ADD COLUMN `user_userpointsauth` int(11) NOT NULL");
}