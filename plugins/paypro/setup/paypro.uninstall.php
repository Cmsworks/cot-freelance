<?php
/**
 * Uninstallation handler
 *
 * @package paypro
 * @version 1.0.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

global $db_users;

// Remove column from table
if ($db->fieldExists($db_users, "user_pro"))
{
	$db->query("ALTER TABLE `$db_users` DROP COLUMN `user_pro`");
}

?>