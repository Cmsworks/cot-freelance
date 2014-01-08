<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.details.tags
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

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('projects', 'any', 'RWA');

$tab = cot_import('tab', 'G', 'ALP');
list($pg, $d, $durl) = cot_import_pagenav('dprj', $cfg['projects']['cat___default']['maxrowsperpage']);

//маркет вкладка
$t1 = new XTemplate(cot_tplfile(array('projects','userdetails'), 'module'));
$t1->assign(array(
	"PRD_ADDPRJ_URL" => cot_url('projects', 'm=add'),
	"RPD_ADDPRJ_SHOWBUTTON" => ($usr['auth_write']) ? true : false
));

$where = array();
$order = array();

if($usr['id'] == 0 || $usr['id'] != $urr['user_id'] && !$usr['isadmin'])
{
	$where['state'] = "item_state=0";
}

$where['owner'] = "item_userid=" . $urr['user_id'];

$order['date'] = "item_date DESC";

/* === Hook === */
foreach (cot_getextplugins('projects.userdetails.query') as $pl)
{
	include $pl;
}
/* ===== */

$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
$order = ($order) ? 'ORDER BY ' . implode(', ', $order) : '';

$sql_projects_count = $db->query("SELECT * FROM $db_projects as p 
	" . $where . "");
$projects_count = $sql_projects_count->rowCount();

$sqllist = $db->query("SELECT * FROM $db_projects AS p
	" . $where . "
	" . $order . "
	LIMIT $d, " . $cfg['projects']['cat___default']['maxrowsperpage']);

$pagenav = cot_pagenav('users', 'm=details&id=' . $urr['user_id'] . '&u=' . $urr['user_name'] . '&tab=projects', $d, $projects_count, $cfg['projects']['cat___default']['maxrowsperpage'], 'dprj');

$t1->assign(array(
	"PAGENAV_PAGES" => $pagenav['main'],
	"PAGENAV_PREV" => $pagenav['prev'],
	"PAGENAV_NEXT" => $pagenav['next'],
	"PAGENAV_COUNT" => $projects_count,
));

$sqllist_rowset = $sqllist->fetchAll();
$sqllist_idset = array();
foreach($sqllist_rowset as $item)
{
	$sqllist_idset[$item['item_id']] = $item['item_alias'];
}

/* === Hook === */
$extp = cot_getextplugins('projects.userdetails.loop');
/* ===== */

foreach($sqllist_rowset as $item)
{
	$t1->assign(cot_generate_projecttags($item, 'PRJ_ROW_', $cfg['projects']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));
	
	/* === Hook === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t1->parse("MAIN.PRJ_ROWS");
}

/* === Hook === */
	foreach (cot_getextplugins('projects.userdetails.tags') as $pl)
	{
		include $pl;
	}
	/* ===== */

$t1->parse("MAIN");

$t->assign(array(
	"USERS_DETAILS_PROJECTS_COUNT" => $projects_count,
	"USERS_DETAILS_PROJECTS_URL" => cot_url('users', 'm=details&id=' . $urr['user_id'] . '&u=' . $urr['user_name'] . '&tab=projects'),
));

$t->assign('PROJECTS', $t1->text("MAIN"));