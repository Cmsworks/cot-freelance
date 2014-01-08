<?php
/**
 * 2.5.2: add and fill item_markup field
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('projects', 'module');

global $db_projects, $cfg;

$db->query("ALTER TABLE $db_projects ADD COLUMN `item_parser` VARCHAR(64) NOT NULL DEFAULT ''");
$db->update($db_projects, array('item_parser' => $cfg['projects']['parser']));

?>
