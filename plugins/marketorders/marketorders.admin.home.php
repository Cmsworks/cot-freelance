<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.home.sidepanel
Order=5
[END_COT_EXT]
==================== */

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

require_once cot_incfile('marketorders', 'plug');

$tt = new XTemplate(cot_tplfile('marketorders.admin.home', 'plug', true));

$marketorderscount = $db->query("SELECT COUNT(*) FROM $db_market_orders WHERE 1");
$marketorderscount = $marketorderscount->fetchColumn();

$marketordersclaims = $db->query("SELECT COUNT(*) FROM $db_market_orders WHERE order_status='claim'");
$marketordersclaims = $marketordersclaims->fetchColumn();

$marketordersdone = $db->query("SELECT COUNT(*) FROM $db_market_orders WHERE order_status='done'");
$marketordersdone = $marketordersdone->fetchColumn();

$tt->assign(array(
	'ADMIN_HOME_ORDERS_URL' => cot_url('admin', 'm=other&p=marketorders'),
	'ADMIN_HOME_ORDERS_COUNT' => $marketorderscount,
	'ADMIN_HOME_CLAIMS_URL' => cot_url('admin', 'm=other&p=marketorders&status=claim'),
	'ADMIN_HOME_CLAIMS_COUNT' => $marketordersclaims,
	'ADMIN_HOME_DONE_URL' => cot_url('admin', 'm=other&p=marketorders&status=done'),
	'ADMIN_HOME_DONE_COUNT' => $marketordersdone,
));

$tt->parse('MAIN');

$line = $tt->text('MAIN');
