<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin.extrafields.first
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
$extra_whitelist[$db_projects] = array(
	'name' => $db_projects,
	'caption' => $L['Module'].' Projects',
	'type' => 'module',
	'code' => 'projects',
	'tags' => array(
		'projects.list.tpl' => '{LIST_ROW_XXXXX}, {LIST_TOP_XXXXX}',
		'projects.tpl, projects.step2.tpl' => '{PRJ_XXXXX}, {PRJ_XXXXX_TITLE}',
		'projects.add.tpl' => '{PRJADD_FORM_XXXXX}, {PRJADD_FORM_XXXXX_TITLE}',
		'projects.edit.tpl' => '{PRJEDIT_FORM_XXXXX}, {PRJEDIT_FORM_XXXXX_TITLE}',
	)
);
$extra_whitelist[$db_projects_offers] = array(
	'name' => $db_projects,
	'caption' => $L['Module'].' Offers',
	'type' => 'module',
	'code' => 'offers',
	'tags' => array(
		'projects.offers.tpl' => '{OFFER_ROW_XXXXX}, {OFFER_FORM_XXXXX}',
	)
);