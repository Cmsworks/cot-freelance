<?php
/**
 * 2.5.4
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('projects', 'module');

global $db_projects, $cfg;

if (!$db->fieldExists($db_projects, "item_update"))
{
	$db->query("ALTER TABLE `$db_projects` ADD COLUMN `item_update` INT( 11 ) NOT NULL");
}