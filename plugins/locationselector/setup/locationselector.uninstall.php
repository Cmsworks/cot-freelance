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

global $db_users;

// Remove column from table
if ($db->fieldExists($db_users, "user_region"))
{
	$db->query("ALTER TABLE `$db_users` DROP COLUMN `user_region`");
}

if ($db->fieldExists($db_users, "user_city"))
{
	$db->query("ALTER TABLE `$db_users` DROP COLUMN `user_city`");
}

?>