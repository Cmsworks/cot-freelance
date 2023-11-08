<?php

defined('COT_CODE') or die('Wrong URL');

// Requirements
require_once cot_langfile('vizitedproducts', 'plug');

function vizitedproducts()
{
	global $db, $cfg, $db_users, $db_market;

	require_once cot_incfile('market', 'module');

	$t = new XTemplate(cot_tplfile(array('vizitedproducts'), 'plug'));

	$vizitedproducts = cot_import('vizitedproducts', 'C', 'TXT');

	if(!empty($vizitedproducts))
	{
		$vizitedproducts_where = array();
		$vizitedproducts_order = array();

		$vizitedproducts_where['state'] = "item_state=0";
		$vizitedproducts_where['vizitedproducts'] = "item_id IN (".$vizitedproducts.")";

		$vizitedproducts_order['date'] = "item_date DESC";

		/* === Hook === */
		foreach (cot_getextplugins('vizitedproducts.query') as $pl)
		{
			include $pl;
		}
		/* ===== */

		$vizitedproducts_where = ($vizitedproducts_where) ? 'WHERE ' . implode(' AND ', $vizitedproducts_where) : '';
		$vizitedproducts_order = ($vizitedproducts_order) ? 'ORDER BY ' . implode(', ', $vizitedproducts_order) : '';

		$sqlvizitedproducts = $db->query("SELECT * FROM $db_market AS m 
			LEFT JOIN $db_users AS u ON u.user_id=m.item_userid 
			" . $vizitedproducts_where . "
			" . $vizitedproducts_order . "
			LIMIT " . $cfg['plugin']['vizitedproducts']['limit'])->fetchAll();

		if(count($sqlvizitedproducts) > 0)
		{
			foreach ($sqlvizitedproducts as $vprd)
			{
				$jj++;
				$t->assign(cot_generate_usertags($vprd, 'PRD_ROW_OWNER_'));

				$t->assign(cot_generate_markettags($vprd, 'PRD_ROW_', $cfg['market']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));
				$t->assign(array(
					"PRD_ROW_ODDEVEN" => cot_build_oddeven($jj),
				));

				/* === Hook === */
				foreach (cot_getextplugins('vizitedproducts.loop') as $pl)
				{
					include $pl;
				}
				/* ===== */

				$t->parse("MAIN.PRD_ROW");
			}

			/* === Hook === */
			foreach (cot_getextplugins('vizitedproducts.tags') as $pl)
			{
				include $pl;
			}
			/* ===== */

			$t->parse('MAIN');

			return $t->text('MAIN');
		}
	}
}