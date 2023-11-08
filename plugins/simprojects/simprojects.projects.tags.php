<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.tags
 * [END_COT_EXT]
 */

/**
 * simprojects plugin
 *
 * @package simprojects
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('projects', 'module');

$sp_t = new XTemplate(cot_tplfile(array('simprojects'), 'plug'));

$simprojects_where = array();
$simprojects_order = array();

$simprojects_where['state'] = "item_state=0";
$simprojects_where['currentproduct'] = "item_id!=".$item['item_id'];

$simprojects_where['similar'] = "MATCH (`item_title`) AGAINST ('*".$db->prep($item['item_title'])."*' IN BOOLEAN MODE)>".$cfg['plugin']['simprojects']['relev'];

$simprojects_order['date'] = "item_date DESC";

/* === Hook === */
foreach (cot_getextplugins('simprojects.query') as $pl)
{
	include $pl;
}
/* ===== */

$simprojects_where = ($simprojects_where) ? 'WHERE ' . implode(' AND ', $simprojects_where) : '';
$simprojects_order = ($simprojects_order) ? 'ORDER BY ' . implode(', ', $simprojects_order) : '';

$sqlsimprojects = $db->query("SELECT * FROM $db_projects AS p 
	LEFT JOIN $db_users AS u ON u.user_id=p.item_userid 
	" . $simprojects_where . "
	" . $simprojects_order . "
	LIMIT " . $cfg['plugin']['simprojects']['limit'])->fetchAll();

foreach ($sqlsimprojects as $simprj)
{
	$jj++;
	$sp_t->assign(cot_generate_usertags($simprj, 'SIMPRJ_ROW_OWNER_'));

	$sp_t->assign(cot_generate_projecttags($simprj, 'SIMPRJ_ROW_', $cfg['projects']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));
	$sp_t->assign(array(
		"SIMPRJ_ROW_ODDEVEN" => cot_build_oddeven($jj),
	));

	/* === Hook === */
	foreach (cot_getextplugins('simprojects.loop') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sp_t->parse("MAIN.SIMPRJ_ROW");
}

/* === Hook === */
foreach (cot_getextplugins('simprojects.tags') as $pl)
{
	include $pl;
}
/* ===== */

$sp_t->parse('MAIN');
$t->assign('PRJ_SIMPROJECTS', $sp_t->text('MAIN'));