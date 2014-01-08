<?php
/**
 * 2.5.2: add and fill item_markup field
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('market', 'module');

global $db_market, $cfg;

$db->query("ALTER TABLE $db_market ADD COLUMN `item_parser` VARCHAR(64) NOT NULL DEFAULT ''");
$db->update($db_market, array('item_parser' => $cfg['market']['parser']));

?>
