<?php
/**
 * 2.5.1:
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('usercategories', 'plug');

global $db_usercategories, $db_usercategories_users;

$db->query("ALTER TABLE $db_usercategories ADD COLUMN `cat_code` VARCHAR(64) NOT NULL DEFAULT ''");
$db->query("ALTER TABLE $db_usercategories_users CHANGE `ucat_cat` `ucat_cat` VARCHAR( 64 ) NOT NULL");
$db->query("ALTER TABLE $db_usercategories_users ADD `ucat_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST");

$sql = $db->query("SELECT * FROM $db_usercategories WHERE 1");
while($row = $sql->fetch())
{
	$nrow['cat_code'] = $row['cat_id'];
	$db->update($db_usercategories, $nrow, "cat_id=" . $row['cat_id']);
	
	$ucat['ucat_cat'] = $nrow['cat_code'];
	$db->update($db_usercategories_users, $ucat, "ucat_cat='" . $row['cat_id'] . "'");
}