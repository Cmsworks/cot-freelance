<?php
/**
 * Installation handler
 *
 * @package paypro
 * @version 1.0.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

global $db_users;

// Add field if missing
if (!$db->fieldExists($db_users, "user_pro"))
{
	$dbres = $db->query("ALTER TABLE `$db_users` ADD COLUMN `user_pro` int(10) NOT NULL");
}

?>