<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=sitemap.main
 * [END_COT_EXT]
 */

/**
 * market module
 *
 * @package market
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

if ($cfg['market']['marketsitemap'])
{
	
	// Sitemap for market module
	require_once cot_incfile('market', 'module');

	// Projects categories
	$auth_cache = array();

	$category_list = $structure['market'];

	/* === Hook === */
	foreach (cot_getextplugins('market.sitemap.categorylist') as $pl)
	{
		include $pl;
	}
	/* ===== */

	foreach ($category_list as $c => $cat)
	{
		$auth_cache[$c] = cot_auth('market', $c, 'R');
		if (!$auth_cache[$c]) continue;

		sitemap_parse($t, $items, array(
			'url'  => cot_url('market', "c=$c"),
			'date' => '', // omit
			'freq' => $cfg['market']['marketsitemap_freq'],
			'prio' => $cfg['market']['marketsitemap_prio']
		));
	}

	// Projects
	$sitemap_join_columns = '';
	$sitemap_join_tables = '';
	$sitemap_where = array();
	$sitemap_where['state'] = 'item_state = 0';

	/* === Hook === */
	foreach (cot_getextplugins('market.sitemap.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sitemap_where = count($sitemap_where) > 0 ? 'WHERE ' . join(' AND ', $sitemap_where) : '';
	$res = $db->query("SELECT m.item_id, m.item_alias, m.item_cat $sitemap_join_columns
		FROM $db_market AS m $sitemap_join_tables
		$sitemap_where
		ORDER BY m.item_cat, m.item_id");
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
			'url'  => cot_url('market', $urlp),
			'date' => $row['item_date'],
			'freq' => $cfg['market']['marketsitemap_freq'],
			'prio' => $cfg['market']['marketsitemap_prio']
		));
	}
}