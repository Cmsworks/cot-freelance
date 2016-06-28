<?php

/**
 * folio module
 *
 * @package folio
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('folio', 'any', 'RWA');
cot_block($usr['auth_read']);

$sort = cot_import('sort', 'G', 'ALP');
$c = cot_import('c', 'G', 'ALP');
$sq = cot_import('sq', 'G', 'TXT');
$sq = $db->prep($sq);

$maxrowsperpage = ($cfg['folio']['cat_' . $c]['maxrowsperpage']) ? $cfg['folio']['cat_' . $c]['maxrowsperpage'] : $cfg['folio']['cat___default']['maxrowsperpage'];
list($pn, $d, $d_url) = cot_import_pagenav('d', $maxrowsperpage);

/* === Hook === */
foreach (cot_getextplugins('folio.list.first') as $pl)
{
	include $pl;
}
/* ===== */

if (!empty($c))
{
	$out['subtitle'] = (!empty($cfg['folio']['cat_' . $c]['metatitle'])) ? $cfg['folio']['cat_' . $c]['metatitle'] : $cfg['folio']['cat___default']['metatitle'];
	$out['subtitle'] = (!empty($out['subtitle'])) ? $out['subtitle'] : $L['folio'];
	$out['desc'] = (!empty($cfg['folio']['cat_' . $c]['metadesc'])) ? $cfg['folio']['cat_' . $c]['metadesc'] : $cfg['folio']['cat___default']['metadesc'];
	$out['keywords'] = (!empty($cfg['folio']['cat_' . $c]['keywords'])) ? $cfg['folio']['cat_' . $c]['keywords'] : $cfg['folio']['cat___default']['keywords'];
}
else
{
	$out['subtitle'] = (!empty($cfg['folio']['cat___default']['metatitle'])) ? $cfg['folio']['cat___default']['metatitle'] : $L['folio'];
	$out['desc'] = $cfg['folio']['cat___default']['metadesc'];
	$out['keywords'] = $cfg['folio']['cat___default']['keywords'];
}

$where = array();
$order = array();

$where['state'] = "item_state=0";

if (!empty($c))
{
	$catsub = cot_structure_children('folio', $c);
	$where['cat'] = "item_cat IN ('" . implode("','", $catsub) . "')";
}

if (!empty($sq))
{
	$words = explode(' ', preg_replace("'\s+'", " ", $sq));
	$sqlsearch = '%'.implode('%', $words).'%';

	$where['search'] = "(item_title LIKE '".$db->prep($sqlsearch)."' OR item_text LIKE '".$db->prep($sqlsearch)."')";
}

// Extra fields
foreach ($cot_extrafields[$db_folio] as $exfld)
{
	$fld_value = cot_import($exfld['field_name'], 'G', 'TXT');
	$fld_value = $db->prep($fld_value);
	
	if(!empty($fld_value))
	{
		$where[$exfld['field_name']] = "item_".$exfld['field_name']." LIKE '%".$fld_value."%'";
	}
}

switch($sort)
{
	case 'costasc':
		$order['cost'] = 'item_cost ASC';
		break;
	
	case 'costdesc':
		$order['cost'] = 'item_cost DESC';
		break;
	
	default:
		$order['date'] = 'item_date DESC';
		break;
}
$list_url_path = array('c' => $c, 'sort' => $sort, 'sq' => $sq);

// Building the canonical URL
$out['canonical_uri'] = cot_url('folio', $list_url_path);

$mskin = cot_tplfile(array('folio', 'list', $structure['folio'][$c]['tpl']));

/* === Hook === */
foreach (cot_getextplugins('folio.list.query') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
$order = ($order) ? 'ORDER BY ' . implode(', ', $order) : '';

$totalitems = $db->query("SELECT COUNT(*) FROM $db_folio AS f $join_condition 
	LEFT JOIN $db_users AS u ON u.user_id=f.item_userid
	" . $where . "")->fetchColumn();

$sqllist = $db->query("SELECT f.*, u.* $join_columns 
	FROM $db_folio AS f $join_condition 
	LEFT JOIN $db_users AS u ON u.user_id=f.item_userid 
	" . $where . " 
	" . $order . "
	LIMIT $d, " . $maxrowsperpage);

$pagenav = cot_pagenav('folio', $list_url_path, $d, $totalitems, $maxrowsperpage);

$catpatharray[] = array(cot_url('folio'), $L['folio']);

if(!empty($c))
{
	$catpatharray = array_merge($catpatharray, cot_structure_buildpath('folio', $c));
}

$catpath = cot_breadcrumbs($catpatharray, $cfg['homebreadcrumb'], true);

$t->assign(array(
	"SEARCH_ACTION_URL" => cot_url('folio', '', '', true),
	"SEARCH_SQ" => cot_inputbox('text', 'sq', htmlspecialchars($sq), 'class="schstring"'),
	"SEARCH_CAT" => cot_folio_selectcat($c, 'c'),
	"SEARCH_SORTER" => cot_selectbox($sort, "sort", array('', 'costasc', 'costdesc'), array($L['folio_mostrelevant'], $L['folio_costasc'], $L['folio_costdesc']), false),
	"PAGENAV_PAGES" => $pagenav['main'],
	"PAGENAV_PREV" => $pagenav['prev'],
	"PAGENAV_NEXT" => $pagenav['next'],
	"PAGENAV_COUNT" => $totalitems,
	"CATALOG" => cot_build_structure_folio_tree('', array($c), 0),
	"BREADCRUMBS" => $catpath,
));

foreach($cot_extrafields[$db_folio] as $exfld)
{
	$fld_value = cot_import($exfld['field_name'], 'G', 'TXT');
	$fld_value = $db->prep($fld_value);

	$fieldname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields($exfld['field_name'], $exfld, $fld_value);
	$exfld_title = isset($L['folio_'.$exfld['field_name'].'_title']) ?  $L['folio_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
	$t->assign(array(
		'SEARCH_'.$fieldname => $exfld_val,
		'SEARCH_'.$fieldname.'_TITLE' => $exfld_title,
	));
}

/* === Hook === */
foreach (cot_getextplugins('folio.list.search.tags') as $pl)
{
	include $pl;
}
/* ===== */

if(!empty($c) && is_array($structure['folio'][$c]))
{
	foreach ($structure['folio'][$c] as $field => $val)
	{
		$t->assign('CAT'.strtoupper($field), $val);
	}
}

$sqllist_rowset = $sqllist->fetchAll();
$sqllist_idset = array();
foreach($sqllist_rowset as $item)
{
	$sqllist_idset[$item['item_id']] = $item['item_alias'];
}
/* === Hook === */
$extp = cot_getextplugins('folio.list.loop');
/* ===== */

foreach($sqllist_rowset as $item)
{
	$jj++;
	$t->assign(cot_generate_usertags($item, 'PRD_ROW_OWNER_'));

	$t->assign(cot_generate_foliotags($item, 'PRD_ROW_', $cfg['folio']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));
	$t->assign(array(
		"PRD_ROW_ODDEVEN" => cot_build_oddeven($jj),
	));

	/* === Hook - Part2 : Include === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse("MAIN.PRD_ROWS");
}
/* === Hook === */
foreach (cot_getextplugins('folio.list.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$module_body = $t->text('MAIN');

