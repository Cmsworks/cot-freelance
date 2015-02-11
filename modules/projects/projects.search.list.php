<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=search.list
 * [END_COT_EXT]
 */

/**
 * projects module
 *
 * @package projects
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

if ($cfg['projects']['prjsearch'] && ($tab == 'projects' || empty($tab)) && cot_module_active('projects') && !cot_error_found())
{
	if ($rs['projectssub'][0] != 'all' && count($rs['projectssub']) > 0)
	{
		if ($rs['projectssubcat'])
		{
			$tempcat = array();
			foreach ($rs['projectssub'] as $scat)
			{
				$tempcat = array_merge(cot_structure_children('projects', $scat), $tempcat);
			}
			$tempcat = array_unique($tempcat);
			$where_and['cat'] = "item_cat IN ('".implode("','", $tempcat)."')";
		}
		else
		{
			$tempcat = array();
			foreach ($rs['projectssub'] as $scat)
			{
				$tempcat[] = $db->prep($scat);
			}
			$where_and['cat'] = "item_cat IN ('".implode("','", $tempcat)."')";
		}
	}
	else
	{
		$where_and['cat'] = "item_cat IN ('".implode("','", $prj_catauth)."')";
	}
	$where_and['state'] = "item_state = 0";
	$where_and['date'] = ($rs['setlimit'] > 0) ? "item_date >= ".$rs['setfrom']." AND item_date <= ".$rs['setto'] : "";
	$where_and['users'] = (!empty($touser)) ? "item_ownerid ".$touser_ids : "";

	$where_or['title'] = ($rs['prjtitle'] == 1) ? "item_title LIKE '".$db->prep($sqlsearch)."'" : "";
	$where_or['text'] = (($rs['prjtext'] == 1)) ? "item_text LIKE '".$db->prep($sqlsearch)."'" : "";
	// String query for addition projects fields.
	foreach (explode(',', trim($cfg['plugin']['search']['addfields'])) as $addfields_el)
	{
		$addfields_el = trim($addfields_el);
		$where_or[$addfields_el] .= ( (!empty($addfields_el))) ? $addfields_el." LIKE '".$sqlsearch."'" : "";
	}
	$where_or = array_diff($where_or, array(''));
	count($where_or) || $where_or['title'] = "item_title LIKE '".$db->prep($sqlsearch)."'";
	$where_and['or'] = '('.implode(' OR ', $where_or).')';
	$where_and = array_diff($where_and, array(''));
	$where = implode(' AND ', $where_and);

	/* === Hook === */
	foreach (cot_getextplugins('projects.search.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!$db->fieldExists($db_projects, 'item_'.$rs['prjsort']))
	{
		$rs['prjsort'] = 'date';
	}

	$sqllist = $db->query("SELECT SQL_CALC_FOUND_ROWS p.* $search_join_columns
		FROM $db_projects AS p $search_join_condition
		WHERE $where
		ORDER BY item_".$rs['prjsort']." ".$rs['prjsort2']."
		LIMIT $d, ".$cfg_maxitems
			.$search_union_query);

	$items = $sql->rowCount();
	$totalitems[] = $db->query('SELECT FOUND_ROWS()')->fetchColumn();
	$jj = 0;
	
	$sqllist_rowset = $sqllist->fetchAll();
	$sqllist_idset = array();
	foreach($sqllist_rowset as $item)
	{
		$sqllist_idset[$item['item_id']] = $item['item_alias'];
	}
	
	/* === Hook - Part 1 === */
	$extp = cot_getextplugins('projects.search.loop');
	/* ===== */
	foreach($sqllist_rowset as $row)
	{
		$url_cat = cot_url('projects', 'c='.$row['item_cat']);
		$url_prj = empty($row['item_alias']) ? cot_url('projects', 'c='.$row['item_cat'].'&id='.$row['item_id'].'&highlight='.$hl) : cot_url('projects', 'c='.$row['item_cat'].'&al='.$row['item_alias'].'&highlight='.$hl);
		$t->assign(cot_generate_projecttags($row, 'PLUGIN_PROJECTSRES_'));
		$t->assign(array(
			'PLUGIN_PROJECTSRES_CATEGORY' => cot_rc_link($url_cat, $structure['projects'][$row['item_cat']]['tpath']),
			'PLUGIN_PROJECTSRES_CATEGORY_URL' => $url_cat,
			'PLUGIN_PROJECTSRES_TITLE' => cot_rc_link($url_prj, htmlspecialchars($row['item_title'])),
			'PLUGIN_PROJECTSRES_TEXT' => cot_clear_mark($row['item_text'], $words),
			'PLUGIN_PROJECTSRES_TIME' => cot_date('datetime_medium', $row['item_date']),
			'PLUGIN_PROJECTSRES_TIMESTAMP' => $row['item_date'],
			'PLUGIN_PROJECTSRES_ODDEVEN' => cot_build_oddeven($jj),
			'PLUGIN_PROJECTSRES_NUM' => $jj
		));
		/* === Hook - Part 2 === */
		foreach ($extp as $pl)
		{
			include $pl;
		}
		/* ===== */
		$t->parse('MAIN.RESULTS.PROJECTS.ITEM');
		$jj++;
	}
	if ($jj > 0)
	{
		$t->parse('MAIN.RESULTS.PROJECTS');
	}
	unset($where_and, $where_or, $where);
}