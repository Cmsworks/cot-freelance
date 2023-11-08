<?php defined('COT_CODE') or die('Wrong URL');
global $db_users;
if (!$db->fieldExists($db_users, "user_detailcounts"))
{
	$db->query("ALTER TABLE `$db_users` ADD COLUMN `user_detailcounts` int(11) NOT NULL");
}