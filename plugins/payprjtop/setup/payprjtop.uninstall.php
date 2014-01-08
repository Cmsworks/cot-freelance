<?php
/**
 * Uninstallation handler
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

// Remove column from table
if ($db->fieldExists($db_projects, "item_top"))
{
	$db->query("ALTER TABLE `$db_projects` DROP COLUMN `item_top`");
}

?>