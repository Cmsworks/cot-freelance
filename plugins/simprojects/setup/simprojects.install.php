<?php

/**
 * simprojects plugin
 *
 * @package simprojects
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('projects', 'module');

global $db_projects;

$db->query("ALTER TABLE $db_projects ADD FULLTEXT(item_title)");
