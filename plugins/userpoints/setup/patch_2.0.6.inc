<?php 

defined('COT_CODE') or die('Wrong URL');

global $db_users;

// Add field if missing
if (!$db->fieldExists($db_users, "user_userpointsauth"))
{
	$db->query("ALTER TABLE `$db_users` ADD COLUMN `user_userpointsauth` int(11) NOT NULL");
}