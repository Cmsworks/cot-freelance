<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.details.tags
 * [END_COT_EXT]
 */

/**
 * folio module
 *
 * @package folio
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');
require_once cot_incfile('folio', 'module');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('folio', 'any', 'RWA');

$tab = cot_import('tab', 'G', 'ALP');
$category = ($tab=='portfolio') ? cot_import('cat', 'G', 'TXT') : '' ;
list($pg, $d, $durl) = cot_import_pagenav('dfolio', $cfg['folio']['cat___default']['maxrowsperpage']);

$t1 = new XTemplate(cot_tplfile(array('folio','userdetails'), 'module'));
$t1->assign(array(
	"PRD_ADDPRD_URL" => cot_url('folio', 'm=add'),
	"RPD_ADDPRD_SHOWBUTTON" => ($usr['auth_write']) ? true : false
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
foreach (cot_getextplugins('folio.userdetails.query') as $pl)
{
	include $pl;
}
/* ===== */

$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
$wherecount = ($wherecount) ? 'WHERE ' . implode(' AND ', $wherecount) : '';
$order = ($order) ? 'ORDER BY ' . implode(', ', $order) : '';

$sql_folio_count_cat = $db->query("SELECT item_cat, COUNT(item_cat) as cat_count FROM $db_folio " . $wherecount . " GROUP BY item_cat")->fetchAll();

$sql_folio_count = $db->query("SELECT * FROM $db_folio as f 
	" . $wherecount . "");
$folio_count_all = $folio_count = $sql_folio_count->rowCount();

$sqllist = $db->query("SELECT * FROM $db_folio AS f
	" . $where . "
	" . $order . "
	LIMIT $d, " . $cfg['folio']['cat___default']['maxrowsperpage']);

foreach ($sql_folio_count_cat as $value) {
	$page_nav[$value['item_cat']] = $value['cat_count'];
	$t1->assign(array(
		"PRD_CAT_ROW_TITLE" => &$structure['folio'][$value['item_cat']]['title'],
		"PRD_CAT_ROW_ICON" => &$structure['folio'][$value['item_cat']]['icon'],
		"PRD_CAT_ROW_URL" => cot_url('users', 'm=details&id=' . $urr['user_id'] . '&u=' . $urr['user_name'] . '&tab=portfolio&cat='.$value['item_cat']),
		"PRD_CAT_ROW_COUNT_FOLIO" => $value['cat_count'], 
		"PRD_CAT_ROW_SELECT" => ($category && $category == $value['item_cat']) ? 1 : '' 
		));
	$t1->parse("MAIN.CAT_ROW");
}

$opt_array = array(
					'm' => 'details',
				  	'id'=> $urr['user_id'],
				  	'u'=> $urr['user_name'],
				    'tab' => 'portfolio'
				    );
if($category){	
	$folio_count = $page_nav[$category];
	$opt_array['cat'] = $category;
}

$pagenav = cot_pagenav('users',$opt_array , $d, $folio_count, $cfg['folio']['cat___default']['maxrowsperpage'], 'dfolio');

$t1->assign(array(
	"PAGENAV_PAGES" => $pagenav['main'],
	"PAGENAV_PREV" => $pagenav['prev'],
	"PAGENAV_NEXT" => $pagenav['next'],
	"PAGENAV_COUNT" => $folio_count,
));

$sqllist_rowset = $sqllist->fetchAll();
$sqllist_idset = array();
foreach($sqllist_rowset as $item)
{
	$sqllist_idset[$item['item_id']] = $item['item_alias'];
}

/* === Hook === */
$extp = cot_getextplugins('folio.userdetails.loop');
/* ===== */

foreach($sqllist_rowset as $item)
{
	$t1->assign(cot_generate_foliotags($item, 'PRD_ROW_', $cfg['folio']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));
	
	/* === Hook === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t1->parse("MAIN.PRD_ROWS");
}

/* === Hook === */
	foreach (cot_getextplugins('folio.userdetails.tags') as $pl)
	{
		include $pl;
	}
	/* ===== */

$t1->parse("MAIN");

$t->assign(array(
	"USERS_DETAILS_FOLIO_COUNT" => $folio_count_all,
	"USERS_DETAILS_FOLIO_URL" => cot_url('users', 'm=details&id=' . $urr['user_id'] . '&u=' . $urr['user_name'] . '&tab=portfolio'),
));

$t->assign('PORTFOLIO', $t1->text("MAIN"));