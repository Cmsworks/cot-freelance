<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=sitemap.main
 * [END_COT_EXT]
 */

/**
 * folio module
 *
 * @package folio
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

if ($cfg['folio']['foliositemap'])
{
	
	// Sitemap for folio module
	require_once cot_incfile('folio', 'module');

	// Projects categories
	$auth_cache = array();

	$category_list = $structure['folio'];

	/* === Hook === */
	foreach (cot_getextplugins('folio.sitemap.categorylist') as $pl)
	{
		include $pl;
	}
	/* ===== */

	foreach ($category_list as $c => $cat)
	{
		$auth_cache[$c] = cot_auth('folio', $c, 'R');
		if (!$auth_cache[$c]) continue;

		sitemap_parse($t, $items, array(
			'url'  => cot_url('folio', "c=$c"),
			'date' => '', // omit
			'freq' => $cfg['folio']['foliositemap_freq'],
			'prio' => $cfg['folio']['foliositemap_prio']
		));
	}

	// Projects
	$sitemap_join_columns = '';
	$sitemap_join_tables = '';
	$sitemap_where = array();
	$sitemap_where['state'] = 'item_state = 0';

	/* === Hook === */
	foreach (cot_getextplugins('folio.sitemap.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sitemap_where = count($sitemap_where) > 0 ? 'WHERE ' . join(' AND ', $sitemap_where) : '';
	$res = $db->query("SELECT f.item_id, f.item_alias, f.item_cat $sitemap_join_columns
		FROM $db_folio AS f $sitemap_join_tables
		$sitemap_where
		ORDER BY f.item_cat, f.item_id");
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
			'url'  => cot_url('folio', $urlp),
			'date' => $row['item_date'],
			'freq' => $cfg['folio']['foliositemap_freq'],
			'prio' => $cfg['folio']['foliositemap_prio']
		));
	}
}