<?php

defined('COT_CODE') or die('Wrong URL');

// Requirements
require_once cot_langfile('vizitedprojects', 'plug');

function vizitedprojects()
{
	global $db, $cfg, $db_users, $db_projects;

	require_once cot_incfile('projects', 'module');

	$t = new XTemplate(cot_tplfile(array('vizitedprojects'), 'plug'));

	$vizitedprojects = cot_import('vizitedprojects', 'C', 'TXT');

	if(!empty($vizitedprojects))
	{
		$vizitedprojects_where = array();
		$vizitedprojects_order = array();

		$vizitedprojects_where['state'] = "item_state=0";
		$vizitedprojects_where['vizitedprojects'] = "item_id IN (".$vizitedprojects.")";

		$vizitedprojects_order['date'] = "item_date DESC";

		/* === Hook === */
		foreach (cot_getextplugins('vizitedprojects.query') as $pl)
		{
			include $pl;
		}
		/* ===== */

		$vizitedprojects_where = ($vizitedprojects_where) ? 'WHERE ' . implode(' AND ', $vizitedprojects_where) : '';
		$vizitedprojects_order = ($vizitedprojects_order) ? 'ORDER BY ' . implode(', ', $vizitedprojects_order) : '';

		$sqlvizitedprojects = $db->query("SELECT * FROM $db_projects AS p 
			LEFT JOIN $db_users AS u ON u.user_id=p.item_userid 
			" . $vizitedprojects_where . "
			" . $vizitedprojects_order . "
			LIMIT " . $cfg['plugin']['vizitedprojects']['limit'])->fetchAll();

		if(count($sqlvizitedprojects) > 0)
		{
			foreach ($sqlvizitedprojects as $vprj)
			{
				$jj++;
				$t->assign(cot_generate_usertags($vprj, 'PRJ_ROW_OWNER_'));

				$t->assign(cot_generate_projecttags($vprj, 'PRJ_ROW_', $cfg['market']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));
				$t->assign(array(
					"PRJ_ROW_ODDEVEN" => cot_build_oddeven($jj),
				));

				/* === Hook === */
				foreach (cot_getextplugins('vizitedprojects.loop') as $pl)
				{
					include $pl;
				}
				/* ===== */

				$t->parse("MAIN.PRJ_ROW");
			}

			/* === Hook === */
			foreach (cot_getextplugins('vizitedprojects.tags') as $pl)
			{
				include $pl;
			}
			/* ===== */

			$t->parse('MAIN');

			return $t->text('MAIN');
		}
	}
}