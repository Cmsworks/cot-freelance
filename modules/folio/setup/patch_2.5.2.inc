<?php
/**
 * 2.5.2: add and fill item_markup field
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('folio', 'module');

global $db_folio, $cfg;

$db->query("ALTER TABLE $db_folio ADD COLUMN `item_parser` VARCHAR(64) NOT NULL DEFAULT ''");
$db->update($db_folio, array('item_parser' => $cfg['folio']['parser']));

?>
