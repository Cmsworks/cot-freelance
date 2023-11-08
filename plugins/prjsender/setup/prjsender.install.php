<?php

defined('COT_CODE') or die('Wrong URL');

global $db_users;

if (!$db->fieldExists($db_users, "user_prjsenderdate"))
{
	$db->query("ALTER TABLE `$db_users` ADD COLUMN `user_prjsenderdate` INT NOT NULL");
}

if (!$db->fieldExists($db_users, "user_prjsendercats"))
{
	$db->query("ALTER TABLE `$db_users` ADD COLUMN `user_prjsendercats` MEDIUMTEXT collate utf8_unicode_ci NOT NULL");
}