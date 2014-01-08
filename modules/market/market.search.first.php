<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=search.first
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

if ($cfg['market']['marketsearch'])
{
	$rs['markettitle'] = cot_import($rs['markettitle'], 'D', 'INT');
	$rs['markettext'] = cot_import($rs['markettext'], 'D', 'INT');
	$rs['marketsort'] = cot_import($rs['marketsort'], 'D', 'ALP');
	$rs['marketsort'] = (empty($rs['marketsort'])) ? 'date' : $rs['marketsort'];
	$rs['marketsort2'] = (cot_import($rs['marketsort2'], 'D', 'ALP') == 'DESC') ? 'DESC' : 'ASC';
	$rs['marketsub'] = cot_import($rs['marketsub'], 'D', 'ARR');
	$rs['marketsubcat'] = cot_import($rs['marketsubcat'], 'D', 'BOL') ? 1 : 0;

	if ($rs['markettitle'] < 1 && $rs['markettext'] < 1)
	{
		$rs['markettitle'] = 1;
		$rs['markettext'] = 1;
	}

	if (($tab == 'market' || empty($tab)) && cot_module_active('market'))
	{
		require_once cot_incfile('market', 'module');

		// Making the category list
		$market_cat_list['all'] = $L['plu_allcategories'];
		foreach ($structure['market'] as $cat => $x)
		{
			if ($cat != 'all' && $cat != 'system' && cot_auth('market', $cat, 'R') && $x['group'] == 0)
			{
				$market_cat_list[$cat] = $x['tpath'];
				$market_catauth[] = $db->prep($cat);
			}
		}
		if ($rs['marketsub'][0] == 'all' || !is_array($rs['marketsub']))
		{
			$rs['marketsub'] = array();
			$rs['marketsub'][] = 'all';
		}

		/* === Hook === */
		foreach (cot_getextplugins('market.search.catlist') as $pl)
		{
			include $pl;
		}
		/* ===== */

		$t->assign(array(
			'PLUGIN_MARKET_SEC_LIST' => cot_selectbox($rs['marketsub'], 'rs[marketsub][]', array_keys($market_cat_list), array_values($market_cat_list), false, 'multiple="multiple" style="width:50%"'),
			'PLUGIN_MARKET_RES_SORT' => cot_selectbox($rs['marketsort'], 'rs[marketsort]', array('date', 'title', 'count', 'cat'), array($L['plu_market_res_sort1'], $L['plu_market_res_sort2'], $L['plu_market_res_sort3'], $L['plu_market_res_sort4']), false),
			'PLUGIN_MARKET_RES_SORT_WAY' => cot_radiobox($rs['marketsort2'], 'rs[marketsort2]', array('DESC', 'ASC'), array($L['plu_sort_desc'], $L['plu_sort_asc'])),
			'PLUGIN_MARKET_SEARCH_NAMES' => cot_checkbox(($rs['markettitle'] == 1 || count($rs['marketsub']) == 0), 'rs[markettitle]', $L['plu_market_search_names']),
			'PLUGIN_MARKET_SEARCH_TEXT' => cot_checkbox(($rs['markettext'] == 1 || count($rs['marketsub']) == 0), 'rs[markettext]', $L['plu_market_search_text']),
			'PLUGIN_MARKET_SEARCH_SUBCAT' => cot_checkbox($rs['marketsubcat'], 'rs[marketsubcat]', $L['plu_market_set_subsec']),
		));
		if ($tab == 'market' || (empty($tab) && $cfg['plugin']['search']['extrafilters']))
		{
			$t->parse('MAIN.MARKET_OPTIONS');
		}
	}
}