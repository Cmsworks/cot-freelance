<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=tools
 * [END_COT_EXT]
 */

/**
 * Sbr plugin
 *
 * @package sbr
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');


list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'sbr', 'RWA');
cot_block($usr['isadmin']);

require_once cot_incfile('sbr', 'plug');
require_once cot_incfile('projects', 'module');
require_once cot_incfile('payments', 'module');
require_once cot_incfile('extrafields');

$status = cot_import('status', 'G', 'ALP');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'sbr');
cot_block($usr['isadmin']);

list($pn, $d, $d_url) = cot_import_pagenav('d', $cfg['plugin']['sbr']['maxrowsperpage']);

/* === Hook === */
foreach (cot_getextplugins('sbr.admin.list.first') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate(cot_tplfile('sbr.admin.default', 'plug'));

/* === Hook === */
foreach (cot_getextplugins('sbr.admin.list.main') as $pl)
{
	include $pl;
}
/* ===== */

foreach($R['sbr_statuses'] as $st)
{
	$t->assign(array(
		'STATUS_ROW_ID' => $st,
		'STATUS_ROW_TITLE' => $L['sbr_deals_'.$st],
	));
	
	$t->parse('MAIN.STATUS_ROW');
}

$where = array();
$order = array();

if(!empty($status))
{
	$where['status'] = "sbr_status='" . $db->prep($status) . "'";
}

//$where['userid'] = "(sbr_employer=" . $usr['id'] . " OR sbr_performer=" . $usr['id'] . ")";

$order['date'] = "sbr_create DESC";

/* === Hook === */
foreach (cot_getextplugins('sbr.admin.list.query') as $pl)
{
	include $pl;
}
/* ===== */

$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
$order = ($order) ? 'ORDER BY ' . implode(', ', $order) : '';

$totalitems = $db->query("SELECT COUNT(*) FROM $db_sbr 
	" . $where . "")->fetchColumn();

$sqllist = $db->query("SELECT * FROM $db_sbr AS s 
	" . $where . "
	" . $order . "
	LIMIT $d, " . $cfg['plugin']['sbr']['maxrowsperpage']);

$pagenav = cot_pagenav('sbr', '', $d, $totalitems, $cfg['plugin']['sbr']['maxrowsperpage']);

$sqllist_rowset = $sqllist->fetchAll();

/* === Hook === */
$extp = cot_getextplugins('sbr.admin.list.loop');
/* ===== */

foreach ($sqllist_rowset as $sbr)
{
	$jj++;
	$t->assign(cot_generate_usertags($sbr['sbr_employer'], 'SBR_ROW_employer_'));
	$t->assign(cot_generate_usertags($sbr['sbr_performer'], 'SBR_ROW_PERFORMER_'));
	$t->assign(cot_generate_sbrtags($sbr, 'SBR_ROW_'));

	/* === Hook - Part2 : Include === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse("MAIN.SBR_ROW");
}

$t->parse("MAIN");
$plugin_body .= $t->text("MAIN");