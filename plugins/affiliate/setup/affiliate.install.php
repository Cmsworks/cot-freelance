<?php

defined('COT_CODE') or die('Wrong URL');

global $db_users;

if (!$db->fieldExists($db_users, "user_referal"))
{
	$db->query("ALTER TABLE `$db_users` ADD COLUMN `user_referal` int(11) NOT NULL");
}