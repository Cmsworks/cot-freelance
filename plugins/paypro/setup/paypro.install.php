<?php
/**
 * Installation handler
 *
 * @package paypro
 * @version 1.0.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

global $db_users, $db_projects, $R;

require_once cot_incfile('projects', 'module');
require_once cot_incfile('extrafields');

// Add field if missing
if (!cot::$db->fieldExists($db_users, "user_pro")) {
    // Todo may be tinyint?
	$dbres = cot::$db->query("ALTER TABLE `$db_users` ADD COLUMN `user_pro` int NULL DEFAULT 0");
}

cot_extrafield_add($db_projects, 'forpro', 'checkbox', $R['input_checkbox'],'','','','', '','');
