<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=sitemap.main
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

if ($cfg['projects']['prjsitemap'])
{
	
	// Sitemap for projects module
	require_once cot_incfile('projects', 'module');

	// Projects categories
	$auth_cache = array();

	$category_list = $structure['projects'];

	/* === Hook === */
	foreach (cot_getextplugins('projects.sitemap.categorylist') as $pl)
	{
		include $pl;
	}
	/* ===== */

	foreach ($category_list as $c => $cat)
	{
		$auth_cache[$c] = cot_auth('projects', $c, 'R');
		if (!$auth_cache[$c]) continue;

		sitemap_parse($t, $items, array(
			'url'  => cot_url('projects', "c=$c"),
			'date' => '', // omit
			'freq' => $cfg['projects']['prjsitemap_freq'],
			'prio' => $cfg['projects']['prjsitemap_prio']
		));
	}

	// Projects
	$sitemap_join_columns = '';
	$sitemap_join_tables = '';
	$sitemap_where = array();
	$sitemap_where['state'] = 'item_state = 0';

	/* === Hook === */
	foreach (cot_getextplugins('projects.sitemap.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sitemap_where = count($sitemap_where) > 0 ? 'WHERE ' . join(' AND ', $sitemap_where) : '';
	$res = $db->query("SELECT p.item_id, p.item_alias, p.item_cat $sitemap_join_columns
		FROM $db_projects AS p $sitemap_join_tables
		$sitemap_where
		ORDER BY p.item_cat, p.item_id");
	foreach ($res->fetchAll() as $row)
	{
		if (!$auth_cache[$row['item_cat']]) continue;
		$urlp = array('c' => $row['item_cat']);
		if(!empty($row['item_alias'])){
			$urlp['al'] = $row['item_alias'];
		}else{
			$urlp['id'] = $row['item_id'];
		}
		sitemap_parse($t, $items, array(
			'url'  => cot_url('projects', $urlp),
			'date' => $row['item_date'],
			'freq' => $cfg['projects']['prjsitemap_freq'],
			'prio' => $cfg['projects']['prjsitemap_prio']
		));
	}
}
