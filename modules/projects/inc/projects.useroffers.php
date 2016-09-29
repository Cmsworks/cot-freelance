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

defined('COT_CODE') or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin'], $usr['auth_offers']) = cot_auth('projects', 'any', 'RWA1');
cot_block($usr['auth_offers']);

$choise = cot_import('choise', 'G', 'ALP');

if($cfg['projects']['offersperpage'] > 0)
{
	list($pn, $d, $d_url) = cot_import_pagenav('d', $cfg['projects']['offersperpage']);
}
/* === Hook === */
foreach (cot_getextplugins('projects.useroffers.first') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate(cot_tplfile(array('projects', 'useroffers')));

$out['subtitle'] = $L['offers_useroffers'];

$where['userid'] = "o.offer_userid=" . $usr['id'];

switch($choise)
{
	case 'none':
		$where['offer_choise'] = "o.offer_choise=''";
		break;
	
	case 'performer':
		$where['offer_choise'] = "o.offer_choise='performer'";
		break;
	
	case 'refuse':
		$where['offer_choise'] = "o.offer_choise='refuse'";
		break;
}

$order['date'] = 'o.offer_date DESC';

/* === Hook === */
foreach (cot_getextplugins('projects.list.query') as $pl)
{
	include $pl;
}
/* ===== */

$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
$order = ($order) ? 'ORDER BY ' . implode(', ', $order) : '';
$query_limit = ($cfg['projects']['offersperpage'] > 0) ? "LIMIT $d, ".$cfg['projects']['offersperpage'] : '';

$totalitems = $db->query("SELECT COUNT(*) FROM $db_projects_offers AS o 
	LEFT JOIN $db_projects AS p ON o.offer_pid=p.item_id
	" . $where . "")->fetchColumn();

$sql = $db->query("SELECT o.* FROM $db_projects_offers AS o
	LEFT JOIN $db_projects AS p ON o.offer_pid=p.item_id
	" . $where . "
	" . $order . "
	" . $query_limit . "");

if($cfg['projects']['offersperpage'] > 0)
{
	$pagenav = cot_pagenav('projects', 'm=useroffers&choise=' . $choise, $d, $totalitems, $cfg['projects']['offersperpage']);
	
	$t->assign(array(
		"PAGENAV_PAGES" => $pagenav['main'],
		"PAGENAV_PREV" => $pagenav['prev'],
		"PAGENAV_NEXT" => $pagenav['next'],
	));
}

$catpatharray[] = array(cot_url('projects'), $L['projects']);
$catpatharray[] = array('', $L['offers_useroffers']);
$catpath = cot_breadcrumbs($catpatharray, $cfg['homebreadcrumb'], true);

$t->assign(array(
	"BREADCRUMBS" => $catpath,
));

/* === Hook === */
$extp = cot_getextplugins('projects.useroffers.loop');
/* ===== */

while ($offer = $sql->fetch())
{
	$t->assign(cot_generate_projecttags($offer['offer_pid'], 'OFFER_ROW_PROJECT_'));
	$t->assign(array(
		"OFFER_ROW_DATE" => date('d.m.Y H:i', $offer['offer_date']),
		"OFFER_ROW_TEXT" => cot_parse($offer['offer_text']),
		"OFFER_ROW_COSTMIN" => (floor($offer['offer_cost_min']) != $offer['offer_cost_min']) ? number_format($offer['offer_cost_min'], '2', '.', ' ') : number_format($offer['offer_cost_min'], '0', '.', ' '),
		"OFFER_ROW_COSTMAX" => (floor($offer['offer_cost_max']) != $offer['offer_cost_max']) ? number_format($offer['offer_cost_max'], '2', '.', ' ') : number_format($offer['offer_cost_max'], '0', '.', ' '),
		"OFFER_ROW_TIMEMIN" => $offer['offer_time_min'],
		"OFFER_ROW_TIMEMAX" => $offer['offer_time_max'],
		"OFFER_ROW_TIMETYPE" => $L['offers_timetype'][$offer['offer_time_type']],
		"OFFER_ROW_CHOISE" => $offer['offer_choise'],
	));
	
	/* === Hook - Part2 : Include === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	$t->parse("MAIN.OFFER_ROWS");
}

/* === Hook === */
foreach (cot_getextplugins('projects.useroffers.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse("MAIN");
$module_body = $t->text('MAIN');