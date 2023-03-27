<?php
/**
 * Add sbr.
 *
 * @package sbr
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forms');

$status = cot_import('status', 'G', 'ALP');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'sbr');
cot_block($usr['auth_read']);

list($pn, $d, $d_url) = cot_import_pagenav('d', $cfg['plugin']['sbr']['maxrowsperpage']);

/* === Hook === */
foreach (cot_getextplugins('sbr.list.first') as $pl)
{
	include $pl;
}
/* ===== */

$out['subtitle'] = $L['sbr_mydeals'];
$out['head'] .= $R['code_noindex'];

$mskin = cot_tplfile(array('sbr', 'list', $status), 'plug');

/* === Hook === */
foreach (cot_getextplugins('sbr.list.main') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

$patharray[] = array(cot_url('sbr'), $L['sbr']);

$t->assign(array(
	'SBR_TITLE' => cot_breadcrumbs($patharray, $cfg['homebreadcrumb'], true),
	'SBR_COUNTERS' => cot_sbr_counters()
));

$where = array();
$order = array();

if(!empty($status))
{
	$where['status'] = "sbr_status='" . $db->prep($status) . "'";
}

$where['userid'] = "(sbr_employer=" . $usr['id'] . " OR sbr_performer=" . $usr['id'] . ")";

$order['date'] = "sbr_create DESC";

/* === Hook === */
foreach (cot_getextplugins('sbr.list.query') as $pl)
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
$extp = cot_getextplugins('sbr.list.loop');
/* ===== */

foreach ($sqllist_rowset as $sbr)
{
	$jj++;
	$t->assign(cot_generate_usertags($sbr['sbr_employer'], 'SBR_ROW_EMPLOYER_'));
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

/* === Hook === */
foreach (cot_getextplugins('sbr.list.tags') as $pl)
{
	include $pl;
}
/* ===== */
