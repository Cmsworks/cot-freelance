<?php

/**
 * projects module
 *
 * @package projects
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('projects', 'any', 'RWA');
cot_block($usr['auth_read']);

$type = cot_import('type', 'G', 'INT');
$sort = cot_import('sort', 'G', 'ALP');
$c = cot_import('c', 'G', 'ALP');
$forpro = cot_import('forpro', 'G', 'INT');
$realized = cot_import('realized', 'G', 'INT');
$sq = cot_import('sq', 'G', 'TXT');
$sq = $db->prep($sq);

$maxrowsperpage = ($cfg['projects']['cat_' . $c]['maxrowsperpage']) ? $cfg['projects']['cat_' . $c]['maxrowsperpage'] : $cfg['projects']['cat___default']['maxrowsperpage'];
list($pn, $d, $d_url) = cot_import_pagenav('d', $maxrowsperpage);
	
/* === Hook === */
foreach (cot_getextplugins('projects.list.first') as $pl)
{
	include $pl;
}
/* ===== */


if (!empty($c))
{
	$out['subtitle'] = (!empty($cfg['projects']['cat_' . $c]['metatitle'])) ? $cfg['projects']['cat_' . $c]['metatitle'] : $cfg['projects']['cat___default']['metatitle'];
	$out['subtitle'] = (!empty($out['subtitle'])) ? $out['subtitle'] : $L['projects'];
	$out['desc'] = (!empty($cfg['projects']['cat_' . $c]['metadesc'])) ? $cfg['projects']['cat_' . $c]['metadesc'] : $cfg['projects']['cat___default']['metadesc'];
	$out['keywords'] = (!empty($cfg['projects']['cat_' . $c]['keywords'])) ? $cfg['projects']['cat_' . $c]['keywords'] : $cfg['projects']['cat___default']['keywords'];
}
else
{
	$out['subtitle'] = (!empty($cfg['projects']['cat___default']['metatitle'])) ? $cfg['projects']['cat___default']['metatitle'] : $L['projects'];
	$out['desc'] = $cfg['projects']['cat___default']['metadesc'];
	$out['keywords'] = $cfg['projects']['cat___default']['keywords'];
}

$where = array();
$order = array();

$where['state'] = "item_state=0";

if($realized == 1)
{
	$where['realized'] = "item_realized=1";
}

if (!empty($c))
{
	$catsub = cot_structure_children('projects', $c);
	$where['cat'] = "item_cat IN ('" . implode("','", $catsub) . "')";
}

if (!empty($type))
{
	$where['type'] = "item_type=" . $type;
}

if (!empty($sq))
{
	$words = explode(' ', preg_replace("'\s+'", " ", $sq));
	$sqlsearch = '%'.implode('%', $words).'%';

	$where['search'] = "(item_title LIKE '".$db->prep($sqlsearch)."' OR item_text LIKE '".$db->prep($sqlsearch)."')";
}

// Extra fields
foreach ($cot_extrafields[$db_projects] as $exfld)
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
$list_url_path = array('c' => $c, 'type'=> $type, 'sort' => $sort, 'sq' => $sq);

// Building the canonical URL
$out['canonical_uri'] = cot_url('projects', $list_url_path);

$mskin = cot_tplfile(array('projects', 'list', $structure['projects'][$c]['tpl']));

