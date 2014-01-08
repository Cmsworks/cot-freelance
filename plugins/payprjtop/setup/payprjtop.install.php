<?php
/**
 * Installation handler
 *
 * @package payprjtop
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('projects', 'module');

global $db_projects;

// Add field if missing
if (!$db->fieldExists($db_projects, "item_top"))
{
	$dbres = $db->query("ALTER TABLE `$db_projects` ADD COLUMN `item_top` int(10) NOT NULL");
}

?>