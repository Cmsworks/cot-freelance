<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=index.tags
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
list($pn, $p, $d_url) = cot_import_pagenav('p', $cfg['projects']['indexlimit']);

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('projects', 'any', 'RWA');

$t_pr = new XTemplate(cot_tplfile('projects.index', 'module'));

if(is_array($projects_types)){
	foreach ($projects_types as $i => $pr_type)
	{
		$t_pr->assign(array(
			'PTYPE_ROW_ID' => $i,
			'PTYPE_ROW_TITLE' => $pr_type,
			'PTYPE_ROW_URL' => cot_url('projects', 'type=' . $i),
		));
		$t_pr->parse("SEARCH.PTYPES.PTYPES_ROWS");
	}
}
$t_pr->assign(array(
	'PTYPE_ALL_URL' => cot_url('projects', ''),
	'REALIZED_URL' => cot_url('projects', 'realized=1'),
	"FORPRO_URL" => cot_url('projects', 'forpro=1'),
));

$t_pr->parse("SEARCH.PTYPES");

$t_pr->assign(array(
	'SEARCH_ACTION_URL' => cot_url('projects', '', '', true),
	'SEARCH_SQ' => cot_inputbox('text', 'sq', htmlspecialchars($sq), 'class="schstring"'),
	"SEARCH_CAT" => cot_projects_selectcat($c, 'c'),
	"SEARCH_SORTER" => cot_selectbox($sort, "sort", array('', 'costasc', 'costdesc'), array($L['projects_mostrelevant'], $L['projects_costasc'], $L['projects_costdesc']), false),
));

foreach($cot_extrafields[$db_projects] as $exfld)
{
	$fieldname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields($exfld['field_name'], $exfld, '');
	$exfld_title = isset($L['projects_'.$exfld['field_name'].'_title']) ?  $L['projects_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
	$t_pr->assign(array(
		'SEARCH_'.$fieldname => $exfld_val,
		'SEARCH_'.$fieldname.'_TITLE' => $exfld_title,
	));
}

/* === Hook === */
foreach (cot_getextplugins('projects.index.searchtags') as $pl)
{
	include $pl;
}
/* ===== */

$t_pr->parse('SEARCH');

$t->assign('PROJECTS_SEARCH', $t_pr->text('SEARCH'));

// Количество реализованных проектов
$sql = $db->query("SELECT COUNT(*) FROM $db_projects WHERE item_state=0 AND item_realized=1");
$countofrealizedprojects = $sql->fetchColumn();

$t->assign(array(
	"COUNTOFREALIZEDPROJECTS" => $countofrealizedprojects
));

$where = array();
$where['state'] = "item_state=0";

$order['date'] = 'item_date DESC';

/* === Hook === */
foreach (cot_getextplugins('projects.index.query') as $pl)
{
	include $pl;
}
/* ===== */

$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
$order = ($order) ? 'ORDER BY ' . implode(', ', $order) : '';

$totalitems = $db->query("SELECT COUNT(*) FROM $db_projects AS p $join_condition 
	" . $where . "")->fetchColumn();

$sqllist = $db->query("SELECT p.*, u.* $join_columns 
	FROM $db_projects AS p $join_condition 
	LEFT JOIN $db_users AS u ON u.user_id=p.item_userid 
	" . $where . " 
	" . $order . " 
	LIMIT $p, " . $cfg['projects']['indexlimit']);

$pagenav = cot_pagenav('index', '', $p, $totalitems, $cfg['projects']['indexlimit'], 'p');

$t_pr->assign(array(
	"PAGENAV_PAGES" => $pagenav['main'],
	"PAGENAV_PREV" => $pagenav['prev'],
	"PAGENAV_NEXT" => $pagenav['next'],
));

$sqllist_rowset = $sqllist->fetchAll();
$sqllist_idset = array();
foreach($sqllist_rowset as $item)
{
	$sqllist_idset[$item['item_id']] = $item['item_alias'];
}

/* === Hook === */
$extp = cot_getextplugins('projects.index.loop');
/* ===== */

foreach($sqllist_rowset as $item)
{
	$jj++;
	$t_pr->assign(cot_generate_usertags($item, 'PRJ_ROW_OWNER_'));
	$t_pr->assign(cot_generate_projecttags($item, 'PRJ_ROW_', $cfg['projects']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));
	$t_pr->assign(array(
		"PRJ_ROW_ODDEVEN" => cot_build_oddeven($jj),
	));
	
	/* === Hook - Part2 : Include === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	$t_pr->parse("PROJECTS.PRJ_ROWS");
}

$t_pr->assign(array(
	"COUNTOFREALIZEDPROJECTS" => $countofrealizedprojects
));

$t_pr->parse("PROJECTS");
$t->assign('PROJECTS', $t_pr->text('PROJECTS'));


$t->assign(array(
	"PROJECTS_CATALOG" => cot_build_structure_projects_tree('', array())

));

/* === Hook === */
foreach (cot_getextplugins('projects.index.tags') as $pl)
{
	include $pl;
}
/* ===== */