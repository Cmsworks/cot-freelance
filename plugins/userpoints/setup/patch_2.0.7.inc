<?php 

defined('COT_CODE') or die('Wrong URL');

global $db_userpoints;

// Drop field if missing
if ($db->fieldExists($db_userpoints, "item_cancel"))
{
	$db->query("ALTER TABLE `$db_userpoints` DROP COLUMN `item_cancel`");
}