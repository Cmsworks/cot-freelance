<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.home.sidepanel
Order=1
[END_COT_EXT]
==================== */

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

$tt = new XTemplate(cot_tplfile('projects.admin.home', 'module', true));

$publicprojects = $db->query("SELECT COUNT(*) FROM $db_projects WHERE item_state='0'");
$publicprojects = $publicprojects->fetchColumn();

$hiddenprojects = $db->query("SELECT COUNT(*) FROM $db_projects WHERE item_state='1'");
$hiddenprojects = $hiddenprojects->fetchColumn();

$projectsqueued = $db->query("SELECT COUNT(*) FROM $db_projects WHERE item_state='2'");
$projectsqueued = $projectsqueued->fetchColumn();

$tt->assign(array(
	'ADMIN_HOME_PROJECTS_QUEUED_URL' => cot_url('admin', 'm=projects&state=2'),
	'ADMIN_HOME_PROJECTS_PUBLIC_URL' => cot_url('admin', 'm=projects&state=0'),
	'ADMIN_HOME_PROJECTS_HIDDEN_URL' => cot_url('admin', 'm=projects&state=1'),
	'ADMIN_HOME_PROJECTS_QUEUED' => $projectsqueued,
	'ADMIN_HOME_PROJECTS_PUBLIC' => $publicprojects,
	'ADMIN_HOME_PROJECTS_HIDDEN' => $hiddenprojects,
));

$tt->parse('MAIN');

$line = $tt->text('MAIN');
