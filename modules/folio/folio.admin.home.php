<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.home.sidepanel
Order=3
[END_COT_EXT]
==================== */

/**
 * folio module
 *
 * @package folio
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('folio', 'module');

$tt = new XTemplate(cot_tplfile('folio.admin.home', 'module', true));

$publicfolio = $db->query("SELECT COUNT(*) FROM $db_folio WHERE item_state='0'");
$publicfolio = $publicfolio->fetchColumn();

$hiddenfolio = $db->query("SELECT COUNT(*) FROM $db_folio WHERE item_state='1'");
$hiddenfolio = $hiddenfolio->fetchColumn();

$folioqueued = $db->query("SELECT COUNT(*) FROM $db_folio WHERE item_state='2'");
$folioqueued = $folioqueued->fetchColumn();

$tt->assign(array(
	'ADMIN_HOME_FOLIO_QUEUED_URL' => cot_url('admin', 'm=folio&state=2'),
	'ADMIN_HOME_FOLIO_PUBLIC_URL' => cot_url('admin', 'm=folio&state=0'),
	'ADMIN_HOME_FOLIO_HIDDEN_URL' => cot_url('admin', 'm=folio&state=1'),
	'ADMIN_HOME_FOLIO_QUEUED' => $folioqueued,
	'ADMIN_HOME_FOLIO_PUBLIC' => $publicfolio,
	'ADMIN_HOME_FOLIO_HIDDEN' => $hiddenfolio,
));

$tt->parse('MAIN');

$line = $tt->text('MAIN');