/* === Hook === */
foreach (cot_getextplugins('projects.list.query') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
$order = ($order) ? 'ORDER BY ' . implode(', ', $order) : '';

$totalitems = $db->query("SELECT COUNT(*) FROM $db_projects AS p $join_condition
	LEFT JOIN $db_users AS u ON u.user_id=p.item_userid
	" . $where . "")->fetchColumn();

$sqllist = $db->query("SELECT p.*, u.* $join_columns 
	FROM $db_projects AS p $join_condition
	LEFT JOIN $db_users AS u ON u.user_id=p.item_userid
	" . $where . "
	" . $order . "
	LIMIT $d, " . $maxrowsperpage);

$pagenav = cot_pagenav('projects', $list_url_path, $d, $totalitems, $maxrowsperpage);

$catpatharray[] = array(cot_url('projects'), $L['projects']);
if(!empty($c))
{
	$catpatharray = array_merge($catpatharray, cot_structure_buildpath('projects', $c));
}

$catpath = cot_breadcrumbs($catpatharray, $cfg['homebreadcrumb'], true);

if(is_array($projects_types)){
	foreach ($projects_types as $i => $pr_type)
	{
		$t->assign(array(
			"PTYPE_ROW_ID" => $i,
			"PTYPE_ROW_TITLE" => $pr_type,
			"PTYPE_ROW_URL" => cot_url('projects', 'c=' . $c . '&type=' . $i),
			"PTYPE_ROW_ACT" => ($type == $i) ? 'act' : ''
		));
		$t->parse("MAIN.PTYPES.PTYPES_ROWS");
	}
}

$t->assign(array(
	"PTYPE_ALL_URL" => cot_url('projects', 'c=' . $c),
	"PTYPE_ALL_ACT" => (empty($type) && empty($realized)) ? true : false,
	"REALIZED_URL" => cot_url('projects', 'c=' . $c . '&realized=1'),
	"FORPRO_URL" => cot_url('projects', 'c=' . $c . '&type=' . $type . '&forpro=1'),
	"REALIZED_ACT" => (!empty($realized)) ? true : false,
	"SUBMITNEWPROJECT_URL" => cot_url('projects', 'm=add&c='.$c.'&type='.$type)
));

$t->parse("MAIN.PTYPES");

$t->assign(array(
	"SEARCH_ACTION_URL" => cot_url('projects', "&type=" . $type, '', true),
	"SEARCH_SQ" => cot_inputbox('text', 'sq', htmlspecialchars($sq), 'class="schstring"'),
	"SEARCH_CAT" => cot_projects_selectcat($c, 'c'),
	"SEARCH_SORTER" => cot_selectbox($sort, "sort", array('', 'costasc', 'costdesc'), array($L['projects_mostrelevant'], $L['projects_costasc'], $L['projects_costdesc']), false),
	"PAGENAV_PAGES" => $pagenav['main'],
	"PAGENAV_PREV" => $pagenav['prev'],
	"PAGENAV_NEXT" => $pagenav['next'],
	"PAGENAV_COUNT" => $totalitems,
	"CATALOG" => cot_build_structure_projects_tree('', array($c)),
	"BREADCRUMBS" => $catpath,
	"SUBMITNEWPROJECT_URL" => cot_url('projects', 'm=add&c='.$c.'&type='.$type)
));

foreach($cot_extrafields[$db_projects] as $exfld)
{
	$fld_value = cot_import($exfld['field_name'], 'G', 'TXT');
	$fld_value = $db->prep($fld_value);
	
	$fieldname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields($exfld['field_name'], $exfld, $fld_value);
	$exfld_title = isset($L['projects_'.$exfld['field_name'].'_title']) ?  $L['projects_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
	$t->assign(array(
		'SEARCH_'.$fieldname => $exfld_val,
		'SEARCH_'.$fieldname.'_TITLE' => $exfld_title,
	));
}

/* === Hook === */
foreach (cot_getextplugins('projects.list.search.tags') as $pl)
{
	include $pl;
}
/* ===== */

if(!empty($c) && is_array($structure['projects'][$c]))
{
	foreach ($structure['projects'][$c] as $field => $val)
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
$extp = cot_getextplugins('projects.list.loop');
/* ===== */

foreach($sqllist_rowset as $item)
{
	$jj++;
	$t->assign(cot_generate_usertags($item, 'PRJ_ROW_OWNER_'));
	$t->assign(cot_generate_projecttags($item, 'PRJ_ROW_', $cfg['projects']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));
	$t->assign(array(
		"PRJ_ROW_ODDEVEN" => cot_build_oddeven($jj)
	));

	/* === Hook - Part2 : Include === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse("MAIN.PRJ_ROWS");
}

/* === Hook === */
foreach (cot_getextplugins('projects.list.tags') as $pl)
{
	include $pl;
}
/* ===== */
$t->parse('MAIN');
$module_body = $t->text('MAIN');