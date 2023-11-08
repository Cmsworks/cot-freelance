<?php
/**
 * support
 *
 * @package support
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forms');

$status = cot_import('status', 'G', 'ALP');

if(empty($status)) $status = 'open';

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'support');

list($pn, $d, $d_url) = cot_import_pagenav('d', $cfg['maxrowsperpage']);

/* === Hook === */
foreach (cot_getextplugins('support.list.first') as $pl)
{
	include $pl;
}
/* ===== */

$out['subtitle'] = $L['support'];
$out['head'] .= $R['code_noindex'];

$mskin = cot_tplfile(array('support', 'list'), 'plug');

/* === Hook === */
foreach (cot_getextplugins('support.list.main') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

$patharray[] = array(cot_url('support'), $L['support']);

$where = array();
$order = array();

if(!empty($status) && $status != 'all')
{
	$where['status'] = "ticket_status='".$status."'";
}

if(!$usr['isadmin'])
{
	$where['userid'] = "ticket_userid=".$usr['id'];
}

$order['update'] = "ticket_update DESC";
$order['date'] = "ticket_date DESC";

/* === Hook === */
foreach (cot_getextplugins('support.list.query') as $pl)
{
	include $pl;
}
/* ===== */

$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
$order = ($order) ? 'ORDER BY ' . implode(', ', $order) : '';

$totalitems = $db->query("SELECT COUNT(*) FROM $db_support_tickets 
	" . $where . "")->fetchColumn();

$sqllist = $db->query("SELECT * FROM $db_support_tickets AS t 
	LEFT JOIN $db_users AS u ON u.user_id=t.ticket_userid
	" . $where . "
	" . $order . "
	LIMIT $d, " . $cfg['maxrowsperpage']);

$pagenav = cot_pagenav('support', '', $d, $totalitems, $cfg['maxrowsperpage']);

$sqllist_rowset = $sqllist->fetchAll();

$tickets_open = $db->query("SELECT COUNT(*) FROM $db_support_tickets WHERE ticket_userid=".$usr['id']." AND ticket_status='open'")->fetchColumn();

$t->assign(array(
	'SUPPORT_TITLE' => cot_breadcrumbs($patharray, $cfg['homebreadcrumb'], true),
	'SUPPORT_COUNT_OPEN' => $tickets_open,
	'PAGENAV_PAGES' => $pagenav['main'],
	'PAGENAV_PREV' => $pagenav['prev'],
	'PAGENAV_NEXT' => $pagenav['next'],
	'PAGENAV_COUNT' => $totalitems,
));

/* === Hook === */
$extp = cot_getextplugins('support.list.loop');
/* ===== */

foreach ($sqllist_rowset as $ticket)
{
	$jj++;
	$t->assign(cot_generate_usertags($ticket, 'TICKET_ROW_USER_'));

	$lastpost = $db->query("SELECT * FROM $db_support_messages AS m
		LEFT JOIN $db_users AS u ON u.user_id=m.msg_userid
		WHERE msg_tid=".$ticket['ticket_id']." ORDER BY msg_date DESC LIMIT 1")->fetch();

	if($lastpost){
		$t->assign(cot_generate_usertags($lastpost, 'TICKET_ROW_LASTPOSTER_'));
	}
	
	$t->assign(array(
		'TICKET_ROW_ID' => $ticket['ticket_id'],
		'TICKET_ROW_TITLE' => $ticket['ticket_title'],
		'TICKET_ROW_STATUS' => $ticket['ticket_status'],
		'TICKET_ROW_COUNT' => $ticket['ticket_count'],
		'TICKET_ROW_DATE' => $ticket['ticket_date'],
		'TICKET_ROW_UPDATE' => $ticket['ticket_update'],
		'TICKET_ROW_URL' => cot_url('support', 'id='.$ticket['ticket_id']),
	));
	
	/* === Hook - Part2 : Include === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse("MAIN.TICKET_ROW");
}

/* === Hook === */
foreach (cot_getextplugins('support.list.tags') as $pl)
{
	include $pl;
}
/* ===== */