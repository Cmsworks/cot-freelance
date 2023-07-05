<?php
/**
 * market module
 *
 * @package market
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

$sort = cot_import('sort', 'G', 'ALP');
$c = cot_import('c', 'G', 'ALP');
$sq = cot_import('sq', 'G', 'TXT');

if (!empty($c)) {
	list(cot::$usr['auth_read'], cot::$usr['auth_write'], cot::$usr['isadmin']) = cot_auth('market', $c);

} else {
	list(cot::$usr['auth_read'], cot::$usr['auth_write'], cot::$usr['isadmin']) =
        cot_auth('market', 'any', 'RWA');
}
cot_block(cot::$usr['auth_read']);

$maxrowsperpage = cot::$cfg['market']['cat___default']['maxrowsperpage'];
if (!empty($c) && isset(cot::$cfg['market']['cat_' . $c]) && !empty(cot::$cfg['market']['cat_' . $c]['maxrowsperpage'])) {
    $maxrowsperpage = cot::$cfg['market']['cat_' . $c]['maxrowsperpage'];
}

list($pn, $d, $d_url) = cot_import_pagenav('d', $maxrowsperpage);

/* === Hook === */
foreach (cot_getextplugins('market.list.first') as $pl) {
	include $pl;
}
/* ===== */

if (!empty($c)) {
    cot::$out['subtitle'] = (!empty($cfg['market']['cat_' . $c]['metatitle'])) ? $cfg['market']['cat_' . $c]['metatitle'] : $cfg['market']['cat___default']['metatitle'];
    cot::$out['subtitle'] = (!empty($out['subtitle'])) ? $out['subtitle'] : $L['market'];
    cot::$out['desc'] = (!empty($cfg['market']['cat_' . $c]['metadesc'])) ? $cfg['market']['cat_' . $c]['metadesc'] : $cfg['market']['cat___default']['metadesc'];
    cot::$out['keywords'] = (!empty($cfg['market']['cat_' . $c]['keywords'])) ? $cfg['market']['cat_' . $c]['keywords'] : $cfg['market']['cat___default']['keywords'];
} else {
    cot::$out['subtitle'] = (!empty($cfg['market']['cat___default']['metatitle'])) ? $cfg['market']['cat___default']['metatitle'] : $L['market'];
    cot::$out['desc'] = $cfg['market']['cat___default']['metadesc'];
    cot::$out['keywords'] = $cfg['market']['cat___default']['keywords'];
}

$where = array();
$order = array();

$where['state'] = "item_state=0";

if (!empty($c)) {
	$catsub = cot_structure_children('market', $c);
	$where['cat'] = "item_cat IN ('" . implode("','", $catsub) . "')";
}

if (!empty($sq)) {
	$words = explode(' ', preg_replace("'\s+'", " ", $sq));
	$sqlsearch = '%'.implode('%', $words).'%';

	$where['search'] = "(item_title LIKE " . cot::$db->quote($sqlsearch) .
        " OR item_text LIKE " . cot::$db->quote($sqlsearch) . ")";
}

// Extra fields
foreach ($cot_extrafields[$db_market] as $exfld)
{
	$fld_value = cot_import($exfld['field_name'], 'G', 'TXT');
	$fld_value = $db->prep($fld_value);
	
	if(!empty($shfld[$exfld['field_name']]))
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
$out['canonical_uri'] = cot_url('market', $list_url_path);

if (!empty($c) && isset(cot::$structure['market'][$c])) {
    $mskin = cot_tplfile(array('market', 'list', cot::$structure['market'][$c]['tpl']));
} else {
    $mskin = cot_tplfile(['market', 'list']);
}

$join_columns = $join_condition = '';

/* === Hook === */
foreach (cot_getextplugins('market.list.query') as $pl) {
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
$order = ($order) ? 'ORDER BY ' . implode(', ', $order) : '';

$totalitems = cot::$db->query('SELECT COUNT(*) FROM ' . cot::$db->market . " AS m $join_condition 
	LEFT JOIN " . cot::$db->users . ' AS u ON u.user_id=m.item_userid ' . $where)->fetchColumn();

$sql = "SELECT m.*, u.* $join_columns FROM " . cot::$db->market . " AS m $join_condition
	LEFT JOIN " . cot::$db->users . " AS u ON u.user_id=m.item_userid " .
	$where . " " . $order . " LIMIT $d, " . $maxrowsperpage;

$sqllist = cot::$db->query($sql);

$pagenav = cot_pagenav('market', $list_url_path, $d, $totalitems, $maxrowsperpage);

$catpatharray[] = array(cot_url('market'), $L['market']);

if(!empty($c))
{
	$catpatharray = array_merge($catpatharray, cot_structure_buildpath('market', $c));
}

$catpath = cot_breadcrumbs($catpatharray, $cfg['homebreadcrumb'], true);

$t->assign(array(
	"SEARCH_ACTION_URL" => cot_url('market', '', '', true),
	"SEARCH_SQ" => cot_inputbox(
        'text',
        'sq',
        !empty($sq) ? htmlspecialchars($sq) : '',
        'class="schstring"'
    ),
	"SEARCH_CAT" => cot_market_selectcat($c, 'c'),
	"SEARCH_SORTER" => cot_selectbox($sort, "sort", array('', 'costasc', 'costdesc'), array($L['market_mostrelevant'], $L['market_costasc'], $L['market_costdesc']), false),
	"PAGENAV_PAGES" => $pagenav['main'],
	"PAGENAV_PREV" => $pagenav['prev'],
	"PAGENAV_NEXT" => $pagenav['next'],
	"PAGENAV_COUNT" => $totalitems,
	"CATALOG" => cot_build_structure_market_tree('', array($c), 0),
	"BREADCRUMBS" => $catpath,
));

foreach($cot_extrafields[$db_market] as $exfld)
{
	$fld_value = cot_import($exfld['field_name'], 'G', 'TXT');
	$fld_value = $db->prep($fld_value);

	$fieldname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields($exfld['field_name'], $exfld, $fld_value);
	$exfld_title = isset($L['market_'.$exfld['field_name'].'_title']) ?  $L['market_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
	$t->assign(array(
		'SEARCH_'.$fieldname => $exfld_val,
		'SEARCH_'.$fieldname.'_TITLE' => $exfld_title,
	));
}

/* === Hook === */
foreach (cot_getextplugins('market.list.search.tags') as $pl)
{
	include $pl;
}
/* ===== */

if(!empty($c) && is_array($structure['market'][$c]))
{
	foreach ($structure['market'][$c] as $field => $val)
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
$extp = cot_getextplugins('market.list.loop');
/* ===== */

$jj = 0;
foreach ($sqllist_rowset as $item)
{
	$jj++;
	$t->assign(cot_generate_usertags($item, 'PRD_ROW_OWNER_'));

	$t->assign(cot_generate_markettags($item, 'PRD_ROW_', $cfg['market']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));
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
foreach (cot_getextplugins('market.list.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$module_body = $t->text('MAIN');

