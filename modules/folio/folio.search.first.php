<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=search.first
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

if ($cfg['folio']['foliosearch'])
{
	$rs['foliotitle'] = cot_import($rs['foliotitle'], 'D', 'INT');
	$rs['foliotext'] = cot_import($rs['foliotext'], 'D', 'INT');
	$rs['foliosort'] = cot_import($rs['foliosort'], 'D', 'ALP');
	$rs['foliosort'] = (empty($rs['foliosort'])) ? 'date' : $rs['foliosort'];
	$rs['foliosort2'] = (cot_import($rs['foliosort2'], 'D', 'ALP') == 'DESC') ? 'DESC' : 'ASC';
	$rs['foliosub'] = cot_import($rs['foliosub'], 'D', 'ARR');
	$rs['foliosubcat'] = cot_import($rs['foliosubcat'], 'D', 'BOL') ? 1 : 0;

	if ($rs['foliotitle'] < 1 && $rs['foliotext'] < 1)
	{
		$rs['foliotitle'] = 1;
		$rs['foliotext'] = 1;
	}

	if (($tab == 'folio' || empty($tab)) && cot_module_active('folio'))
	{
		require_once cot_incfile('folio', 'module');

		// Making the category list
		$folio_cat_list['all'] = $L['plu_allcategories'];
		foreach ($structure['folio'] as $cat => $x)
		{
			if ($cat != 'all' && $cat != 'system' && cot_auth('folio', $cat, 'R') && $x['group'] == 0)
			{
				$folio_cat_list[$cat] = $x['tpath'];
				$folio_catauth[] = $db->prep($cat);
			}
		}
		if ($rs['foliosub'][0] == 'all' || !is_array($rs['foliosub']))
		{
			$rs['foliosub'] = array();
			$rs['foliosub'][] = 'all';
		}

		/* === Hook === */
		foreach (cot_getextplugins('folio.search.catlist') as $pl)
		{
			include $pl;
		}
		/* ===== */

		$t->assign(array(
			'PLUGIN_FOLIO_SEC_LIST' => cot_selectbox($rs['foliosub'], 'rs[foliosub][]', array_keys($folio_cat_list), array_values($folio_cat_list), false, 'multiple="multiple" style="width:50%"'),
			'PLUGIN_FOLIO_RES_SORT' => cot_selectbox($rs['foliosort'], 'rs[foliosort]', array('date', 'title', 'count', 'cat'), array($L['plu_folio_res_sort1'], $L['plu_folio_res_sort2'], $L['plu_folio_res_sort3'], $L['plu_folio_res_sort4']), false),
			'PLUGIN_FOLIO_RES_SORT_WAY' => cot_radiobox($rs['foliosort2'], 'rs[foliosort2]', array('DESC', 'ASC'), array($L['plu_sort_desc'], $L['plu_sort_asc'])),
			'PLUGIN_FOLIO_SEARCH_NAMES' => cot_checkbox(($rs['foliotitle'] == 1 || count($rs['foliosub']) == 0), 'rs[foliotitle]', $L['plu_folio_search_names']),
			'PLUGIN_FOLIO_SEARCH_TEXT' => cot_checkbox(($rs['foliotext'] == 1 || count($rs['foliosub']) == 0), 'rs[foliotext]', $L['plu_folio_search_text']),
			'PLUGIN_FOLIO_SEARCH_SUBCAT' => cot_checkbox($rs['foliosubcat'], 'rs[foliosubcat]', $L['plu_folio_set_subsec']),
		));
		if ($tab == 'folio' || (empty($tab) && $cfg['plugin']['search']['extrafilters']))
		{
			$t->parse('MAIN.FOLIO_OPTIONS');
		}
	}
}