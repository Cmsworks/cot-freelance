<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.home.sidepanel
Order=4
[END_COT_EXT]
==================== */

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

require_once cot_incfile('sbr', 'plug');

$tt = new XTemplate(cot_tplfile('sbr.admin.home', 'plug', true));

$sbrcount = $db->query("SELECT COUNT(*) FROM $db_sbr WHERE 1");
$sbrcount = $sbrcount->fetchColumn();

$sbrclaims = $db->query("SELECT COUNT(*) FROM $db_sbr WHERE sbr_status='claim'");
$sbrclaims = $sbrclaims->fetchColumn();

$sbrdone = $db->query("SELECT COUNT(*) FROM $db_sbr WHERE sbr_status='done'");
$sbrdone = $sbrdone->fetchColumn();

$tt->assign(array(
	'ADMIN_HOME_SBR_URL' => cot_url('admin', 'm=other&p=sbr'),
	'ADMIN_HOME_SBR_COUNT' => $sbrcount,
	'ADMIN_HOME_CLAIMS_URL' => cot_url('admin', 'm=other&p=sbr&status=claim'),
	'ADMIN_HOME_CLAIMS_COUNT' => $sbrclaims,
	'ADMIN_HOME_DONE_URL' => cot_url('admin', 'm=other&p=sbr&status=done'),
	'ADMIN_HOME_DONE_COUNT' => $sbrdone,
));

$tt->parse('MAIN');

$line = $tt->text('MAIN');
