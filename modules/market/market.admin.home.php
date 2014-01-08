<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.home.sidepanel
Order=2
[END_COT_EXT]
==================== */

/**
 * market module
 *
 * @package market
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('market', 'module');

$tt = new XTemplate(cot_tplfile('market.admin.home', 'module', true));

$publicmarket = $db->query("SELECT COUNT(*) FROM $db_market WHERE item_state='0'");
$publicmarket = $publicmarket->fetchColumn();

$hiddenmarket = $db->query("SELECT COUNT(*) FROM $db_market WHERE item_state='1'");
$hiddenmarket = $hiddenmarket->fetchColumn();

$marketqueued = $db->query("SELECT COUNT(*) FROM $db_market WHERE item_state='2'");
$marketqueued = $marketqueued->fetchColumn();

$tt->assign(array(
	'ADMIN_HOME_MARKET_QUEUED_URL' => cot_url('admin', 'm=market&state=2'),
	'ADMIN_HOME_MARKET_PUBLIC_URL' => cot_url('admin', 'm=market&state=0'),
	'ADMIN_HOME_MARKET_HIDDEN_URL' => cot_url('admin', 'm=market&state=1'),
	'ADMIN_HOME_MARKET_QUEUED' => $marketqueued,
	'ADMIN_HOME_MARKET_PUBLIC' => $publicmarket,
	'ADMIN_HOME_MARKET_HIDDEN' => $hiddenmarket,
));

$tt->parse('MAIN');

$line = $tt->text('MAIN');