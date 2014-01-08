<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
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

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('projects', 'module');


if(!$projects_types)
{
	$projects_types =  array();
	$sql_t = $db->query("SELECT * FROM $db_projects_types");
	while ($item = $sql_t->fetch())
	{
		$projects_types[$item['type_id']] = $item['type_title'];
	}
	$cache && $cache->db->store('projects_types', $projects_types, COT_DEFAULT_REALM, 3600);
}
