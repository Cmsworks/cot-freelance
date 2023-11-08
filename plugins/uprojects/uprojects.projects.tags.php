<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.tags
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('projects', 'module');
require_once cot_langfile('uprojects', 'plug');

$up_t = new XTemplate(cot_tplfile(array('uprojects'), 'plug'));

$uprojects_where = array();
$uprojects_order = array();

$uprojects_where['state'] = "item_state=0";
$uprojects_where['owner'] = "item_userid=".$item['item_userid'];
$uprojects_where['currentproject'] = "item_id!=".$item['item_id'];

$uprojects_order['date'] = "item_date DESC";

/* === Hook === */
foreach (cot_getextplugins('uprojects.query') as $pl)
{
	include $pl;
}
/* ===== */

$uprojects_where = ($uprojects_where) ? 'WHERE ' . implode(' AND ', $uprojects_where) : '';
$uprojects_order = ($uprojects_order) ? 'ORDER BY ' . implode(', ', $uprojects_order) : '';

$sqluprojects = $db->query("SELECT * FROM $db_projects AS p 
	LEFT JOIN $db_users AS u ON u.user_id=p.item_userid 
	" . $uprojects_where . "
	" . $uprojects_order . "
	LIMIT " . $cfg['plugin']['uprojects']['limit'])->fetchAll();

if(count($sqluprojects) > 0)
{
	foreach ($sqluprojects as $uprj)
	{
		$jj++;
		$up_t->assign(cot_generate_usertags($uprj, 'PRJ_ROW_OWNER_'));

		$up_t->assign(cot_generate_projecttags($uprj, 'PRJ_ROW_', $cfg['projects']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));
		$up_t->assign(array(
			"PRJ_ROW_ODDEVEN" => cot_build_oddeven($jj),
		));

		/* === Hook === */
		foreach (cot_getextplugins('uprojects.loop') as $pl)
		{
			include $pl;
		}
		/* ===== */

		$up_t->parse("MAIN.PRJ_ROW");
	}

	/* === Hook === */
	foreach (cot_getextplugins('uprojects.tags') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$up_t->parse('MAIN');
	$t->assign('PRJ_UPROJECTS', $up_t->text('MAIN'));
}