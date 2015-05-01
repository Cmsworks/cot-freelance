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
$category = ($tab=='projects') ? cot_import('cat', 'G', 'TXT') : '' ;

list($pg, $d, $durl) = cot_import_pagenav('dprj', $cfg['projects']['cat___default']['maxrowsperpage']);

//маркет вкладка
$t1 = new XTemplate(cot_tplfile(array('projects','userdetails'), 'module'));
$t1->assign(array(
	"ADDPRJ_URL" => cot_url('projects', 'm=add'),
	"ADDPRJ_SHOWBUTTON" => ($usr['auth_write']) ? true : false
));

$where = array();
$order = array();

if($usr['id'] == 0 || $usr['id'] != $urr['user_id'] && !$usr['isadmin'])
{
	$where['state'] = "item_state=0";
}

if ($category)
{
	$where['cat'] = 'item_cat=' . $db->quote($category);
}

$where['owner'] = "item_userid=" . $urr['user_id'];

$order['date'] = "item_date DESC";

$wherecount = $where;
if($wherecount['cat'])
	unset($wherecount['cat']);

/* === Hook === */
foreach (cot_getextplugins('projects.userdetails.query') as $pl)
{
	include $pl;
}
/* ===== */

$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
$wherecount = ($wherecount) ? 'WHERE ' . implode(' AND ', $wherecount) : '';
$order = ($order) ? 'ORDER BY ' . implode(', ', $order) : '';

$sql_projects_count_cat = $db->query("SELECT item_cat, COUNT(item_cat) as cat_count FROM $db_projects " . $wherecount . " GROUP BY item_cat")->fetchAll();

$sql_projects_count = $db->query("SELECT * FROM $db_projects as p 
	" . $wherecount . "");
$projects_count_all = $projects_count = $sql_projects_count->rowCount();

$sqllist = $db->query("SELECT * FROM $db_projects AS p
	" . $where . "
	" . $order . "
	LIMIT $d, " . $cfg['projects']['cat___default']['maxrowsperpage']);

foreach ($sql_projects_count_cat as $value) {
	$page_nav[$value['item_cat']] = $value['cat_count'];
	$t1->assign(array(
		"PRJ_CAT_ROW_TITLE" => &$structure['projects'][$value['item_cat']]['title'],
		"PRJ_CAT_ROW_ICON" => &$structure['projects'][$value['item_cat']]['icon'],
		"PRJ_CAT_ROW_URL" => cot_url('users', 'm=details&id=' . $urr['user_id'] . '&u=' . $urr['user_name'] . '&tab=projects&cat='.$value['item_cat']),
		"PRJ_CAT_ROW_COUNT_PROJECTS" => $value['cat_count'], 
		"PRJ_CAT_ROW_SELECT" => ($category && $category == $value['item_cat']) ? 1 : '' 
		));
	$t1->parse("MAIN.CAT_ROW");
}

$opt_array = array(
					'm' => 'details',
				  	'id'=> $urr['user_id'],
				  	'u'=> $urr['user_name'],
				    'tab' => 'projects'
				    );
if($category){	
	$projects_count = $page_nav[$category];
	$opt_array['cat'] = $category;
}

$pagenav = cot_pagenav('users',$opt_array , $d, $projects_count, $cfg['projects']['cat___default']['maxrowsperpage'], 'dprj');

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
	"USERS_DETAILS_PROJECTS_COUNT" => $projects_count_all,
	"USERS_DETAILS_PROJECTS_URL" => cot_url('users', 'm=details&id=' . $urr['user_id'] . '&u=' . $urr['user_name'] . '&tab=projects'),
));

$t->assign('PROJECTS', $t1->text("MAIN"));