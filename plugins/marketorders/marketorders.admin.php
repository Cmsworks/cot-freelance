<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=tools
 * [END_COT_EXT]
 */

/**
 * marketorders plugin
 *
 * @package marketorders
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'marketorders', 'RWA');
cot_block($usr['isadmin']);

require_once cot_incfile('marketorders', 'plug');
require_once cot_incfile('market', 'module');
require_once cot_incfile('payments', 'module');
require_once cot_incfile('extrafields');

$status = cot_import('status', 'G', 'ALP');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'marketorders');
cot_block($usr['isadmin']);

if($cfg['plugin']['marketorders']['ordersperpage'] > 0)
{
	list($pn, $d, $d_url) = cot_import_pagenav('d', $cfg['plugin']['marketorders']['ordersperpage']);
}

/* === Hook === */
$extp = cot_getextplugins('marketorders.admin.first');
foreach ($extp as $pl)
{
	include $pl;
}
/* ===== */

$out['subtitle'] = $L['market_sales_title'];
$out['head'] .= $R['code_noindex'];

$mskin = cot_tplfile(array('marketorders', 'admin'), 'plug');

/* === Hook === */
foreach (cot_getextplugins('marketorders.admin.main') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

switch($status)
{

	case 'paid':
		$where['order_status'] = "o.order_status='paid'";
		break;

	case 'done':
		$where['order_status'] = "o.order_status='done'";
		break;

	case 'claim':
		$where['order_status'] = "o.order_status='claim'";
		break;

	case 'cancel':
		$where['order_status'] = "o.order_status='cancel'";
		break;

	case 'new':
		if($cfg['plugin']['marketorders']['showneworderswithoutpayment']) {
			$where['order_status'] = "o.order_status='new'";
		} else {
			$where['order_status'] = "o.order_status!='new'";
		}
		break;

	default:
		if(!$cfg['plugin']['marketorders']['showneworderswithoutpayment']) {
			$where['order_status'] = "o.order_status!='new'";
		}
		break;
}

$order['date'] = 'o.order_date DESC';

/* === Hook === */
foreach (cot_getextplugins('marketorders.admin.query') as $pl)
{
	include $pl;
}
/* ===== */

$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
$order = ($order) ? 'ORDER BY ' . implode(', ', $order) : '';
$query_limit = ($cfg['plugin']['marketorders']['ordersperpage'] > 0) ? "LIMIT $d, ".$cfg['plugin']['marketorders']['ordersperpage'] : '';

$totalitems = $db->query("SELECT COUNT(*) FROM $db_market_orders AS o
	LEFT JOIN $db_market AS m ON o.order_pid=m.item_id
	" . $where . "")->fetchColumn();

$sql = $db->query("SELECT * FROM $db_market_orders AS o
	LEFT JOIN $db_market AS m ON o.order_pid=m.item_id
	" . $where . "
	" . $order . "
	" . $query_limit . "");

$pagenav = cot_pagenav('admin', 'm=other&p=marketorders&status=' . $status, $d, $totalitems, $cfg['plugin']['marketorders']['ordersperpage']);

$t->assign(array(
	"PAGENAV_COUNT" => $totalitems,
	"PAGENAV_PAGES" => $pagenav['main'],
	"PAGENAV_PREV" => $pagenav['prev'],
	"PAGENAV_NEXT" => $pagenav['next'],
));

/* === Hook === */
$extp = cot_getextplugins('marketorders.admin.loop');
/* ===== */

while ($marketorder = $sql->fetch())
{
	$t->assign(cot_generate_markettags($marketorder, 'ORDER_ROW_PRD_'));
	$t->assign(cot_generate_usertags($marketorder['order_seller'], 'ORDER_ROW_SELLER_'));

	if($marketorder['order_userid'] > 0)
	{
		$t->assign(cot_generate_usertags($marketorder['order_userid'], 'ORDER_ROW_CUSTOMER_'));
	}

	$t->assign(array(
		"ORDER_ROW_ID" => $marketorder['order_id'],
		"ORDER_ROW_URL" => cot_url('marketorders','m=order&id='.$marketorder['order_id']),
		"ORDER_ROW_COUNT" => $marketorder['order_count'],
		"ORDER_ROW_COST" => $marketorder['order_cost'],
		"ORDER_ROW_COMMENT" => $marketorder['order_text'],
		"ORDER_ROW_EMAIL" => $marketorder['order_email'],
		"ORDER_ROW_DATE" => $marketorder['order_date'],
		"ORDER_ROW_PAID" => $marketorder['order_paid'],
		"ORDER_ROW_STATUS" => $marketorder['order_status'],
		"ORDER_ROW_WARRANTYDATE" => $marketorder['order_paid'] + $cfg['market']['warranty']*60*60*24,
	));

	/* === Hook - Part2 : Include === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse("MAIN.ORDER_ROW");
}

/* === Hook === */
foreach (cot_getextplugins('marketorders.admin.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse("MAIN");
$plugin_body .= $t->text("MAIN");
