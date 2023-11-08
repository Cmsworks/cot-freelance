<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=market.tags
 * [END_COT_EXT]
 */

/**
 * simproducts plugin
 *
 * @package simproducts
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('market', 'module');

$sp_t = new XTemplate(cot_tplfile(array('simproducts'), 'plug'));

$simproducts_where = array();
$simproducts_order = array();

$simproducts_where['state'] = "item_state=0";
$simproducts_where['currentproduct'] = "item_id!=".$item['item_id'];

$simproducts_where['similar'] = "MATCH (`item_title`) AGAINST ('*".$db->prep($item['item_title'])."*' IN BOOLEAN MODE)>".$cfg['plugin']['simproducts']['relev'];

$simproducts_order['date'] = "item_date DESC";

/* === Hook === */
foreach (cot_getextplugins('simproducts.query') as $pl)
{
	include $pl;
}
/* ===== */

$simproducts_where = ($simproducts_where) ? 'WHERE ' . implode(' AND ', $simproducts_where) : '';
$simproducts_order = ($simproducts_order) ? 'ORDER BY ' . implode(', ', $simproducts_order) : '';

$sqlsimproducts = $db->query("SELECT * FROM $db_market AS m 
	LEFT JOIN $db_users AS u ON u.user_id=m.item_userid 
	" . $simproducts_where . "
	" . $simproducts_order . "
	LIMIT " . $cfg['plugin']['simproducts']['limit'])->fetchAll();

foreach ($sqlsimproducts as $simprd)
{
	$jj++;
	$sp_t->assign(cot_generate_usertags($simprd, 'SIMPRD_ROW_OWNER_'));

	$sp_t->assign(cot_generate_markettags($simprd, 'SIMPRD_ROW_', $cfg['market']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));
	$sp_t->assign(array(
		"SIMPRD_ROW_ODDEVEN" => cot_build_oddeven($jj),
	));

	/* === Hook === */
	foreach (cot_getextplugins('simproducts.loop') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sp_t->parse("MAIN.SIMPRD_ROW");
}

/* === Hook === */
foreach (cot_getextplugins('simproducts.tags') as $pl)
{
	include $pl;
}
/* ===== */

$sp_t->parse('MAIN');
$t->assign('PRD_SIMPRODUCTS', $sp_t->text('MAIN'));