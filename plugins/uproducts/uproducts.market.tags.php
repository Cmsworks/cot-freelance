<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=market.tags
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('market', 'module');
require_once cot_langfile('uproducts', 'plug');

$up_t = new XTemplate(cot_tplfile(array('uproducts'), 'plug'));

$uproducts_where = array();
$uproducts_order = array();

$uproducts_where['state'] = "item_state=0";
$uproducts_where['owner'] = "item_userid=".$item['item_userid'];
$uproducts_where['currentproduct'] = "item_id!=".$item['item_id'];

$uproducts_order['date'] = "item_date DESC";

/* === Hook === */
foreach (cot_getextplugins('uproducts.query') as $pl)
{
	include $pl;
}
/* ===== */

$uproducts_where = ($uproducts_where) ? 'WHERE ' . implode(' AND ', $uproducts_where) : '';
$uproducts_order = ($uproducts_order) ? 'ORDER BY ' . implode(', ', $uproducts_order) : '';

$sqluproducts = $db->query("SELECT * FROM $db_market AS m 
	LEFT JOIN $db_users AS u ON u.user_id=m.item_userid 
	" . $uproducts_where . "
	" . $uproducts_order . "
	LIMIT " . $cfg['plugin']['uproducts']['limit'])->fetchAll();

if(count($sqluproducts) > 0)
{
	foreach ($sqluproducts as $uprd)
	{
		$jj++;
		$up_t->assign(cot_generate_usertags($uprd, 'PRD_ROW_OWNER_'));

		$up_t->assign(cot_generate_markettags($uprd, 'PRD_ROW_', $cfg['market']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));
		$up_t->assign(array(
			"PRD_ROW_ODDEVEN" => cot_build_oddeven($jj),
		));

		/* === Hook === */
		foreach (cot_getextplugins('uproducts.loop') as $pl)
		{
			include $pl;
		}
		/* ===== */

		$up_t->parse("MAIN.PRD_ROW");
	}

	/* === Hook === */
	foreach (cot_getextplugins('uproducts.tags') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$up_t->parse('MAIN');
	$t->assign('PRD_UPRODUCTS', $up_t->text('MAIN'));
}