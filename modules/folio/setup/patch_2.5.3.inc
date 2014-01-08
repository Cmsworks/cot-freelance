<?php
/**
 * 2.5.3
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('folio', 'module');

global $db_folio, $cfg;

if (!$db->fieldExists($db_folio, "item_country"))
{
	$db->query("ALTER TABLE `$db_folio` ADD COLUMN `item_country` varchar(3) collate utf8_unicode_ci NOT NULL");
}

if (!$db->fieldExists($db_folio, "item_region"))
{
	$db->query("ALTER TABLE `$db_folio` ADD COLUMN `item_region` INT( 11 ) NOT NULL DEFAULT '0'");
}

if (!$db->fieldExists($db_folio, "item_city"))
{
	$db->query("ALTER TABLE `$db_folio` ADD COLUMN `item_city` INT( 11 ) NOT NULL DEFAULT '0'");
}

?>
