<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.edit.update.delete
 * [END_COT_EXT]
 */

/**
 * projects module
 *
 * @package projects
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');
require_once cot_incfile('projects', 'module');

$db->update($db_projects, array('item_state' => -1), "item_userid='" . $urr['user_id'] . "'");
