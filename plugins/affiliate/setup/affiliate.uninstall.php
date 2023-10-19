<?php

defined('COT_CODE') or die('Wrong URL');

global $db_users;

if ($db->fieldExists($db_users, "user_referal"))
{
	$db->query("ALTER TABLE `$db_users` DROP COLUMN `user_referal`");
}