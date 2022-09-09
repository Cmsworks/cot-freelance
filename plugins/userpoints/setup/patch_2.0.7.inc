<?php 

defined('COT_CODE') or die('Wrong URL');

global $db_userpoints;

if (!isset($db_userpoints)) {
    cot::$db->registerTable('userpoints');
}

// Drop field if missing
if (cot::$db->fieldExists($db_userpoints, "item_cancel")) {
    cot::$db->query("ALTER TABLE `$db_userpoints` DROP COLUMN `item_cancel`");
}