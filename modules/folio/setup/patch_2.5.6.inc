<?php
/**
 * 2.5.6
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('folio', 'module');

global $db_folio, $cfg;

if (!$db->fieldExists($db_folio, "item_update"))
{
	$db->query("ALTER TABLE `$db_folio` ADD COLUMN `item_update` INT( 11 ) NOT NULL");
}